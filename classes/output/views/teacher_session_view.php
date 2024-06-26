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

// Project implemented by the "Recovery, Transformation and Resilience Plan.
// Funded by the European Union - Next GenerationEU".
//
// Produced by the UNIMOODLE University Group: Universities of
// Valladolid, Complutense de Madrid, UPV/EHU, León, Salamanca,
// Illes Balears, Valencia, Rey Juan Carlos, La Laguna, Zaragoza, Málaga,
// Córdoba, Extremadura, Vigo, Las Palmas de Gran Canaria y Burgos..

/**
 * Teacher sesion view renderer
 *
 * @package    mod_kuet
 * @copyright  2023 Proyecto UNIMOODLE {@link https://unimoodle.github.io}
 * @author     UNIMOODLE Group (Coordinator) <direccion.area.estrategia.digital@uva.es>
 * @author     3IPUNT <contacte@tresipunt.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_kuet\output\views;
use coding_exception;
use core\invalid_persistent_exception;
use dml_exception;
use mod_kuet\external\sessionquestions_external;
use mod_kuet\models\questions;
use mod_kuet\models\sessions;
use mod_kuet\persistents\kuet_sessions;
use moodle_exception;
use moodle_url;
use renderable;
use stdClass;
use templatable;
use renderer_base;
use user_picture;

/**
 * Teacher session view renderable class
 */
class teacher_session_view implements renderable, templatable {
    /**
     * Export for template
     *
     * @param renderer_base $output
     * @return stdClass
     * @throws coding_exception
     * @throws dml_exception
     * @throws invalid_persistent_exception
     * @throws moodle_exception
     */
    public function export_for_template(renderer_base $output): stdClass {
        global $USER, $DB, $PAGE, $COURSE;
        $data = new stdClass();
        $data->cmid = required_param('cmid', PARAM_INT);
        $data->sid = required_param('sid', PARAM_INT);
        $data->courseid = $COURSE->id;
        $data->isteacher = true;
        $data->userid = $USER->id;
        $data->userfullname = $USER->firstname . ' ' . $USER->lastname;
        $userpicture = new user_picture($USER);
        $userpicture->size = 1;
        $data->userimage = $userpicture->get_url($PAGE)->out(false);
        $session = new kuet_sessions($data->sid);
        $data->kuetid = $session->get('kuetid');
        $qrcode = generate_kuet_qrcode((new moodle_url('/mod/kuet/view.php', ['id' => $data->cmid]))->out(false));
        $data->hasqrcodeimage = $qrcode !== '';
        $data->urlqrcode = $data->hasqrcodeimage === true ? $qrcode : '';
        kuet_sessions::mark_session_started($data->sid);
        switch ($session->get('sessionmode')) {
            case sessions::INACTIVE_PROGRAMMED:
            case sessions::PODIUM_PROGRAMMED:
            case sessions::RACE_PROGRAMMED:
                $data->programmedmode = true;
                $data->config = sessions::get_session_config($data->sid, $data->cmid);
                if ($session->is_group_mode()) {
                    $data->groupresults = sessions::get_group_session_results($data->sid, $data->cmid);
                    $data->groupmode = 1;
                } else {
                    $data->userresults = sessions::get_session_results($data->sid, $data->cmid);
                }
                if ($session->get('sessionmode') === sessions::RACE_PROGRAMMED) {
                    // The race mode also needs the result list data.
                    $data->racemode = true;
                    if ($session->is_group_mode()) {
                        $data->questions = sessions::breakdown_responses_for_race_groups($data->groupresults, $data->sid,
                            $data->cmid, $session->get('kuetid'));
                    } else {
                        usort($data->userresults, static fn($a, $b) => strcmp($a->userfullname, $b->userfullname));
                        $data->questions = sessions::breakdown_responses_for_race(
                            $data->userresults, $data->sid, $data->cmid, $session->get('kuetid')
                        );
                    }
                }
                break;
            case sessions::INACTIVE_MANUAL:
            case sessions::PODIUM_MANUAL:
            case sessions::RACE_MANUAL:
                global $CFG;
                // SOCKETS! Always start with waitingroom.
                [$course, $cm] = get_course_and_cm_from_cmid($data->cmid, 'kuet', $COURSE);
                $kuet = $DB->get_record('kuet', ['id' => $cm->instance], '*', MUST_EXIST);
                $data->manualmode = true;
                $data->groupmode = $session->is_group_mode();
                $data->waitingroom = true;
                $data->config = sessions::get_session_config($data->sid, $data->cmid);
                $data->sessionname = $data->config[0]['configvalue'];
                unset($data->config[0]);
                $data->config = array_values($data->config);
                $allquestions = (new questions($kuet->id, $data->cmid, $data->sid))->get_list();
                $questiondata = [];
                foreach ($allquestions as $question) {
                    $questionexport = sessionquestions_external::export_question($question, $data->cmid);
                    $questionexport->managesessions = false;
                    $questiondata[] = $questionexport;
                }
                $data->sessionquestions = $questiondata;
                $data->numquestions = count($questiondata);
                $data->showquestionfeedback = (int)$session->get('showfeedback') === 1;
                $typesocket = get_config('kuet', 'sockettype');
                if ($typesocket === 'local') {
                    $data->socketurl = $CFG->wwwroot;
                    $data->port = get_config('kuet', 'localport') !== false ? get_config('kuet', 'localport') : '8080';
                }
                if ($typesocket === 'external') {
                    $data->socketurl = get_config('kuet', 'externalurl');
                    $data->port = get_config('kuet', 'externalport') !== false ? get_config('kuet', 'externalport') : '8080';
                }
                $data->sessionmode = $session->get('sessionmode');
                $data->groupmode = $session->is_group_mode();
                $data->courseid = $course->id;
                break;
            default:
                throw new moodle_exception('incorrect_sessionmode', 'mod_kuet', '',
                    [], get_string('incorrect_sessionmode', 'mod_kuet'));
        }
        return $data;
    }
}
