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
 * Get question API
 *
 * @package    mod_kuet
 * @copyright  2023 Proyecto UNIMOODLE {@link https://unimoodle.github.io}
 * @author     UNIMOODLE Group (Coordinator) <direccion.area.estrategia.digital@uva.es>
 * @author     3IPUNT <contacte@tresipunt.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_kuet\external;

use coding_exception;
use context_module;
use dml_exception;
use dml_transaction_exception;
use external_api;
use external_function_parameters;
use external_single_structure;
use external_value;
use invalid_parameter_exception;
use JsonException;
use mod_kuet\exporter\question_exporter;
use mod_kuet\models\questions;
use mod_kuet\models\sessions;
use mod_kuet\persistents\kuet_questions;
use mod_kuet\persistents\kuet_sessions;
use moodle_exception;
use ReflectionException;

defined('MOODLE_INTERNAL') || die();
global $CFG;
require_once($CFG->libdir . '/externallib.php');

/**
 * Get question class
 */
class getquestion_external extends external_api {

    /**
     * Get question parameters validation
     *
     * @return external_function_parameters
     */
    public static function getquestion_parameters(): external_function_parameters {
        return new external_function_parameters(
            [
                'cmid' => new external_value(PARAM_INT, 'course module id'),
                'sid' => new external_value(PARAM_INT, 'session id'),
                'kid' => new external_value(PARAM_INT, 'kuet id'),
            ]
        );
    }

    /**
     * Get question
     *
     * @param int $cmid
     * @param int $sessionid
     * @param int $kid
     * @return array
     * @throws JsonException
     * @throws ReflectionException
     * @throws dml_exception
     * @throws coding_exception
     * @throws dml_transaction_exception
     * @throws invalid_parameter_exception
     * @throws moodle_exception
     */
    public static function getquestion(int $cmid, int $sessionid, int $kid): array {
        global $PAGE;
        self::validate_parameters(
            self::getquestion_parameters(),
            ['cmid' => $cmid, 'sid' => $sessionid, 'kid' => $kid]
        );
        $contextmodule = context_module::instance($cmid);
        $PAGE->set_context($contextmodule);
        $session = new kuet_sessions($sessionid);

        $kquestion = new kuet_questions($kid);
        /** @var questions $type */
        $type = questions::get_question_class_by_string_type($kquestion->get('qtype'));
        $question = $type::export_question($kid, $cmid, $sessionid, $session->get('kuetid'), true);
        $session = new kuet_sessions($sessionid);
        $question->programmedmode = in_array($session->get('sessionmode'),
            [sessions::PODIUM_PROGRAMMED, sessions::INACTIVE_PROGRAMMED, sessions::RACE_PROGRAMMED], true);
        return (array)(new question_exporter($question, ['context' => $contextmodule]))->export($PAGE->get_renderer('mod_kuet'));
    }

    /**
     * Get question returns
     *
     * @return external_single_structure
     */
    public static function getquestion_returns(): external_single_structure {
        return question_exporter::get_read_structure();
    }
}
