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
use mod_jqshow\models\questions;

/**
 *
 * @package     mod_jqshow
 * @author      3&Punt <tresipunt.com>
 * @author      2023 Tomás Zafra <jmtomas@tresipunt.com> | Elena Barrios <elena@tresipunt.com>
 * @copyright   3iPunt <https://www.tresipunt.com/>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class nextquestion_external_test extends advanced_testcase {

    public function test_nextquestion() {
        $this->resetAfterTest(true);
        $course = self::getDataGenerator()->create_course();
        $jqshow = self::getDataGenerator()->create_module('jqshow', ['course' => $course->id]);
        $this->sessionmock['jqshowid'] = $jqshow->id;
        $generator = $this->getDataGenerator()->get_plugin_generator('mod_jqshow');

        // Only a user with capability can add questions.
        $teacher = self::getDataGenerator()->create_and_enrol($course, 'teacher');
        self::setUser($teacher);
        // Create session.
        $sessionmock = [
            'name' => 'Session Test',
            'jqshowid' => $jqshow->id,
            'anonymousanswer' => 0,
            'sessionmode' => \mod_jqshow\models\sessions::PODIUM_MANUAL,
            'sgrade' => 0,
            'countdown' => 0,
            'showgraderanking' => 0,
            'randomquestions' => 0,
            'randomanswers' => 0,
            'showfeedback' => 0,
            'showfinalgrade' => 0,
            'startdate' => 0,
            'enddate' => 0,
            'automaticstart' => 0,
            'timemode' => 0,
            'sessiontime' => 0,
            'questiontime' => 10,
            'groupings' => 0,
            'status' => \mod_jqshow\models\sessions::SESSION_ACTIVE,
            'sessionid' => 0,
            'submitbutton' => 0,
            'showgraderanking' => 0,
        ];
        $createdsid = $generator->create_session($jqshow, (object) $sessionmock);

        // Create questions.
        $questiongenerator = $this->getDataGenerator()->get_plugin_generator('core_question');
        $cat = $questiongenerator->create_question_category();
        $saq = $questiongenerator->create_question(questions::SHORTANSWER, null, array('category' => $cat->id));
        $nq = $questiongenerator->create_question(questions::NUMERICAL, null, array('category' => $cat->id));
        $tfq = $questiongenerator->create_question(questions::TRUE_FALSE, null, array('category' => $cat->id));
        $mcq = $questiongenerator->create_question(questions::MULTICHOICE, null, array('category' => $cat->id));
        $cq = $questiongenerator->create_question(questions::CALCULATED, null, array('category' => $cat->id));
        $ddwtosq = $questiongenerator->create_question(questions::DDWTOS, null, array('category' => $cat->id));
        $dq = $questiongenerator->create_question(questions::DESCRIPTION, null, array('category' => $cat->id));

        // Add question.
        \mod_jqshow\external\addquestions_external::add_questions([
            ['questionid' => $saq->id, 'sessionid' => $createdsid, 'jqshowid' => $jqshow->id, 'qtype' => questions::SHORTANSWER],
            ['questionid' => $nq->id, 'sessionid' => $createdsid, 'jqshowid' => $jqshow->id, 'qtype' => questions::NUMERICAL],
            ['questionid' => $mcq->id, 'sessionid' => $createdsid, 'jqshowid' => $jqshow->id, 'qtype' => questions::MULTICHOICE],
            ['questionid' => $tfq->id, 'sessionid' => $createdsid, 'jqshowid' => $jqshow->id, 'qtype' => questions::TRUE_FALSE],
            ['questionid' => $cq->id, 'sessionid' => $createdsid, 'jqshowid' => $jqshow->id, 'qtype' => questions::CALCULATED],
            ['questionid' => $ddwtosq->id, 'sessionid' => $createdsid, 'jqshowid' => $jqshow->id, 'qtype' => questions::DDWTOS],
            ['questionid' => $dq->id, 'sessionid' => $createdsid, 'jqshowid' => $jqshow->id, 'qtype' => questions::DESCRIPTION],
        ]);

        $jmcq = \mod_jqshow\persistents\jqshow_questions::get_record(
            ['questionid' => $mcq->id , 'sessionid' => $createdsid, 'jqshowid' => $jqshow->id, 'qtype' => questions::MULTICHOICE]);
        $jtfq = \mod_jqshow\persistents\jqshow_questions::get_record(
            ['questionid' => $tfq->id , 'sessionid' => $createdsid, 'jqshowid' => $jqshow->id, 'qtype' => questions::TRUE_FALSE]);
        $shouldbetruefalse = \mod_jqshow\external\nextquestion_external::nextquestion($jqshow->cmid, $createdsid, $jmcq->get('id'));

        $this->assertIsArray(  $shouldbetruefalse);
        $this->assertArrayHasKey('cmid',   $shouldbetruefalse);
        $this->assertEquals($jqshow->cmid,   $shouldbetruefalse['cmid']);
        $this->assertArrayHasKey('questionid',   $shouldbetruefalse);
        $this->assertEquals($tfq->id,   $shouldbetruefalse['questionid']);
        $this->assertArrayHasKey('jqid',   $shouldbetruefalse);
        $this->assertEquals($jtfq->get('id'),   $shouldbetruefalse['jqid']);
        $this->assertArrayHasKey('qtype',   $shouldbetruefalse);
        $this->assertEquals(questions::TRUE_FALSE, $shouldbetruefalse['qtype']);
    }
}
