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
 *
 * @package    mod_jqshow
 * @copyright  2023 Proyecto UNIMOODLE
 * @author     UNIMOODLE Group (Coordinator) <direccion.area.estrategia.digital@uva.es>
 * @author     3IPUNT <contacte@tresipunt.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use core_course\external\helper_for_get_mods_by_courses;

defined('MOODLE_INTERNAL') || die;
global $CFG;
require_once($CFG->libdir . '/externallib.php');

class mod_jqshow_external extends external_api {

    /**
     *
     * @return external_function_parameters
     * @since Moodle 3.3
     */
    public static function get_jqshows_by_courses_parameters(): external_function_parameters {
        return new external_function_parameters (
            [
                'courseids' => new external_multiple_structure(
                    new external_value(PARAM_INT, 'Course id'), 'Array of course ids', VALUE_DEFAULT, []
                ),
            ]
        );
    }

    /**
     *
     * @param array $courseids course ids
     * @return array of warnings and jqshows
     * @throws coding_exception
     * @throws invalid_parameter_exception
     * @since Moodle 3.3
     */
    public static function get_jqshows_by_courses(array $courseids = []) : array {
        $warnings = [];
        $returnedjqshows = [];
        $params = [
            'courseids' => $courseids,
        ];
        $params = self::validate_parameters(self::get_jqshows_by_courses_parameters(), $params);

        $mycourses = [];
        if (empty($params['courseids'])) {
            $mycourses = enrol_get_my_courses();
            $params['courseids'] = array_keys($mycourses);
        }

        // Ensure there are courseids to loop through.
        if (!empty($params['courseids'])) {
            [$courses, $warnings] = external_util::validate_courses($params['courseids'], $mycourses);

            // Get the jqshows in this course, this function checks users visibility permissions.
            // We can avoid then additional validate_context calls.
            $jqshows = get_all_instances_in_courses("jqshow", $courses);
            foreach ($jqshows as $jqshow) {
                helper_for_get_mods_by_courses::format_name_and_intro($jqshow, 'mod_jqshow');
                $returnedjqshows[] = $jqshow;
            }
        }

        return [
            'jqshows' => $returnedjqshows,
            'warnings' => $warnings
        ];
    }

    /**
     * @return external_single_structure
     */
    public static function get_jqshows_by_courses_returns() : external_single_structure {
        return new external_single_structure(
            array(
                'jqshows' => new external_multiple_structure(
                    new external_single_structure(array_merge(
                        helper_for_get_mods_by_courses::standard_coursemodule_elements_returns(),
                        [
                            'timemodified' => new external_value(PARAM_INT, 'Last time the jqshow was modified'),
                        ]
                    ))
                ),
                'warnings' => new external_warnings(),
            )
        );
    }
}
