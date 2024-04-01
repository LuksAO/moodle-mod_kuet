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
// Córdoba, Extremadura, Vigo, Las Palmas de Gran Canaria y Burgos.

/**
 * Get list results API
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
 * Get list results class
 */
class getlistresults_external extends external_api {
    /**
     * Get list results parameters validation
     *
     * @return external_function_parameters
     */
    public static function getlistresults_parameters(): external_function_parameters {
        return new external_function_parameters(
            [
                'sid' => new external_value(PARAM_INT, 'sessionid id'),
                'cmid' => new external_value(PARAM_INT, 'course module id'),
            ]
        );
    }

    /**
     * Get list results
     *
     * @param int $sid
     * @param int $cmid
     * @return true[]
     * @throws moodle_exception
     * @throws invalid_parameter_exception
     */
    public static function getlistresults(int $sid, int $cmid): array {
        global $PAGE;
        self::validate_parameters(
            self::getlistresults_parameters(),
            ['sid' => $sid, 'cmid' => $cmid]
        );
        $context = context_module::instance($cmid);
        $PAGE->set_context($context);
        $session = new kuet_sessions($sid);
        if ($session->is_group_mode()) {
            $groupresults = sessions::get_group_session_results($sid, $cmid);
            return ['groupmode' => true, 'groupresults' => $groupresults];
        }
        $userresults = sessions::get_session_results($sid, $cmid);
        return ['groupmode' => false, 'userresults' => $userresults];
    }

    /**
     * Get list results returns
     *
     * @return external_single_structure
     */
    public static function getlistresults_returns(): external_single_structure {
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
                        'groupimageurl' => new external_value(PARAM_URL, 'Group Image'),
                        'correctanswers' => new external_value(PARAM_INT, 'Num of correct answers'),
                        'incorrectanswers' => new external_value(PARAM_INT, 'Num of incorrect answers'),
                        'notanswers' => new external_value(PARAM_INT, 'Num of incorrect answers'),
                        'partially' => new external_value(PARAM_INT, 'Num of partially correct answers'),
                        'grouppoints' => new external_value(PARAM_RAW, 'Total points of group'),
                        'groupposition' => new external_value(PARAM_INT, 'Group position depending on the points'),
                    ], ''
                ), '', VALUE_OPTIONAL
            ),
        ]);
    }
}
