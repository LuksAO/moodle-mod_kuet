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

namespace mod_jqshow\external;

use external_api;
use external_function_parameters;
use external_multiple_structure;
use external_single_structure;
use external_value;
use invalid_parameter_exception;
use mod_jqshow\models\sessions;
use moodle_exception;

defined('MOODLE_INTERNAL') || die();
global $CFG;
require_once($CFG->libdir . '/externallib.php');

class getlistresults_external extends external_api {
    /**
     * @return external_function_parameters
     */
    public static function getlistresults_parameters(): external_function_parameters {
        return new external_function_parameters(
            [
                'sid' => new external_value(PARAM_INT, 'sessionid id'),
                'cmid' => new external_value(PARAM_INT, 'course module id')
            ]
        );
    }

    /**
     * @param int $sid
     * @param int $cmid
     * @return true[]
     * @throws moodle_exception
     * @throws invalid_parameter_exception
     */
    public static function getlistresults(int $sid, int $cmid): array {
        self::validate_parameters(
            self::getlistresults_parameters(),
            ['sid' => $sid, 'cmid' => $cmid]
        );
        return ['userresults' => sessions::get_session_results($sid, $cmid)];
    }

    /**
     * @return external_single_structure
     */
    public static function getlistresults_returns(): external_single_structure {
        return new external_single_structure([
            'userresults' => new external_multiple_structure(
                new external_single_structure(
                    [
                        'userfullname'   => new external_value(PARAM_RAW, 'Name of user'),
                        'correctanswers' => new external_value(PARAM_INT, 'Num of correct answer'),
                        'incorrectanswers' => new external_value(PARAM_INT, 'Num of incorrect answer'),
                        'userpoints' => new external_value(PARAM_INT, 'Total points of user'),
                        'userposition' => new external_value(PARAM_INT, 'User position depending on the points')
                    ], ''
                ), ''
            )
        ]);
    }
}
