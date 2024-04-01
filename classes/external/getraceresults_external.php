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
 * Get race mode results API
 *
 * @package    mod_kuet
 * @copyright  2023 Proyecto UNIMOODLE
 * @author     UNIMOODLE Group (Coordinator) <direccion.area.estrategia.digital@uva.es>
 * @author     3IPUNT <contacte@tresipunt.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_kuet\external;

use context_module;
use external_api;
use external_function_parameters;
use external_multiple_structure;
use external_single_structure;
use external_value;
use invalid_parameter_exception;
use mod_kuet\models\sessions;
use mod_kuet\persistents\kuet_sessions;
use moodle_exception;

defined('MOODLE_INTERNAL') || die();
global $CFG;
require_once($CFG->libdir . '/externallib.php');

/**
 * Get race mode results class
 */
class getraceresults_external extends external_api {
    /**
     * Get race mode results parameters validation
     *
     * @return external_function_parameters
     */
    public static function getraceresults_parameters(): external_function_parameters {
        return new external_function_parameters(
            [
                'sid' => new external_value(PARAM_INT, 'sessionid id'),
                'cmid' => new external_value(PARAM_INT, 'course module id'),
            ]
        );
    }

    /**
     * Get race mode results
     *
     * @param int $sid
     * @param int $cmid
     * @return true[]
     * @throws moodle_exception
     * @throws invalid_parameter_exception
     */
    public static function getraceresults(int $sid, int $cmid): array {
        self::validate_parameters(
            self::getraceresults_parameters(),
            ['sid' => $sid, 'cmid' => $cmid]
        );
        global $PAGE;
        $contextmodule = context_module::instance($cmid);
        $PAGE->set_context($contextmodule);
        $session = new kuet_sessions($sid);
        if ($session->is_group_mode()) {
            $groupresults = sessions::get_group_session_results($sid, $cmid);
            $questions = sessions::breakdown_responses_for_race_groups($groupresults, $sid, $cmid, $session->get('kuetid'));
            return ['groupmode' => true, 'groupresults' => $groupresults, 'questions' => $questions];
        } else {
            $userresults = sessions::get_session_results($sid, $cmid);
            usort($userresults, static fn($a, $b) => strcmp($a->userfullname, $b->userfullname));
            $questions = sessions::breakdown_responses_for_race($userresults, $sid, $cmid, $session->get('kuetid'));
            return ['groupmode' => false, 'userresults' => $userresults, 'questions' => $questions];
        }
    }

    /**
     * Get race mode results returns
     *
     * @return external_single_structure
     */
    public static function getraceresults_returns(): external_single_structure {
        return new external_single_structure([
            'userresults' => new external_multiple_structure(
                new external_single_structure(
                    [
                        'userfullname' => new external_value(PARAM_RAW, 'Name of user'),
                        'correctanswers' => new external_value(PARAM_INT, 'Num of correct answers'),
                        'userimageurl' => new external_value(PARAM_URL, 'User image'),
                        'userprofileurl' => new external_value(PARAM_URL, 'User profile'),
                        'incorrectanswers' => new external_value(PARAM_INT, 'Num of incorrect answers'),
                        'notanswers' => new external_value(PARAM_INT, 'Num of incorrect answers'),
                        'partially' => new external_value(PARAM_INT, 'Num of partially correct answers'),
                        'userpoints' => new external_value(PARAM_RAW, 'Total points of user'),
                        'userposition' => new external_value(PARAM_INT, 'User position depending on the points'),
                    ], ''
                ), '', VALUE_OPTIONAL
            ),
            'groupmode' => new external_value(PARAM_BOOL, 'group mode activated'),
            'groupresults' => new external_multiple_structure(
                new external_single_structure(
                    [
                        'groupname' => new external_value(PARAM_RAW, 'Name of group'),
                        'groupimageurl' => new external_value(PARAM_RAW, 'Group Image'),
                        'correctanswers' => new external_value(PARAM_INT, 'Num of correct answers'),
                        'incorrectanswers' => new external_value(PARAM_INT, 'Num of incorrect answers'),
                        'notanswers' => new external_value(PARAM_INT, 'Num of incorrect answers'),
                        'partially' => new external_value(PARAM_INT, 'Num of partially correct answers'),
                        'grouppoints' => new external_value(PARAM_RAW, 'Total points of group'),
                        'groupposition' => new external_value(PARAM_INT, 'Group position depending on the points'),
                    ], ''
                ), '', VALUE_OPTIONAL
            ),
            'questions' => new external_multiple_structure(
                new external_single_structure(
                    [
                        'questionnum' => new external_value(PARAM_RAW, 'Num of questions'),
                        'studentsresponse' => new external_multiple_structure(
                            new external_single_structure(
                            [
                                'userid' => new external_value(PARAM_INT, 'User of response'),
                                'responseclass' => new external_value(PARAM_RAW, 'Css Class for response'),
                                'responsetext' => new external_value(PARAM_RAW, 'Text for response tooltip', VALUE_OPTIONAL),
                            ], ''
                        ), ''),
                    ], ''
                ), ''
            ),
        ]);
    }
}
