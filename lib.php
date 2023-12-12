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
 * @package    mod_kuet
 * @copyright  2023 Proyecto UNIMOODLE
 * @author     UNIMOODLE Group (Coordinator) <direccion.area.estrategia.digital@uva.es>
 * @author     3IPUNT <contacte@tresipunt.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use core\invalid_persistent_exception;
use core_calendar\action_factory;
use core_calendar\local\event\value_objects\action;
use core_completion\api;
use mod_kuet\api\grade;
use mod_kuet\persistents\kuet;

global $CFG;
require_once($CFG->dirroot . '/lib/gradelib.php');

/**
 * @uses FEATURE_GROUPS
 * @uses FEATURE_GROUPINGS
 * @uses FEATURE_MOD_INTRO
 * @uses FEATURE_COMPLETION_TRACKS_VIEWS
 * @uses FEATURE_COMPLETION_HAS_RULES
 * @uses FEATURE_GRADE_HAS_GRADE
 * @uses FEATURE_GRADE_OUTCOMES
 * @param string $feature FEATURE_xx constant for requested feature
 * @return true|null True if module supports feature, false if not, null if doesn't know
 */
function kuet_supports(string $feature): ?bool {
    switch($feature) {
        case FEATURE_GROUPINGS:
        case FEATURE_MOD_INTRO:
        case FEATURE_COMPLETION_HAS_RULES:
        case FEATURE_GRADE_HAS_GRADE:
        case FEATURE_GRADE_OUTCOMES:
        case FEATURE_BACKUP_MOODLE2:
        case FEATURE_SHOW_DESCRIPTION:
        case FEATURE_CONTROLS_GRADE_VISIBILITY:
        case FEATURE_USES_QUESTIONS:
        case FEATURE_GROUPS:
            return true;
        default:
            return null;
    }
}
/**
 *
 * @param stdClass $data An object from the form in mod.html.
 * @return int The id of the newly inserted kuet record.
 * @throws dml_exception
 */
function kuet_add_instance(stdClass $data): int {
    global $DB, $USER;

    $cmid = $data->coursemodule;

    // Create kuet on db.
    $record = new stdClass();
    $record->course = $data->course;
    $record->name = $data->name;
    $record->intro = $data->intro;
    $record->introformat = $data->introformat;
    $record->teamgrade = isset($data->teamgrade) ?? $data->teamgrade;
    $record->grademethod = $data->grademethod;
    $record->completionanswerall = $data->completionanswerall ?? 0;
    $record->usermodified = $USER->id;
    $kuet = new kuet(0, $record);
    $kuet->create();
    $data->id  = $kuet->get('id');

    // Update course module record - from now on this instance properly exists and all function may be used.
    $DB->set_field('course_modules', 'instance', $data->id, array('id' => $cmid));

    if (!empty($data->completionexpected)) {
        api::update_completion_date_event($cmid, 'kuet', $kuet->to_record(), $data->completionexpected);
    }

    mod_kuet_grade_item_update($data, null);
    return $data->id;
}

/**
 * @param stdClass $data An object from the form in mod.html
 * @return bool Success/Fail
 * @throws invalid_persistent_exception
 * @throws coding_exception
 * @throws dml_exception
 * @throws moodle_exception
 */
function kuet_update_instance(stdClass $data): bool {
    global $USER;

    $teamgrade = isset($data->teamgrade) ?? $data->teamgrade;
    // Update kuet record.
    $kuet = new kuet($data->instance);
    $kuet->set('name', $data->name);
    $kuet->set('intro', $data->intro);
    $kuet->set('introformat', $data->introformat);
    $kuet->set('teamgrade', $teamgrade);
    $kuet->set('grademethod', $data->grademethod);
    $kuet->set('completionanswerall', $data->completionanswerall ?? 0);
    $kuet->set('usermodified', $USER->id);
    $kuet->update();

    grade::recalculate_mod_mark($data->{'update'}, $data->instance);
    $data->id = $data->instance;
    mod_kuet_grade_item_update($data, null);

    return true;
}

/**
 *
 * @param int $id Id of the module instance
 * @return boolean Success/Failure
 * @throws dml_exception
 */
function kuet_delete_instance(int $id): bool {
    global $DB, $CFG;
    require_once($CFG->dirroot . '/lib/gradelib.php');
    $kuet = $DB->get_record('kuet', ['id' => $id], '*', MUST_EXIST);
    if (!$kuet) {
        return false;
    }
    // Finally delete the kuet object.
    $DB->delete_records('kuet', ['id' => $id]);
    $DB->delete_records('kuet_grades', ['kuet' => $id]);
    $DB->delete_records('kuet_questions', ['kuetid' => $id]);
    $DB->delete_records('kuet_questions_responses', ['kuet' => $id]);
    $DB->delete_records('kuet_sessions', ['kuetid' => $id]);
    $DB->delete_records('kuet_sessions_grades', ['kuet' => $id]);
    $DB->delete_records('kuet_user_progress', ['kuet' => $id]);

    grade_update('mod/kuet',
        $kuet->course,
        'mod',
        'kuet',
        $id,
        0,
        null,
        ['deleted' => 1]);
    return true;
}

/**
 *
 * @param stdClass $coursemodule The coursemodule object (record).
 * @return cached_cm_info|bool
 * @throws dml_exception
 */
function kuet_get_coursemodule_info(stdClass $coursemodule): ?cached_cm_info {
    global $DB;

    $dbparams = ['id' => $coursemodule->instance];
    $fields = 'id, name, intro, introformat, completionanswerall';
    if (!$kuet = $DB->get_record('kuet', $dbparams, $fields)) {
        return false;
    }

    $result = new cached_cm_info();
    $result->name = $kuet->name;

    if ($coursemodule->showdescription) {
        // Convert intro to html. Do not filter cached version, filters run at display time.
        $result->content = format_module_intro('kuet', $kuet, $coursemodule->id, false);
    }

    // Populate the custom completion rules as key => value pairs, but only if the completion mode is 'automatic'.
    if ((int)$coursemodule->completion === COMPLETION_TRACKING_AUTOMATIC) {
        $result->customdata['customcompletionrules']['completionanswerall'] = $kuet->completionanswerall;
    }

    return $result;
}

/**
 * @param cm_info|stdClass $cm
 * @return array $descriptions the array of descriptions for the custom rules.
 * @throws coding_exception
 */
function mod_kuet_get_completion_active_rule_descriptions($cm): array {
    // Values will be present in cm_info, and we assume these are up to date.
    if (empty($cm->customdata['customcompletionrules'])
        || (int)$cm->completion !== COMPLETION_TRACKING_AUTOMATIC) {
        return [];
    }

    $descriptions = [];
    foreach ($cm->customdata['customcompletionrules'] as $key => $val) {
        switch ($key) {
            case 'completionanswerall':
                if (!empty($val)) {
                    $descriptions[] = get_string('completionanswerall', 'kuet');
                }
                break;
            default:
                break;
        }
    }
    return $descriptions;
}

/**
 * @param $server
 * @return void
 */
function mod_kuet_run_server_background($server) {
    switch (strtolower(PHP_OS_FAMILY)) {
        case "windows":
            pclose(popen("start /B php $server", "r"));
            break;
        case "linux":
            exec("php $server > /dev/null &");
            break;
        default:
            debugging("Unsupported OS" . strtolower(PHP_OS_FAMILY));
            break;
    }
}

/**
 * @throws moodle_exception
 * @throws coding_exception
 */
function mod_kuet_core_calendar_provide_event_action(
    calendar_event $event,
    action_factory $factory,
    int $userid = 0
): ?action {
    $cm = get_fast_modinfo($event->courseid, $userid)->instances['kuet'][$event->instance];

    if (!$cm->uservisible) {
        // The module is not visible to the user for any reason.
        return null;
    }

    $completion = new completion_info($cm->get_course());

    $completiondata = $completion->get_data($cm, false, $userid);

    if ($completiondata->completionstate !== COMPLETION_INCOMPLETE) {
        return null;
    }

    return $factory->create_instance(
        get_string('view'),
        new moodle_url('/mod/kuet/view.php', ['id' => $cm->id]),
        1,
        true
    );
}

/**
 * @param settings_navigation $settings
 * @param navigation_node $navref
 * @return void
 * @throws coding_exception
 * @throws moodle_exception
 */
function kuet_extend_settings_navigation(settings_navigation $settings, navigation_node $navref) {
    $cm = $settings->get_page()->cm;
    if (!$cm) {
        return;
    }
    $course = $settings->get_page()->course;
    if (!$course) {
        return;
    }
    $url = new moodle_url('/mod/kuet/reports.php', ['cmid' => $settings->get_page()->cm->id]);
    $node = navigation_node::create(get_string('reports', 'mod_kuet'),
        $url,
        navigation_node::TYPE_SETTING, null, 'mmod_kuet_reports');
    $navref->add_node($node);
}

/**
 * @param $password
 * @param $text
 * @return string|null
 */
function kuet_encrypt($password, $text) {
    $base64 = base64_encode($text);
    $arr = str_split($base64);
    $arrpass = str_split($password);
    $lastpassletter = 0;
    $encrypted = '';
    foreach ($arr as $value) {
        $letter = $value;
        $passwordletter = $arrpass[$lastpassletter];
        $temp = kuet_get_letter_from_alphabet_for_letter($passwordletter, $letter);
        if ($temp !== null) {
            $encrypted .= $temp;
        } else {
            return null;
        }
        if ($lastpassletter === (count($arrpass) - 1)) {
            $lastpassletter = 0;
        } else {
            $lastpassletter++;
        }
    }
    return $encrypted;
}


/**
 * @param $letter
 * @param $lettertochange
 * @return mixed|null
 */
function kuet_get_letter_from_alphabet_for_letter($letter, $lettertochange) {
    $abc = 'abcdefghijklmnopqrstuvwxyz0123456789=ABCDEFGHIJKLMNOPQRSTUVWXYZ/+-*';
    $posletter = strpos($abc, $letter);
    if ($posletter === false) {
        return null;
    }
    $poslettertochange = strpos($abc, $lettertochange);
    if ($poslettertochange === false) {
        return null;
    }
    $part1 = substr($abc, $posletter, strlen($abc));
    $part2 = substr($abc, 0, $posletter);
    $newabc = $part1 . $part2;
    $temp = str_split($newabc);
    return $temp[$poslettertochange];
}

function kuet_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, $options = []) {
    global $DB;
    if ($context->contextlevel != CONTEXT_MODULE) {
        return false;
    }
    if ($filearea != 'question') {
        return false;
    }
    require_course_login($course, true, $cm);

    $questionid = (int)array_shift($args);
    $quiz = $DB->get_record('kuet', ['id' => $cm->instance]);
    if (!$quiz) {
        return false;
    }
    $question = $DB->get_record('kuet_questions', [
        'questionid' => $questionid,
        'kuetid' => $cm->instance
    ]);
    if (!$question) {
        return false;
    }
    $fs = get_file_storage();
    $relative = implode('/', $args);
    $fullpath = "/$context->id/mod_kuet/$filearea/$questionid/$relative";
    $file = $fs->get_file_by_hash(sha1($fullpath));
    if (!$file || $file->is_directory()) {
        return false;
    }
    send_stored_file($file);
    return false;
}

function mod_kuet_question_pluginfile($course, $context, $component, $filearea, $qubaid, $slot,
                                          $args, $forcedownload, $options = []) {
    $fs = get_file_storage();
    $relative = implode('/', $args);
    $full = "/$context->id/$component/$filearea/$relative";
    $file = $fs->get_file_by_hash(sha1($full));
    if (!$file || $file->is_directory()) {
        send_file_not_found();
    }
    send_stored_file($file, 0, 0, $forcedownload, $options);
}

/**
 * @return array
 * @throws coding_exception
 */
function mod_kuet_get_grading_options() : array {
    return [
        grade::MOD_OPTION_NO_GRADE => get_string('nograde', 'mod_kuet'),
        grade::MOD_OPTION_GRADE_HIGHEST => get_string('gradehighest', 'mod_kuet'),
        grade::MOD_OPTION_GRADE_AVERAGE => get_string('gradeaverage', 'mod_kuet'),
        grade::MOD_OPTION_GRADE_FIRST_SESSION => get_string('firstsession', 'mod_kuet'),
        grade::MOD_OPTION_GRADE_LAST_SESSION => get_string('lastsession', 'mod_kuet')
    ];
}

/**
 * Update/create grade item for given data
 * @param stdClass $data A kuet instance
 * @param $grades Optional array/object of grade(s); 'reset' means reset grades in gradebook
 * @return int|null
 * @throws dml_exception
 */
function mod_kuet_grade_item_update(stdClass $data, $grades = null) {
    global $CFG;
    require_once($CFG->libdir.'/gradelib.php');


    if (!isset($data->id)) {
        return null;
    }
    $params = ['itemname' => $data->name, 'iteminstance' => $data->id];
    if (property_exists($data, 'cmidnumber')) { // May not be always present.
        $params['idnumber'] = $data->cmidnumber;
    }

    if ($data->grademethod == 0) {
        $params['gradetype'] = GRADE_TYPE_NONE;
    } else {
        $params['gradetype'] = GRADE_TYPE_VALUE;
        $params['grademax'] = get_config('core', 'gradepointmax');
        $params['grademin'] = 0;
    }
    if (is_null($grades)) {
        $params['reset'] = true;
    }
    return grade_update('mod/kuet', $data->course, 'mod', 'kuet', $data->id, 0, $grades, $params);

}

/**
 * @param $questionids
 * @return bool
 * @throws coding_exception
 * @throws dml_exception
 */
function kuet_questions_in_use($questionids) : bool {
    global $DB;
    [$sqlfragment, $params] = $DB->get_in_or_equal($questionids);
    $params['component'] = 'mod_kuet';
    $params['questionarea'] = 'slot';
    $sql = "SELECT jq.id
              FROM {kuet_questions} jq
             WHERE jq.questionid $sqlfragment";
    return $DB->record_exists_sql($sql, $params);
}

/**
 * @param string $url
 * @return string
 */
function generate_kuet_qrcode(string $url): string {
    if (class_exists(core_qrcode::class)) {
        $qrcode = new core_qrcode($url);
        return 'data:image/png;base64,' . base64_encode($qrcode->getBarcodePngData(15, 15));
    }
    return '';
}
