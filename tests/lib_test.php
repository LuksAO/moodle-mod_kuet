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

use advanced_testcase;
use calendar_event;
use coding_exception;
use completion_info;
use core_calendar\action_factory;
use core_completion\api;
use core_calendar\local\event\value_objects\action;
use moodle_exception;
use stdClass;

/**
 *
 * @package     mod_jqshow
 * @author      3&Punt <tresipunt.com>
 * @author      2023 Tomás Zafra <jmtomas@tresipunt.com> | Elena Barrios <elena@tresipunt.com>
 * @category   test
 * @copyright   3iPunt <https://www.tresipunt.com/>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class lib_test extends advanced_testcase {

    /**
     * @return void
     */
    public function setUp(): void {
        $this->resetAfterTest();
        self::setAdminUser();
    }

    /**
     * @return void
     * @throws coding_exception
     * @throws moodle_exception
     */
    public function test_jqshow_core_calendar_provide_event_action() {
        // Create the activity.
        $course = self::getDataGenerator()->create_course();
        $jqshow = self::getDataGenerator()->create_module('jqshow', ['course' => $course->id]);

        // Create a calendar event.
        $event = $this->create_action_event($course->id, $jqshow->id,
            api::COMPLETION_EVENT_TYPE_DATE_COMPLETION_EXPECTED);

        // Create an action factory.
        $factory = new action_factory();

        // Decorate action event.
        $actionevent = mod_jqshow_core_calendar_provide_event_action($event, $factory);

        // Confirm the event was decorated.
        $this->assertInstanceOf(action::class, $actionevent);
        $this->assertEquals(get_string('view'), $actionevent->get_name());
        $this->assertInstanceOf('moodle_url', $actionevent->get_url());
        $this->assertEquals(1, $actionevent->get_item_count());
        $this->assertTrue($actionevent->is_actionable());
    }

    /**
     * @return void
     * @throws coding_exception
     * @throws moodle_exception
     */
    public function test_jqshow_core_calendar_provide_event_action_as_non_user() {
        global $CFG;

        // Create the activity.
        $course = self::getDataGenerator()->create_course();
        $jqshow = self::getDataGenerator()->create_module('jqshow', ['course' => $course->id]);

        // Create a calendar event.
        $event = $this->create_action_event($course->id, $jqshow->id,
                api::COMPLETION_EVENT_TYPE_DATE_COMPLETION_EXPECTED);

        // Now log out.
        $CFG->forcelogin = true; // We don't want to be logged in as guest, as guest users might still have some capabilities.
        self::setUser();

        // Create an action factory.
        $factory = new action_factory();

        // Decorate action event.
        $actionevent = mod_jqshow_core_calendar_provide_event_action($event, $factory);

        // Confirm the event is not shown at all.
        $this->assertNull($actionevent);
    }

    /**
     * @return void
     * @throws coding_exception
     * @throws moodle_exception
     */
    public function test_jqshow_core_calendar_provide_event_action_in_hidden_section() {
        // Create the activity.
        $course = self::getDataGenerator()->create_course();
        $jqshow = self::getDataGenerator()->create_module('jqshow', ['course' => $course->id]);

        // Create a student.
        $student = self::getDataGenerator()->create_and_enrol($course, 'student');

        // Create a calendar event.
        $event = $this->create_action_event($course->id, $jqshow->id,
                api::COMPLETION_EVENT_TYPE_DATE_COMPLETION_EXPECTED);

        // Set sections 0 as hidden.
        set_section_visible($course->id, 0, 0);

        // Create an action factory.
        $factory = new action_factory();

        // Decorate action event for the student.
        $actionevent = mod_jqshow_core_calendar_provide_event_action($event, $factory, $student->id);

        // Confirm the event is not shown at all.
        $this->assertNull($actionevent);
    }

    /**
     * @return void
     * @throws coding_exception
     * @throws moodle_exception
     */
    public function test_jqshow_core_calendar_provide_event_action_for_user() {
        global $CFG;

        // Create the activity.
        $course = self::getDataGenerator()->create_course();
        $jqshow = self::getDataGenerator()->create_module('jqshow', ['course' => $course->id]);

        // Enrol a student in the course.
        $student = self::getDataGenerator()->create_and_enrol($course, 'student');

        // Create a calendar event.
        $event = $this->create_action_event($course->id, $jqshow->id,
            api::COMPLETION_EVENT_TYPE_DATE_COMPLETION_EXPECTED);

        // Now, log out.
        $CFG->forcelogin = true; // We don't want to be logged in as guest, as guest users might still have some capabilities.
        self::setUser();

        // Create an action factory.
        $factory = new action_factory();

        // Decorate action event for the student.
        $actionevent = mod_jqshow_core_calendar_provide_event_action($event, $factory, $student->id);

        // Confirm the event was decorated.
        $this->assertInstanceOf(action::class, $actionevent);
        $this->assertEquals(get_string('view'), $actionevent->get_name());
        $this->assertInstanceOf('moodle_url', $actionevent->get_url());
        $this->assertEquals(1, $actionevent->get_item_count());
        $this->assertTrue($actionevent->is_actionable());
    }

    /**
     * @return void
     * @throws moodle_exception
     * @throws coding_exception
     */
    public function test_jqshow_core_calendar_provide_event_action_already_completed() {
        global $CFG;

        $CFG->enablecompletion = 1;

        // Create the activity.
        $course = self::getDataGenerator()->create_course(['enablecompletion' => 1]);
        $jqshow = self::getDataGenerator()->create_module('jqshow', ['course' => $course->id],
            ['completion' => 2, 'completionview' => 1, 'completionexpected' => time() + DAYSECS]);

        // Get some additional data.
        $cm = get_coursemodule_from_instance('jqshow', $jqshow->id);

        // Create a calendar event.
        $event = $this->create_action_event($course->id, $jqshow->id,
            api::COMPLETION_EVENT_TYPE_DATE_COMPLETION_EXPECTED);

        // Mark the activity as completed.
        $completion = new completion_info($course);
        $completion->set_module_viewed($cm);

        // Create an action factory.
        $factory = new action_factory();

        // Decorate action event.
        $actionevent = mod_jqshow_core_calendar_provide_event_action($event, $factory);

        // Ensure result was null.
        $this->assertNull($actionevent);
    }

    /**
     * @return void
     * @throws coding_exception
     * @throws moodle_exception
     */
    public function test_jqshow_core_calendar_provide_event_action_already_completed_for_user() {
        global $CFG;

        $CFG->enablecompletion = 1;

        // Create the activity.
        $course = self::getDataGenerator()->create_course(['enablecompletion' => 1]);
        $jqshow = self::getDataGenerator()->create_module('jqshow', ['course' => $course->id],
                ['completion' => 2, 'completionview' => 1, 'completionexpected' => time() + DAYSECS]);

        // Enrol a student in the course.
        $student = self::getDataGenerator()->create_and_enrol($course, 'student');

        // Get some additional data.
        $cm = get_coursemodule_from_instance('jqshow', $jqshow->id);

        // Create a calendar event.
        $event = $this->create_action_event($course->id, $jqshow->id,
                api::COMPLETION_EVENT_TYPE_DATE_COMPLETION_EXPECTED);

        // Mark the activity as completed for the student.
        $completion = new completion_info($course);
        $completion->set_module_viewed($cm, $student->id);

        // Create an action factory.
        $factory = new action_factory();

        // Decorate action event for the student.
        $actionevent = mod_jqshow_core_calendar_provide_event_action($event, $factory, $student->id);

        // Ensure result was null.
        $this->assertNull($actionevent);
    }

    /**
     * Creates an action event.
     *
     * @param int $courseid The course id.
     * @param int $instanceid The instance id.
     * @param string $eventtype The event type.
     * @return bool|calendar_event
     * @throws coding_exception
     */
    private function create_action_event($courseid, $instanceid, $eventtype) {
        $event = new stdClass();
        $event->name = 'Calendar event';
        $event->modulename  = 'jqshow';
        $event->courseid = $courseid;
        $event->instance = $instanceid;
        $event->type = CALENDAR_EVENT_TYPE_ACTION;
        $event->eventtype = $eventtype;
        $event->timestart = time();

        return calendar_event::create($event);
    }
}