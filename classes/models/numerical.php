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
 * Numerical question type model
 *
 * @package    mod_kuet
 * @copyright  2023 Proyecto UNIMOODLE {@link https://unimoodle.github.io}
 * @author     UNIMOODLE Group (Coordinator) <direccion.area.estrategia.digital@uva.es>
 * @author     3IPUNT <contacte@tresipunt.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_kuet\models;

use coding_exception;
use context_module;
use core\invalid_persistent_exception;
use dml_exception;
use dml_transaction_exception;
use invalid_parameter_exception;
use JsonException;
use mod_kuet\api\grade;
use mod_kuet\api\groupmode;
use mod_kuet\external\numerical_external;
use mod_kuet\helpers\reports;
use mod_kuet\persistents\kuet;
use mod_kuet\persistents\kuet_questions;
use mod_kuet\persistents\kuet_questions_responses;
use mod_kuet\persistents\kuet_sessions;
use moodle_exception;
use pix_icon;
use qtype_numerical_answer_processor;
use qtype_numerical_question;
use question_bank;
use question_definition;
use ReflectionClass;
use ReflectionException;
use stdClass;
use mod_kuet\interfaces\questionType;



/**
 * Numerical question type model class
 */
class numerical extends questions implements questionType {

    /**
     * Constructor
     *
     * @param int $kuetid
     * @param int $cmid
     * @param int $sid
     * @return void
     */
    public function construct(int $kuetid, int $cmid, int $sid): void {
        parent::__construct($kuetid, $cmid, $sid);
    }

    /**
     * Export question
     *
     * @param int $kid
     * @param int $cmid
     * @param int $sessionid
     * @param int $kuetid
     * @param bool $preview
     * @return object
     * @throws JsonException
     * @throws coding_exception
     * @throws dml_exception
     * @throws dml_transaction_exception
     * @throws moodle_exception
     * @throws ReflectionException
     */
    public static function export_question(int $kid, int $cmid, int $sessionid, int $kuetid, bool $preview = false): object {
        $session = kuet_sessions::get_record(['id' => $sessionid]);
        $kuetquestion = kuet_questions::get_record(['id' => $kid]);
        $question = question_bank::load_question($kuetquestion->get('questionid'));
        if (!assert($question instanceof qtype_numerical_question)) {
            throw new moodle_exception('question_nosuitable', 'mod_kuet', '',
                [], get_string('question_nosuitable', 'mod_kuet'));
        }
        $type = $question->get_type_name();
        $data = self::get_question_common_data($session, $cmid, $sessionid, $kuetid, $preview, $kuetquestion, $type);
        $data->$type = true;
        $data->qtype = $type;
        $data->questiontext =
            self::get_text($cmid, $question->questiontext, $question->questiontextformat, $question->id, $question, 'questiontext');
        $data->questiontextformat = $question->questiontextformat;
        $data->name = $question->name;
        $data->unitsleft = isset($question->unitdisplay) && $question->unitdisplay === 1;
        if (isset($question->ap) && assert($question->ap instanceof qtype_numerical_answer_processor)) {
            $data->units = [];
            $reflection = new ReflectionClass($question->ap);
            $units = $reflection->getProperty('units');
            $units->setAccessible(true);
            $unitid = 0;
            foreach ($units->getValue($question->ap) as $key => $unit) {
                $data->units[$key] = [];
                $data->units[$key]['unitid'] = 'unit_' . $unitid;
                $data->units[$key]['unittext'] = $key;
                $data->units[$key]['multiplier'] = $unit;
            }
            $data->units = array_values($data->units);
            if (isset($question->unitdisplay)) {
                switch ($question->unitdisplay) {
                    case 0:
                    default:
                        $data->unitdisplay = false;
                        break;
                    case 1:
                        $data->unitdisplay = true;
                        $data->showunitsradio = true;
                        break;
                    case 2:
                        $data->unitdisplay = true;
                        $data->showunitsselect = true;
                        break;
                }
            } else {
                $data->unitdisplay = false;
            }
        }
        return $data;
    }

    /**
     * Export question response
     *
     * @param stdClass $data
     * @param string $response
     * @param int $result
     * @return stdClass
     * @throws JsonException
     * @throws coding_exception
     * @throws dml_exception
     * @throws dml_transaction_exception
     * @throws invalid_parameter_exception
     * @throws invalid_persistent_exception
     * @throws moodle_exception
     */
    public static function export_question_response(stdClass $data, string $response, int $result = 0): stdClass {
        $responsedata = json_decode($response, false);
        if (!isset($responsedata->response) || (is_array($responsedata->response) && count($responsedata->response) === 0)) {
            $responsedata->response = '';
            $responsedata->unit = '';
            $responsedata->multiplier = '';
        }
        if (isset($responsedata->unit) && $responsedata->unit !== '') {
            foreach ($data->units as $key => $unit) {
                if ($unit['unittext'] === $responsedata->unit) {
                    $data->units[$key]['unitselected'] = true;
                    break;
                }
            }
        }
        $data->answered = true;
        $dataanswer = numerical_external::numerical(
            $responsedata->response,
            $responsedata->unit,
            $responsedata->multiplier,
            $data->sessionid,
            $data->kuetid,
            $data->cmid,
            $data->questionid,
            $data->kid,
            $responsedata->timeleft,
            true
        );

        $data->hasfeedbacks = $dataanswer['hasfeedbacks'];
        $data->numericalresponse = $responsedata->response;
        $data->seconds = $responsedata->timeleft;
        $data->programmedmode = $dataanswer['programmedmode'];
        $data->jsonresponse = base64_encode(json_encode($dataanswer, JSON_THROW_ON_ERROR));
        $data->statistics = $dataanswer['statistics'] ?? '0';
                return $data;
    }

    /**
     * Get question report
     *
     * @param kuet_sessions $session
     * @param question_definition $questiondata
     * @param stdClass $data
     * @param int $kid
     * @return void
     * @throws JsonException
     * @throws coding_exception
     * @throws dml_exception
     * @throws moodle_exception
     */
    public static function get_question_report(kuet_sessions     $session,
                                               question_definition $questiondata,
                                               stdClass            $data,
                                               int                 $kid): stdClass {

        if (!assert($questiondata instanceof qtype_numerical_question)) {
            throw new moodle_exception('question_nosuitable', 'mod_kuet', '',
                [], get_string('question_nosuitable', 'mod_kuet'));
        }
        $answers = [];
        $correctanswers = [];
        foreach ($questiondata->answers as $key => $answer) {
            $answers[$key]['answertext'] = $answer->answer;
            $answers[$key]['answerid'] = $answer->id;
            if ($answer->fraction === '0.0000000' || strpos($answer->fraction, '-') === 0) {
                $answers[$key]['result'] = 'incorrect';
                $answers[$key]['resultstr'] = get_string('incorrect', 'mod_kuet');
                $answers[$key]['fraction'] = round($answer->fraction, 2);
                $icon = new pix_icon('i/incorrect', get_string('incorrect', 'mod_kuet'), 'mod_kuet', [
                    'class' => 'icon',
                    'title' => get_string('incorrect', 'mod_kuet'),
                ]);
                $usersicon = new pix_icon('i/incorrect_users', '', 'mod_kuet', [
                    'class' => 'icon',
                    'title' => '',
                ]);
            } else if ($answer->fraction === '1.0000000') {
                $answers[$key]['result'] = 'correct';
                $answers[$key]['resultstr'] = get_string('correct', 'mod_kuet');
                $answers[$key]['fraction'] = '1';
                $icon = new pix_icon('i/correct', get_string('correct', 'mod_kuet'), 'mod_kuet', [
                    'class' => 'icon',
                    'title' => get_string('correct', 'mod_kuet'),
                ]);
                $usersicon = new pix_icon('i/correct_users', '', 'mod_kuet', [
                    'class' => 'icon',
                    'title' => '',
                ]);
            } else {
                $answers[$key]['result'] = 'partially';
                $answers[$key]['resultstr'] = get_string('partially_correct', 'mod_kuet');
                $answers[$key]['fraction'] = round($answer->fraction, 2);
                $icon = new pix_icon('i/correct', get_string('partially_correct', 'mod_kuet'), 'mod_kuet', [
                    'class' => 'icon',
                    'title' => get_string('partially_correct', 'mod_kuet'),
                ]);
                $usersicon = new pix_icon('i/partially_users', '', 'mod_kuet', [
                    'class' => 'icon',
                    'title' => '',
                ]);
            }
            $answers[$key]['resulticon'] = $icon->export_for_pix();
            $answers[$key]['usersicon'] = $usersicon->export_for_pix();
            $answers[$key]['numticked'] = 0;
            if ($answer->fraction !== '0.0000000') { // Answers with punctuation, even if negative.
                $correctanswers[$key]['response'] = $answer->answer;
                $correctanswers[$key]['score'] = grade::get_rounded_mark($questiondata->defaultmark * $answer->fraction);
            }
        }
        $gmembers = [];
        if ($session->is_group_mode()) {
            $gmembers = groupmode::get_one_member_of_each_grouping_group($session->get('groupings'));
        }
        $responses = kuet_questions_responses::get_question_responses($session->get('id'), $data->kuetid, $kid);
        foreach ($responses as $response) {
            if ($session->is_group_mode() && !in_array($response->get('userid'), $gmembers)) {
                continue;
            }
            $other = json_decode(base64_decode($response->get('response')), false);
            if (isset($other->response) && $other->response !== '') {
                foreach ($answers as $key => $answer) {
                    if ($answer['answertext'] === $other->response) {
                        $answers[$key]['numticked']++;
                    }
                }
            }
        }
        $data->correctanswers = array_values($correctanswers);
        $data->answers = array_values($answers);
        return $data;
    }

    /**
     * Get ranking for the question
     *
     * @param stdClass $participant
     * @param kuet_questions_responses $response
     * @param array $answers
     * @param kuet_sessions $session
     * @param kuet_questions $question
     * @return stdClass
     * @throws JsonException
     * @throws coding_exception
     * @throws dml_exception|moodle_exception
     */
    public static function get_ranking_for_question(
        stdClass $participant,
        kuet_questions_responses $response,
        array $answers,
        kuet_sessions $session,
        kuet_questions $question): stdClass {

        $participant->response = grade::get_result_mark_type($response);
        $participant->responsestr = get_string($participant->response, 'mod_kuet');
        $points = grade::get_simple_mark($response);
        $spoints = grade::get_session_grade($participant->participantid, $session->get('id'),
            $session->get('kuetid'));
        if ($session->is_group_mode()) {
            $participant->grouppoints = grade::get_rounded_mark($spoints);
        } else {
            $participant->userpoints = grade::get_rounded_mark($spoints);
        }
        $participant->score_moment = grade::get_rounded_mark($points);
        $participant->time = reports::get_user_time_in_question($session, $question, $response);
        return $participant;
    }

    /**
     * Get question response
     *
     * @param int $cmid
     * @param int $kid
     * @param int $questionid
     * @param int $sessionid
     * @param int $kuetid
     * @param string $statmentfeedback
     * @param int $userid
     * @param int $timeleft
     * @param array $custom
     * @return void
     * @throws JsonException
     * @throws coding_exception
     * @throws invalid_persistent_exception
     * @throws moodle_exception
     */
    public static function question_response(
        int $cmid,
        int $kid,
        int $questionid,
        int $sessionid,
        int $kuetid,
        string $statmentfeedback,
        int $userid,
        int $timeleft,
        array $custom
    ): void {
        $responsetext = $custom['responsetext'];
        $unit = $custom['unit'];
        $multiplier = $custom['multiplier'];
        $result = $custom['result'];
        $answerfeedback = $custom['answerfeedback'];
        $cmcontext = context_module::instance($cmid);
        $isteacher = has_capability('mod/kuet:managesessions', $cmcontext);
        if ($isteacher !== true) {
            $session = new kuet_sessions($sessionid);
            $response = new stdClass();
            $response->hasfeedbacks = (bool)($statmentfeedback !== '' | $answerfeedback !== '');
            $response->timeleft = $timeleft;
            $response->type = questions::NUMERICAL;
            $response->response = $responsetext; // 3IP validate html and special characters.
            $response->unit = $unit;
            $response->multiplier = $multiplier;
            if ($session->is_group_mode()) {
                parent::add_group_response($kuetid, $session, $kid, $questionid, $userid, $result, $response);
            } else {
                // Individual.
                kuet_questions_responses::add_response(
                    $kuetid, $sessionid, $kid, $questionid, $userid, $result, json_encode($response, JSON_THROW_ON_ERROR)
                );
            }
        }
    }

    /**
     * Get simple mark
     *
     * @param stdClass $useranswer
     * @param kuet_questions_responses $response
     * @return float
     * @throws JsonException
     * @throws coding_exception
     * @throws dml_exception
     * @throws dml_transaction_exception
     * @throws moodle_exception
     */
    public static function get_simple_mark(stdClass $useranswer, kuet_questions_responses $response): float {
        $mark = 0;
        $question = question_bank::load_question($response->get('questionid'));
        $kuet = new kuet($response->get('kuet'));
        [$course, $cm] = get_course_and_cm_from_instance($response->get('kuet'), 'kuet', $kuet->get('course'));
        if (assert($question instanceof qtype_numerical_question)) {
            questions::get_text(
                $cm->id, $question->generalfeedback, $question->generalfeedbackformat, $question->id, $question, 'generalfeedback'
            );
            $jsonresponse = json_decode(base64_decode($response->get('response')), false);
            $moodleresult = $question->grade_response(['answer' => $jsonresponse->response, 'unit' => $jsonresponse->unit]);
            if (isset($moodleresult[0])) {
                $mark = $moodleresult[0];
            }
        }
        return (float)$mark;
    }

    /**
     * Get question statistics
     *
     * @param question_definition $question
     * @param kuet_questions_responses[] $responses
     * @return array
     * @throws coding_exception
     */
    public static function get_question_statistics(question_definition $question, array $responses): array {
        $statistics = [];
        $total = count($responses);
        list($correct, $incorrect, $invalid, $partially, $noresponse) = grade::count_result_mark_types($responses);
        $statistics[0]['correct'] = $correct !== 0 ? round($correct * 100 / $total, 2) : 0;
        $statistics[0]['failure'] = $incorrect !== 0 ? round($incorrect * 100 / $total, 2) : 0;
        $statistics[0]['partially'] = $partially !== 0 ? round($partially * 100 / $total, 2) : 0;
        $statistics[0]['noresponse'] = $noresponse !== 0 ? round($noresponse * 100 / $total, 2) : 0;
        return $statistics;
    }
}
