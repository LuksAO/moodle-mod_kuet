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
use mod_kuet\models\questions;
/**
 * Reorder question service test
 *
 * @package     mod_kuet
 * @author      3&Punt <tresipunt.com>
 * @author      2023 Tomás Zafra <jmtomas@tresipunt.com> | Elena Barrios <elena@tresipunt.com>
 * @category   test
 * @copyright   3iPunt <https://www.tresipunt.com/>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Reorder question service test class
 */
class reorderquestions_external_test extends advanced_testcase {
    /**
     * Reorder question service test
     *
     * @return void
     * @throws \core\invalid_persistent_exception
     * @throws coding_exception
     * @throws invalid_parameter_exception
     * @throws moodle_exception
     */
    public function test_reorderquestions() {
        $this->resetAfterTest(true);
        $course = self::getDataGenerator()->create_course();
        $kuet = self::getDataGenerator()->create_module('kuet', ['course' => $course->id]);
        $this->sessionmock['kuetid'] = $kuet->id;
        $generator = $this->getDataGenerator()->get_plugin_generator('mod_kuet');

        // Only a user with capability can add questions.
        $teacher = self::getDataGenerator()->create_and_enrol($course, 'teacher');
        self::setUser($teacher);
        // Create session.
        $sessionmock = [
            'name' => 'Session Test',
            'kuetid' => $kuet->id,
            'anonymousanswer' => 0,
            'sessionmode' => \mod_kuet\models\sessions::PODIUM_MANUAL,
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
            'status' => \mod_kuet\models\sessions::SESSION_ACTIVE,
            'sessionid' => 0,
            'submitbutton' => 0,
        ];
        $createdsid = $generator->create_session($kuet, (object) $sessionmock);

        // Create questions.
        $questiongenerator = $this->getDataGenerator()->get_plugin_generator('core_question');
        $cat = $questiongenerator->create_question_category();
        $saq = $questiongenerator->create_question(questions::SHORTANSWER, null, ['category' => $cat->id]);
        $nq = $questiongenerator->create_question(questions::NUMERICAL, null, ['category' => $cat->id]);
        $tfq = $questiongenerator->create_question(questions::TRUE_FALSE, null, ['category' => $cat->id]);
        $mcq = $questiongenerator->create_question(questions::MULTICHOICE, null, ['category' => $cat->id]);
        $cq = $questiongenerator->create_question(questions::CALCULATED, null, ['category' => $cat->id]);
        $ddwtosq = $questiongenerator->create_question(questions::DDWTOS, null, ['category' => $cat->id]);
        $dq = $questiongenerator->create_question(questions::DESCRIPTION, null, ['category' => $cat->id]);

        // Add questions to a session.
        $questions = [
            ['questionid' => $saq->id, 'sessionid' => $createdsid, 'kuetid' => $kuet->id, 'qtype' => questions::SHORTANSWER],
            ['questionid' => $nq->id, 'sessionid' => $createdsid, 'kuetid' => $kuet->id, 'qtype' => questions::NUMERICAL],
            ['questionid' => $tfq->id, 'sessionid' => $createdsid, 'kuetid' => $kuet->id, 'qtype' => questions::TRUE_FALSE],
            ['questionid' => $mcq->id, 'sessionid' => $createdsid, 'kuetid' => $kuet->id, 'qtype' => questions::MULTICHOICE],
            ['questionid' => $cq->id, 'sessionid' => $createdsid, 'kuetid' => $kuet->id, 'qtype' => questions::CALCULATED],
            ['questionid' => $ddwtosq->id, 'sessionid' => $createdsid, 'kuetid' => $kuet->id, 'qtype' => questions::DDWTOS],
            ['questionid' => $dq->id, 'sessionid' => $createdsid, 'kuetid' => $kuet->id, 'qtype' => questions::DESCRIPTION],
        ];
        $generator->add_questions_to_session($questions);

        $jdq = \mod_kuet\persistents\kuet_questions::get_record(
            ['questionid' => $dq->id, 'sessionid' => $createdsid, 'kuetid' => $kuet->id, 'qtype' => questions::DESCRIPTION]);
        $jddwtosq = \mod_kuet\persistents\kuet_questions::get_record(
            ['questionid' => $ddwtosq->id, 'sessionid' => $createdsid, 'kuetid' => $kuet->id, 'qtype' => questions::DDWTOS]);
        $jcq = \mod_kuet\persistents\kuet_questions::get_record(
            ['questionid' => $cq->id, 'sessionid' => $createdsid, 'kuetid' => $kuet->id, 'qtype' => questions::CALCULATED]);
        $jmcq = \mod_kuet\persistents\kuet_questions::get_record(
            ['questionid' => $mcq->id, 'sessionid' => $createdsid, 'kuetid' => $kuet->id, 'qtype' => questions::MULTICHOICE]);
        $jtfq = \mod_kuet\persistents\kuet_questions::get_record(
            ['questionid' => $tfq->id, 'sessionid' => $createdsid, 'kuetid' => $kuet->id, 'qtype' => questions::TRUE_FALSE]);
        $jnq = \mod_kuet\persistents\kuet_questions::get_record(
            ['questionid' => $nq->id, 'sessionid' => $createdsid, 'kuetid' => $kuet->id, 'qtype' => questions::NUMERICAL]);
        $jsaq = \mod_kuet\persistents\kuet_questions::get_record(
            ['questionid' => $saq->id, 'sessionid' => $createdsid, 'kuetid' => $kuet->id, 'qtype' => questions::SHORTANSWER]);

        $neworderquestions = [
            ['qid' => $jdq->get('id'), 'qorder' => 1],
            ['qid' => $jddwtosq->get('id'), 'qorder' => 2],
            ['qid' => $jcq->get('id'), 'qorder' => 3],
            ['qid' => $jmcq->get('id'), 'qorder' => 4],
            ['qid' => $jtfq->get('id'), 'qorder' => 5],
            ['qid' => $jnq->get('id'), 'qorder' => 6],
            ['qid' => $jsaq->get('id'), 'qorder' => 7],
            ];

        \mod_kuet\external\reorderquestions_external::reorderquestions($neworderquestions);
        $jdq = new \mod_kuet\persistents\kuet_questions($jdq->get('id'));
        $jddwtosq = new \mod_kuet\persistents\kuet_questions($jddwtosq->get('id'));
        $jcq = new \mod_kuet\persistents\kuet_questions($jcq->get('id'));
        $jmcq = new \mod_kuet\persistents\kuet_questions($jmcq->get('id'));
        $jtfq = new \mod_kuet\persistents\kuet_questions($jtfq->get('id'));
        $jnq = new \mod_kuet\persistents\kuet_questions($jnq->get('id'));
        $jsaq = new \mod_kuet\persistents\kuet_questions($jsaq->get('id'));

        // Test.
        $this->assertEquals(1, $jdq->get('qorder'));
        $this->assertEquals(2, $jddwtosq->get('qorder'));
        $this->assertEquals(3, $jcq->get('qorder'));
        $this->assertEquals(4, $jmcq->get('qorder'));
        $this->assertEquals(5, $jtfq->get('qorder'));
        $this->assertEquals(6, $jnq->get('qorder'));
        $this->assertEquals(7, $jsaq->get('qorder'));
    }
}
