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
 * True-false question type API
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
use core\invalid_persistent_exception;
use dml_exception;
use dml_transaction_exception;
use external_api;
use external_function_parameters;
use external_single_structure;
use external_value;
use invalid_parameter_exception;
use JsonException;
use mod_kuet\models\questions;
use mod_kuet\models\sessions;
use mod_kuet\models\truefalse;
use mod_kuet\persistents\kuet_sessions;
use moodle_exception;
use question_bank;

defined('MOODLE_INTERNAL') || die();
global $CFG;
require_once($CFG->libdir . '/externallib.php');
require_once($CFG->dirroot. '/question/engine/bank.php');

/**
 * True-false question type class
 */
class truefalse_external extends external_api {

    /**
     * True-false question type parameters validation
     *
     * @return external_function_parameters
     */
    public static function truefalse_parameters(): external_function_parameters {
        return new external_function_parameters(
            [
                'answerid' => new external_value(PARAM_INT, 'answer id'),
                'sessionid' => new external_value(PARAM_INT, 'id of session'),
                'kuetid' => new external_value(PARAM_INT, 'id of kuet'),
                'cmid' => new external_value(PARAM_INT, 'id of cm'),
                'questionid' => new external_value(PARAM_INT, 'id of question'),
                'kid' => new external_value(PARAM_INT, 'id of question in kuet_questions'),
                'timeleft' => new external_value(PARAM_INT, 'Time left of question, if question has time, else 0.'),
                'preview' => new external_value(PARAM_BOOL, 'preview or not for grade'),
            ]
        );
    }

    /**
     * True-false question type
     *
     * @param int $answerid
     * @param int $sessionid
     * @param int $kuetid
     * @param int $cmid
     * @param int $questionid
     * @param int $kid
     * @param int $timeleft
     * @param bool $preview
     * @return array
     * @throws JsonException
     * @throws coding_exception
     * @throws dml_exception
     * @throws dml_transaction_exception
     * @throws invalid_parameter_exception
     * @throws invalid_persistent_exception
     * @throws moodle_exception
     */
    public static function truefalse(
        int $answerid, int $sessionid, int $kuetid, int $cmid, int $questionid, int $kid, int $timeleft, bool $preview
    ): array {
        global $PAGE, $USER;
        self::validate_parameters(
            self::truefalse_parameters(),
            [
                'answerid' => $answerid,
                'sessionid' => $sessionid,
                'kuetid' => $kuetid,
                'cmid' => $cmid,
                'questionid' => $questionid,
                'kid' => $kid,
                'timeleft' => $timeleft,
                'preview' => $preview,
            ]
        );
        $contextmodule = context_module::instance($cmid);
        $PAGE->set_context($contextmodule);

        $question = question_bank::load_question($questionid);
        $statmentfeedback = questions::get_text(
            $cmid, $question->generalfeedback, 1, $question->id, $question, 'generalfeedback'
        );
        $answertext = '0';
        $correctanswer = $question->rightanswer ? (int)$question->trueanswerid : (int)$question->falseanswerid;
        if ((int)$answerid === (int)$question->trueanswerid) {
            $answertext = '1';
            $answerfeedback = questions::get_text(
                    $cmid, $question->truefeedback, 1, (int) $question->trueanswerid, $question, 'answerfeedback'
                ) . '<br>';
        } else {
            $answerfeedback = questions::get_text(
                    $cmid, $question->falsefeedback, 1, (int) $question->falseanswerid, $question, 'answerfeedback'
                ) . '<br>';
        }
        if ($preview === false) {
            $custom = [
                'answerids' => $answerid,
                'answertexts' => $answertext,
                'correctanswers' => $correctanswer,
                'answerfeedback' => $answerfeedback,
            ];
            truefalse::question_response(
                $cmid,
                $kid,
                $questionid,
                $sessionid,
                $kuetid,
                $statmentfeedback,
                $USER->id,
                $timeleft,
                $custom
            );
        }
        $session = new kuet_sessions($sessionid);
        return [
            'reply_status' => true,
            'hasfeedbacks' => (bool)($statmentfeedback !== '' | $answerfeedback !== ''),
            'statment_feedback' => $statmentfeedback,
            'answer_feedback' => $answerfeedback,
            'correct_answers' => $correctanswer,
            'programmedmode' => ($session->get('sessionmode') === sessions::PODIUM_PROGRAMMED ||
                $session->get('sessionmode') === sessions::INACTIVE_PROGRAMMED ||
                $session->get('sessionmode') === sessions::RACE_PROGRAMMED),
            'preview' => $preview,
        ];
    }

    /**
     * True-false question type return
     *
     * @return external_single_structure
     */
    public static function truefalse_returns(): external_single_structure {
        return new external_single_structure(
            [
                'reply_status' => new external_value(PARAM_BOOL, 'Status of reply'),
                'hasfeedbacks' => new external_value(PARAM_BOOL, 'Has feedback'),
                'statment_feedback' => new external_value(PARAM_RAW, 'HTML statment feedback', VALUE_OPTIONAL),
                'answer_feedback' => new external_value(PARAM_RAW, 'HTML answer feedback', VALUE_OPTIONAL),
                'correct_answers' => new external_value(PARAM_RAW, 'correct ansewrs ids separated by commas', VALUE_OPTIONAL),
                'programmedmode' => new external_value(PARAM_BOOL, 'Program mode for controls'),
                'preview' => new external_value(PARAM_BOOL, 'Question preview'),
            ]
        );
    }
}
