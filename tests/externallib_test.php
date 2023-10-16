<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

namespace mod_jqshow;

use coding_exception;
use context_module;
use dml_exception;
use external_api;
use externallib_advanced_testcase;
use file_exception;
use invalid_parameter_exception;
use invalid_response_exception;
use mod_jqshow_external;
use stdClass;
use stored_file_creation_exception;

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/webservice/tests/helpers.php');

/**
 *
 * @package     mod_jqshow
 * @author      3&Punt <tresipunt.com>
 * @author      2023 Tomás Zafra <jmtomas@tresipunt.com> | Elena Barrios <elena@tresipunt.com>
 * @category   test
 * @copyright   3iPunt <https://www.tresipunt.com/>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class externallib_test extends externallib_advanced_testcase {

    /**
     * @return void
     * @throws invalid_parameter_exception
     * @throws coding_exception
     * @throws dml_exception
     * @throws file_exception
     * @throws invalid_response_exception
     * @throws stored_file_creation_exception
     */
    public function test_mod_jqshow_get_jqshows_by_courses() {
        global $DB;

        $this->resetAfterTest(true);

        $course1 = self::getDataGenerator()->create_course();
        $course2 = self::getDataGenerator()->create_course();

        $student = self::getDataGenerator()->create_user();
        $studentrole = $DB->get_record('role', ['shortname' => 'student']);
        self::getDataGenerator()->enrol_user($student->id, $course1->id, $studentrole->id);

        // First jqshow.
        $record = new stdClass();
        $record->course = $course1->id;
        $jqshow1 = self::getDataGenerator()->create_module('jqshow', $record);

        // Second jqshow.
        $record = new stdClass();
        $record->course = $course2->id;
        $jqshow2 = self::getDataGenerator()->create_module('jqshow', $record);

        // Execute real Moodle enrolment as we'll call unenrol() method on the instance later.
        $enrol = enrol_get_plugin('manual');
        $enrolinstances = enrol_get_instances($course2->id, true);
        foreach ($enrolinstances as $courseenrolinstance) {
            if ($courseenrolinstance->enrol === 'manual') {
                $instance2 = $courseenrolinstance;
                break;
            }
        }
        $enrol->enrol_user($instance2, $student->id, $studentrole->id);

        self::setUser($student);

        $returndescription = \mod_jqshow_external::get_jqshows_by_courses_returns();

        // Create what we expect to be returned when querying the two courses.
        $expectedfields = ['id', 'coursemodule', 'course', 'name', 'intro', 'introformat', 'introfiles', 'timemodified',
            'section', 'visible', 'groupmode', 'groupingid', 'lang'];

        // Add expected coursemodule and data.
        $jqshow1->coursemodule = $jqshow1->cmid;
        $jqshow1->introformat = 1;
        $jqshow1->section = 0;
        $jqshow1->visible = true;
        $jqshow1->groupmode = 0;
        $jqshow1->groupingid = 0;
        $jqshow1->introfiles = [];
        $jqshow1->lang = '';

        $jqshow2->coursemodule = $jqshow2->cmid;
        $jqshow2->introformat = 1;
        $jqshow2->section = 0;
        $jqshow2->visible = true;
        $jqshow2->groupmode = 0;
        $jqshow2->groupingid = 0;
        $jqshow2->introfiles = [];
        $jqshow2->lang = '';

        foreach ($expectedfields as $field) {
            $expected1[$field] = $jqshow1->{$field};
            $expected2[$field] = $jqshow2->{$field};
        }

        $expectedjqshows = [$expected2, $expected1];

        // Call the external function passing course ids.
        $result = mod_jqshow_external::get_jqshows_by_courses([$course2->id, $course1->id]);
        $result = external_api::clean_returnvalue($returndescription, $result);

        $this->assertEquals($expectedjqshows, $result['jqshows']);
        $this->assertCount(0, $result['warnings']);

        // Call the external function without passing course id.
        $result = mod_jqshow_external::get_jqshows_by_courses();
        $result = external_api::clean_returnvalue($returndescription, $result);
        $this->assertEquals($expectedjqshows, $result['jqshows']);
        $this->assertCount(0, $result['warnings']);

        // Add a file to the intro.
        $filename = "file.txt";
        $filerecordinline = [
            'contextid' => context_module::instance($jqshow2->cmid)->id,
            'component' => 'mod_jqshow',
            'filearea'  => 'intro',
            'itemid'    => 0,
            'filepath'  => '/',
            'filename'  => $filename,
        ];
        $fs = get_file_storage();
        $fs->create_file_from_string($filerecordinline, 'image contents (not really)');

        $result = mod_jqshow_external::get_jqshows_by_courses(array($course2->id, $course1->id));
        $result = external_api::clean_returnvalue($returndescription, $result);

        $this->assertCount(1, $result['jqshows'][0]['introfiles']);
        $this->assertEquals($filename, $result['jqshows'][0]['introfiles'][0]['filename']);

        // Unenrol user from second course.
        $enrol->unenrol_user($instance2, $student->id);
        array_shift($expectedjqshows);

        // Call the external function without passing course id.
        $result = mod_jqshow_external::get_jqshows_by_courses();
        $result = external_api::clean_returnvalue($returndescription, $result);
        $this->assertEquals($expectedjqshows, $result['jqshows']);

        // Call for the second course we unenrolled the user from, expected warning.
        $result = mod_jqshow_external::get_jqshows_by_courses(array($course2->id));
        $this->assertCount(1, $result['warnings']);
        $this->assertEquals('1', $result['warnings'][0]['warningcode']);
        $this->assertEquals($course2->id, $result['warnings'][0]['itemid']);
    }
}