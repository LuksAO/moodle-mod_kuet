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

namespace mod_jqshow\exporter;


class ddwtos_exporter extends commondata_exporter {

    /**
     * @return array
     */
    public static function define_properties(): array {
        return [
            'ddwtos' => [
                'type' => PARAM_BOOL,
                'optional' => true
            ],
            'ddwtosresponse' => [
                'type' => PARAM_RAW,
                'optional' => true
            ],
            'correct_response' => [
                'type' => PARAM_RAW,
                'optional' => true
            ],
            'question_text_feedback' => [
                'type' => PARAM_RAW,
                'optional' => true
            ]
        ];
    }
}