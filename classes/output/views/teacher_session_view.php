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

/**
 *
 * @package     mod_jqshow
 * @author      3&Punt <tresipunt.com>
 * @author      2023 Tomás Zafra <jmtomas@tresipunt.com> | Elena Barrios <elena@tresipunt.com>
 * @copyright   3iPunt <https://www.tresipunt.com/>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_jqshow\output\views;
use coding_exception;
use core\invalid_persistent_exception;
use dml_exception;
use mod_jqshow\external\sessionquestions_external;
use mod_jqshow\models\questions;
use mod_jqshow\models\sessions;
use mod_jqshow\persistents\jqshow_sessions;
use moodle_exception;
use renderable;
use stdClass;
use templatable;
use renderer_base;

class teacher_session_view implements renderable, templatable {
    /**
     * @param renderer_base $output
     * @return stdClass
     * @throws invalid_persistent_exception
     * @throws moodle_exception
     * @throws coding_exception
     * @throws dml_exception
     */
    public function export_for_template(renderer_base $output): stdClass {
        // TODO refactor duplicate code for teacher and student.
        global $USER, $DB;
        $data = new stdClass();
        $data->cmid = required_param('cmid', PARAM_INT);
        $data->sid = required_param('sid', PARAM_INT);
        $data->isteacher = true;
        $data->userid = $USER->id;
        $data->userfullname = $USER->firstname . ' ' . $USER->lastname;
        $session = new jqshow_sessions($data->sid);
        $data->jqshowid = $session->get('jqshowid');
        jqshow_sessions::mark_session_started($data->sid);
        if ($session->get('sessionmode') === sessions::PODIUM_PROGRAMMED) {
            $data->programmedmode = true;
            $data->config = sessions::get_session_config($data->sid);
            $data->userresults = sessions::get_session_results($data->sid, $data->cmid);
        } else {
            // SOCKETS!
            // Always start with waitingroom.
            [$course, $cm] = get_course_and_cm_from_cmid($data->cmid, 'jqshow');
            $jqshow = $DB->get_record('jqshow', ['id' => $cm->instance], '*', MUST_EXIST);
            $data->manualmode = true;
            $data->waitingroom = true;
            $data->config = sessions::get_session_config($data->sid);
            $data->sessionname = $data->config[0]['configvalue'];
            unset($data->config[0]);
            $data->config = array_values($data->config);
            $allquestions = (new questions($jqshow->id, $data->cmid, $data->sid))->get_list();
            $questiondata = [];
            foreach ($allquestions as $question) {
                $questionexport = sessionquestions_external::export_question($question, $data->cmid);
                $questionexport->managesessions = false;
                $questiondata[] = $questionexport;
            }
            $data->sessionquestions = $questiondata;
            $data->port = get_config('jqshow', 'port') !== false ? get_config('jqshow', 'port') : '8080';
        }
        return $data;
    }
}
