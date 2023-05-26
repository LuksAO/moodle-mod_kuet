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

use coding_exception;
use context_course;
use core\invalid_persistent_exception;
use dml_exception;
use external_api;
use external_function_parameters;
use external_single_structure;
use external_value;
use invalid_parameter_exception;
use mod_jqshow\persistents\jqshow_questions;
use mod_jqshow\persistents\jqshow_sessions;

defined('MOODLE_INTERNAL') || die();
global $CFG;
require_once($CFG->libdir . '/externallib.php');

class copysession_external extends external_api {

    public static function copysession_parameters(): external_function_parameters {
        return new external_function_parameters(
            [
                'courseid' => new external_value(PARAM_INT, 'course id'),
                'sessionid' => new external_value(PARAM_INT, 'id of session to copy')
            ]
        );
    }

    /**
     * @param int $courseid
     * @param int $sessionid
     * @return array
     * @throws invalid_persistent_exception
     * @throws coding_exception
     * @throws dml_exception
     * @throws invalid_parameter_exception
     */
    public static function copysession(int $courseid, int $sessionid): array {
        global $USER;
        self::validate_parameters(
            self::copysession_parameters(),
            ['courseid' => $courseid, 'sessionid' => $sessionid]
        );
        $coursecontext = context_course::instance($courseid);
        $copied = false;
        if ($coursecontext !== null && has_capability('mod/jqshow:managesessions', $coursecontext, $USER)) {
            $newsessionid = jqshow_sessions::duplicate_session($sessionid);
            $copied = jqshow_questions::copy_session_questions($sessionid, $newsessionid);
        }
        return [
            'copied' => $copied
        ];
    }

    /**
     * @return external_single_structure
     */
    public static function copysession_returns(): external_single_structure {
        return new external_single_structure(
            [
                'copied' => new external_value(PARAM_BOOL, 'copied'),
            ]
        );
    }
}
