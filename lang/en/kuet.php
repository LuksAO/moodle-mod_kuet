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
 * English language strings
 *
 * @package    mod_kuet
 * @copyright  2023 Proyecto UNIMOODLE {@link https://unimoodle.github.io}
 * @author     UNIMOODLE Group (Coordinator) <direccion.area.estrategia.digital@uva.es>
 * @author     3IPUNT <contacte@tresipunt.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Kuet';
$string['pluginadministration'] = 'Kuet Administration';
$string['modulename'] = 'Kuet';
$string['modulenameplural'] = 'Kuets';
$string['kuet:addinstance'] = 'Add a new Kuet package';
$string['kuet:view'] = 'View Kuet';
$string['kuet:managesessions'] = 'Manage Sessions';
$string['kuet:startsession'] = 'Initialise Sessions';
$string['kuet:viewanonymousanswers'] = 'View anonymous answers';
$string['name'] = 'Name';
$string['introduction'] = 'Description';
$string['kuet_header'] = 'Kuet settings';
$string['questiontime'] = 'Question time';
$string['questiontime_desc'] = 'Time for every question in seconds.';
$string['questiontime_help'] = 'HELP! Time for every question in seconds.';
$string['teamsgradeheader'] = 'Teams grade';
$string['teamgrade'] = 'Teams grade';
$string['teamgrade_help'] = 'This is the way each team member is graded.';
$string['chooseoption'] = 'Choose an option';
$string['completiondetail:answerall'] = 'Participate on a session answering questions';
$string['completionansweralllabel'] = 'Participate on a session.';
$string['completionansweralldesc'] = 'Participate on a session answering questions.';
$string['configtitle'] = 'Kuet';
$string['generalsettings'] = 'General settings';
$string['sslcertificates'] = 'SSL Certificates';
$string['socket'] = 'Socket';
$string['sockettype'] = 'Socket type';
$string['sockettype_desc'] = 'A socket server is needed to initiate manual sessions. This socket can be local or external: <ul><li><b>No socket: </b>Manual session modes shall not be used</li><li><b>Local socket: </b>The socket will be started on the same server as this platform (needs to have certificates).</li><li><b>External: </b>You can initiate the socket on an external server, providing the url and port to the platform for connection.</li></ul>';
$string['nosocket'] = 'Do not use socket';
$string['local'] = 'Local';
$string['external'] = 'External';
$string['externalurl'] = 'External URL';
$string['externalurl_desc'] = 'URL where the socket is hosted. It can be an IP, but it must have HTTPS protocol.';
$string['downloadsocket'] = 'Download script to run on external server';
$string['downloadsocket_desc'] = 'Download from here the script to run it on an external server.<br>The administrator of the machine where this script is executed must provide a port and certificates to the script.<br>It is the responsibility of this administrator to ensure that the socket is functioning at all times.<br>';
$string['scriptphp'] = 'Download Script PHP';
$string['certificate'] = 'Certificate';
$string['certificate_desc'] = '.crt or .pem file of a valid SSL certificate for the server. This file may already be generated on the server, or you can create unique ones for this mod using tools such as <a href="https://zerossl.com" target="_blank">zerossl.com</a>.';
$string['privatekey'] = 'Private Key';
$string['privatekey_desc'] = '.pem or .key file of a valid SSL Private Key for the server. This file may already be generated on the server, or you can create unique ones for this mod using tools such as <a href="https://zerossl.com" target="_blank">zerossl.com</a>.';
$string['testssl'] = 'Connection test';
$string['testssl_desc'] = 'Socket connection test with SSL certificates';
$string['validcertificates'] = 'Valid SSL Certificates and Port';
$string['invalidcertificates'] = 'Invalid certificates or Port';
$string['socketclosed'] = 'Socket closed';
$string['connectionclosed'] = 'Connection closed';
$string['port'] = 'Port';
$string['port_desc'] = 'Port to make the connection. This port needs to be open, so you will need to check with your system administrator.';
$string['warningtest'] = 'This will attempt a connection to the socket with the current configuration. <b>Save the configuration before testing.</b>';
$string['generalsettings'] = 'General settings';
$string['session_name'] = 'Session name';
$string['session_name_placeholder'] = 'Session name';
$string['session_name_help'] = 'Write the session name';
$string['anonymousanswer'] = 'Anonymous answers';
$string['anonymousanswer_help'] = 'Choose one option.';
$string['advancemode'] = 'Advance mode';
$string['gamemode'] = 'Game mode';
$string['countdown'] = 'Show questions countdown';
$string['randomquestions'] = 'Random questions';
$string['randomanswers'] = 'Random answers';
$string['showfeedback'] = 'Show feedback';
$string['showfinalgrade'] = 'Show final grade';
$string['timesettings'] = 'Time settings';
$string['openquiz'] = 'Open quiz';
$string['openquizenable'] = 'Enable';
$string['startdate'] = 'Session start date';
$string['closequiz'] = 'Open quiz';
$string['closequizenable'] = 'Enable';
$string['enddate'] = 'Session end date';
$string['automaticstart'] = 'Automatic start';
$string['timelimit'] = 'Time limit';
$string['accessrestrictions'] = 'Access restrictions';
$string['next'] = 'Next';
$string['sessions'] = 'Sessions';
$string['sessions_info'] = 'All sessions are displayed';
$string['reports'] = 'Reports';
$string['reports_info'] = 'All completed sessions are displayed to access the report.';
$string['sessionreport'] = 'Session report';
$string['sessionreport_info'] = 'The report of the session is shown.';
$string['report'] = 'Report';
$string['active_sessions'] = 'Active Sessions';
$string['completed_sessions'] = 'Completed sessions';
$string['create_session'] = 'Create session';
$string['session_name'] = 'Session Name';
$string['questions_number'] = 'No. of questions';
$string['question_number'] = 'No. of question';
$string['session_date'] = 'Date';
$string['session_finishingdate'] = 'End date';
$string['session_actions'] = 'Actions';
$string['init_session'] = 'Init Session';
$string['init_session_desc'] = 'If you start a session manually, you can block scheduled sessions with automatic start. Make sure that there are no upcoming sessions before starting this session.<br>Are you sure you want to init session? ';
$string['end_session'] = 'End Session';
$string['end_session_error'] = 'The session could not be ended due to an error in communication with the server, please try again.';
$string['end_session_desc'] = 'Are you sure you want to end session?';
$string['end_session_manual_desc'] = 'If you end the session, you will close the connection of all students and they will no longer be able to answer this questionnaire.<br><b>Are you sure you want to end session?</b>';
$string['viewreport_session'] = 'View report';
$string['edit_session'] = 'Edit session';
$string['copy_session'] = 'Copy session';
$string['delete_session'] = 'Delete session';
$string['copysession'] = 'Copy Session';
$string['copysession_desc'] = 'Are you sure you want to copy this session? If the session has automatic start or start and end dates, these will need to be reset.';
$string['copysessionerror'] = 'An error occurred while copying the session. Check that you have the capacity "mod/kuet:managesessions", or try again later.';
$string['deletesession'] = 'Delete Session';
$string['deletesession_desc'] = 'Are you sure you want to delete this session?';
$string['deletesessionerror'] = 'An error occurred while deleting the session. Check that you have the capacity "mod/kuet:managesessions", or try again later.';
$string['confirm'] = 'Confirm';
$string['copy'] = 'Copy';
$string['groupings'] = 'Groupings';
$string['anonymiseresponses'] = 'Anonymise student responses';
$string['anonymiseallresponses'] = 'Fully anonymise student responses';
$string['noanonymiseresponses'] = 'Do not anonymise student responses';
$string['sessionconfiguration'] = 'Session configuration';
$string['sessionconfiguration_info'] = 'Set up your own session';
$string['questionsconfiguration'] = 'Question configuration';
$string['questionsconfiguration_info'] = 'Add the questions to the session';
$string['summarysession'] = 'Summary of the session';
$string['summarysession_info'] = 'Review the session';
$string['sessionstarted'] = 'Session started';
$string['multiplesessionerror'] = 'This session is not active or does not exist.';
$string['notactivesession'] = 'Oops, it looks like your teacher has not initialised a session yet...';
$string['notactivesessionawait'] = 'Wait for him to initiate it, or look at your latest reports.';
$string['nextsession'] = 'Next session:';
$string['nosession'] = 'No session initialised by the teacher';
$string['questions_list'] = 'Selected questions';
$string['questions_bank'] = 'Question Bank';
$string['question_position'] = 'Position';
$string['question_name'] = 'Name';
$string['question_type'] = 'Type';
$string['question_time'] = 'Time';
$string['question_version'] = 'Version';
$string['question_isvalid'] = 'Is valid';
$string['question_actions'] = 'Actions';
$string['improvise_cloudtags'] = 'Improvise Cloud Tags';
$string['select_category'] = 'Select a category';
$string['go_questionbank'] = 'Go to the question bank';
$string['selectall'] = 'Select/unselect all';
$string['selectvisibles'] = 'Select/unselect visibles';
$string['add_questions'] = 'Add questions';
$string['number_select'] = 'Selected questions: ';
$string['changecategory'] = 'Change of category';
$string['changecategory_desc'] = 'You have selected questions that have not been added to the session. If you change category you will lose this selection. Do you wish to continue?';
$string['selectone'] = 'Select questions';
$string['selectone_desc'] = 'Select at least one question to add to the session.';
$string['addquestions'] = 'Add questions';
$string['addquestions_desc'] = 'Are you sure about adding {$a} questions to the session?';
$string['deletequestion'] = 'Remove a question from the session';
$string['deletequestion_desc'] = 'Are you sure about removing this question from the session?';
$string['copyquestion'] = 'Copy a question from the session';
$string['copyquestion_desc'] = 'Are you sure about copying this question from the session?';
$string['questionnameheader'] = 'Question name: "{$a}"';
$string['questiontime'] = 'Question time';
$string['notimelimit'] = 'No time limit';
$string['gradesheader'] = 'Question grading';
$string['nograding'] = 'Ignore correct answer and grading';
$string['sessionalreadyexists'] = 'Session name already exists';
$string['manualmode'] = 'Manual';
$string['programmedmode'] = 'Programmed';
$string['inactivemode'] = 'Inactive';
$string['racemode'] = 'Race';
$string['podiummode'] = 'Podium';
$string['showgraderanking'] = 'Show ranking between questions';
$string['question_nosuitable'] = 'Not suitable with kuet plugin.';
$string['configuration'] = 'Configuration';
$string['end'] = 'End';
$string['questionidnotsent'] = 'questionidnotsent';
$string['question_index_string'] = '{$a->num} of {$a->total}';
$string['question'] = 'Question';
$string['feedback'] = 'Feedback';
$string['session_info'] = 'Session information';
$string['results'] = 'Results';
$string['students'] = 'Students';
$string['corrects'] = 'Corrects';
$string['incorrects'] = 'Incorrects';
$string['notanswers'] = 'Unanswered';
$string['points'] = 'Points';
$string['onlyinactivemodevalid'] = 'Only inactive game mode is valid with manual advance mode.';
$string['inactive_manual'] = 'Manual inactive';
$string['inactive_programmed'] = 'Programmed inactive';
$string['podium_manual'] = 'Manual podium';
$string['podium_programmed'] = 'Programmed Podium';
$string['race_manual'] = 'Manual Race';
$string['race_programmed'] = 'Programmed Race';
$string['sessionmode'] = 'Session mode';
$string['anonymousanswer_help'] = 'Teacher will not know who is answering in live quizzes';
$string['sessionmode_help'] = 'Session modes show different ways to use kuet sessions.';
$string['countdown_help'] = 'Enable this option so that students can see the countdown in each question. (Only if the question has time)';
$string['showgraderanking_help'] = 'Teacher will not see the ranking during a live session. Only available on podiums session modes.';
$string['showgraderankinghelp'] = 'SIN _Teacher will not see the ranking during a live session. Only available on podiums session modes.';
$string['randomquestions_help'] = 'Questions will appear in a random order for each student. Only valid for programmed session mode.';
$string['randomanswers_help'] = 'Answers will appear in a random order for each student.';
$string['showfeedback_help'] = 'After answering each question, feedback will appear. In manual mode, the teacher can show or hide the feedback for each question (only if the question contains feedback).';
$string['showfinalgrade_help'] = 'Final grade will appear after finishing the session.';
$string['startdate_help'] = 'Session will start automatically at this date. Start date only will be available with programmed sessions.';
$string['enddate_help'] = 'Session will end automatically at this date. End date only will be available with programmed sessions.';
$string['automaticstart_help'] = 'The session will start and end automatically if dates are set for it, so that it does not have to be started manually.';
$string['timelimit_help'] = 'Total time for the session';
$string['waitingroom'] = 'Waiting room';
$string['waitingroom_info'] = 'Check that everything is correct before starting the session.';
$string['sessionstarted'] = 'Session started';
$string['sessionstarted_info'] = 'You have started the session, you need to keep track of the questions.';
$string['participants'] = 'Participants';
$string['waitingroom_message'] = 'Hold on, we\'re leaving in no time...';
$string['ready_users'] = 'Ready participants';
$string['ready_groups'] = 'Ready groups';
$string['session_closed'] = 'The connection has been closed:';
$string['session_closed_info'] = 'This could be because the session has ended, because the teacher has ended the session, or because of a technical problem with the connection. Please log back into the session to reconnect, or contact your teacher.';
$string['system_error'] = 'An error has occurred and the connection has been closed.<br>It is not possible to continue with the session.';
$string['connection_closed'] = 'Connection Closed {$a->reason} - {$a->code}';
$string['backtopanelfromsession'] = 'Back to the sessions panel?';
$string['backtopanelfromsession_desc'] = 'If you come back, the session will not be initialised, and you can start it again at any time. Do you want to return to the session panel?';
$string['lowspeed'] = 'Your internet connection seems slow or unstable ({$a->downlink} Mbps, {$a->effectiveType}). This may cause unexpected behaviour, or sudden closure of the session.<br>We recommend that you do not init session until you have a good internet connection.';
$string['alreadyteacher'] = 'There is already a teacher imparting this session, so you cannot connect. Please wait for the current session to end before you can enter.';
$string['userdisconnected'] = 'User {$a} has been disconnected.';
$string['qtimelimit_help'] = 'Time to answer the question. Useful when session time is the sum of the questions time.';
$string['sessionlimittimebyquestionsenabled'] = 'This session has time limit of {$a}. The total time for each question shall be calculated by dividing the total time by the number of questions.<br>If you want to add a time per question, you must specify the session mode to "Time per question", specify a default time, and then you can set a time for each question using this form.';
$string['notimelimitenabled'] = 'The session is set without time limit.<br>If you want to add a time per question, you must specify the session mode to "Time per question", specify a default time, and then you can set a time for each question using this form.';
$string['incompatible_question'] = 'Question not compatible';
$string['controlpanel'] = 'Control panel';
$string['control'] = 'Control';
$string['next'] = 'Next';
$string['pause'] = 'Pause';
$string['play'] = 'Play';
$string['resend'] = 'Resend';
$string['jump'] = 'Jump';
$string['finishquestion'] = 'Finish the question';
$string['showhide'] = 'Show / hide';
$string['responses'] = 'Answers';
$string['statistics'] = 'Statistics';
$string['feedback'] = 'Feedback';
$string['questions'] = 'Questions';
$string['improvise'] = 'Improvise';
$string['vote'] = 'Vote';
$string['vote_tags'] = 'Vote tags';
$string['end'] = 'End';
$string['incorrect_sessionmode'] = 'Incorrect session mode';
$string['endsession'] = 'Session ended';
$string['endsession_info'] = 'You have reached the end of the session, and can now view the report with your results, or continue with the course.';
$string['timemode'] = 'Time mode';
$string['no_time'] = 'No time';
$string['session_time'] = 'Total session time';
$string['session_time_resume'] = 'Total session time: {$a}';
$string['sessiontime'] = 'Session time';
$string['timeperquestion'] = 'Time per question';
$string['sessiontime_help'] = 'The set time shall be divided by the number of questions, and equal time shall be allocated to all questions.';
$string['question_time'] = 'Time per question';
$string['question_time_help'] = 'A set time will be set for each question (you can do this after adding the question to the session). A default time will be set to allocate to those questions that do not have a defined time.';
$string['timemode_help'] = 'It should be noted that the time for each question corresponds to the time allowed for "answering", as answering each question will stop the time until the user moves on to the next one.<br><br><b>No time:</b> No time to finish the session. Time can be set for each question, some or none (in the question panel).<br><b>Total session time:</b> The set time shall be divided by the number of questions, and equal time shall be allocated to all questions.<br><b>Time per question:</b> A set time will be set for each question (you can do this after adding the question to the session). A default time will be set to allocate to those questions that do not have a defined time.<br><br><b>Important:</b> if in a timed question the user closes the browser or refreshes the page, that question will be considered undelivered, as it will be understood as an attempt to gain time to answer.';
$string['exitquestion'] = 'Exit the question';
$string['exitquestion_desc'] = 'If you leave the question, it will be marked as unanswered. Are you sure you want to leave?';
$string['erroreditsessionactive'] = 'It is not possible to edit an active session.';
$string['activesessionmanagement'] = 'Active session management';
$string['sessionnoquestions'] = 'No questions added to the session.';
$string['sessioncreating'] = 'You have not finished editing this session. You must reach step 3 of editing and click on finish.';
$string['sessionconflict'] = 'This session has a date conflict with other sessions closer to it and will not start automatically until the conflict is resolved.';
$string['sessionwarning'] = 'This session should have started, but there is currently an active session preventing it from doing so. It will start automatically as soon as the active session ends.';
$string['sessionerror'] = 'An error has occurred in this session and cannot be continued (deletion of active groups or groupings, deletion of questions, modification of mod settings, etc.). Duplicate it and/or delete it, but check all the configuration involved.';
$string['startminorend'] = 'The end date of the session cannot be equal to or less than the start date.';
$string['previousstarterror'] = 'The start date cannot be less than the current date.';
$string['sessionmanualactivated'] = 'The session {$a->sessionid} is active in kuetid -> {$a->kuetid}. The remainder of the session is omitted until the end of this session.';
$string['sessionactivated'] = 'Session {$a->sessionid} activated for kuetid {$a->kuetid}';
$string['sessionfinished'] = 'Session {$a->sessionid} finished for kuetid {$a->kuetid}';
$string['sessionfinishedformoreone'] = 'Session {$a->sessionid} finished for kuetid {$a->kuetid} because more than one session is active.';
$string['error_initsession'] = 'Error init session';
$string['error_initsession_desc'] = 'The session could not be started, either because a session has already been started or because of a specific error. Please refresh the page and try again.';
$string['success'] = 'Success';
$string['noresponse'] = 'No response';
$string['noevaluable'] = 'Not evaluable';
$string['invalid'] = 'Invalid';
$string['ranking'] = 'Ranking';
$string['participant'] = 'Participant';
$string['score'] = 'Score';
$string['viewreport_user'] = 'User report';
$string['viewreport_group'] = 'Group report';
$string['otheruserreport'] = 'You cannot view another student\'s report';
$string['userreport'] = 'User session report';
$string['userreport_info'] = 'The results of a session for a user are displayed.';
$string['groupreport'] = 'Group session report';
$string['groupreport_info'] = 'The results of a session for a group are displayed.';
$string['viewquestion_user'] = 'See answer';
$string['questionreport'] = 'Question Report';
$string['questionreport_info'] = 'The report of a question in a session is displayed.';
$string['statement'] = 'Statement';
$string['preview'] = 'Preview';
$string['correct_answers'] = 'Correct answers';
$string['percent_correct'] = '% Success';
$string['percent_incorrect'] = '% Incorrects';
$string['percent_partially'] = '% Partially corrects';
$string['percent_noresponse'] = '% No response';
$string['student_number'] = 'No. of students';
$string['response_number'] = 'No. of responses';
$string['average_time'] = 'Average time';
$string['correct'] = 'Correct';
$string['incorrect'] = 'Incorrect';
$string['response'] = 'Response';
$string['score_moment'] = 'Question score';
$string['time'] = 'Time';
$string['status'] = 'Status';
$string['anonymousanswers'] = 'The answers to this questionnaire are anonymous.';
$string['kuetnotexist'] = 'Unable to find kuet with id {$a}';
$string['jumpto_error'] = 'Must be a number between 1 and {$a}';
$string['session'] = 'Session';
$string['send_response'] = 'Send response';
$string['partially_correct'] = 'Partially correct';
$string['partially'] = 'Partially';
$string['scored_answers'] = 'Scored answers';
$string['provisional_ranking'] = 'Provisional Ranking';
$string['final_ranking'] = 'Final Ranking';
$string['score_obtained'] = 'Score obtained';
$string['total_score'] = 'Total score';
$string['grademethod'] = 'Grade method';
$string['grademethod_help'] = 'Choose the way to grade this module. Grade will appear on Moodle\'s gradebook';
$string['nograde'] = 'No grades';
$string['gradehighest'] = 'Session with highest grade';
$string['gradeaverage'] = 'Average of grade sessions';
$string['firstsession'] = 'First session grade';
$string['lastsession'] = 'Last session grade';
$string['sessionended'] = 'Session ended';
$string['sessionended_desc'] = 'When a user ends a session, an event is triggered to calculate the session grade.';
$string['sgrade'] = 'Grade the session';
$string['sgrade_desc'] = 'If this settings is checked, the mark obtained will be part of the activity grade on the gradebook.';
$string['sgrade_help'] = 'Check this setting if you want that the grade obtained on this session will be part of the activity grade.';
$string['session_gm_disabled'] = 'Disabled';
$string['session_gm_position'] = 'Rating relative to the situation in the ranking: [participants – position + 1]/[participants] * 100%';
$string['session_gm_position_short'] = '[participants – position + 1]/[participants] * 100%';
$string['session_gm_points'] = 'Rating relative to the points obtained: [score]/[maximum score] * 100%';
$string['session_gm_points_short'] = '[score]/[maximum score] * 100%';
$string['session_gm_combined'] = 'Average rating between the rating relative to the ranking situation and the rating relative to the points obtained.';
$string['session_gm_combined_short'] = 'Average between the ranking situation and the points obtained.';
$string['cachedef_grades'] = 'This is the description of the kuet cache grades';
$string['qstatus_0'] = 'Incorrect';
$string['qstatus_1'] = 'Success';
$string['qstatus_2'] = 'Partially';
$string['qstatus_3'] = 'No response';
$string['qstatus_4'] = 'Not evaluable';
$string['qstatus_5'] = 'Invalid';
$string['error_delete_instance'] = 'Error deleting mod Kuet.';
$string['team_grade_first'] = 'First answer';
$string['team_grade_last'] = 'Last answer';
$string['team_grade_average'] = 'Average answer';
$string['groupingid_not_selected'] = 'On group mode, a grouping must be selected';
$string['session_groupings_error'] = 'This activity is set as group mode. Every session must have a grouping selected.';
$string['session_groupings_no_groups'] = 'Grouping is empty. Please, select a grouping with group participants.';
$string['session_groupings_no_members'] = 'Grouping is empty. Please, select a grouping with participants.';
$string['session_groupings_same_user_in_groups'] = 'Participants must be part of just one group. Check this participants: {$a}';
$string['groupmode'] = 'Teams mode';
$string['fakegroup'] = 'Kuet team {$a}';
$string['fakegroupdescription'] = 'Kuet activity has created this group because there are participants on this course
that are not part of the grouping selected.';
$string['groups'] = 'Teams';
$string['abbreviationquestion'] = 'Q';
$string['timemodemustbeset'] = 'Total session time or question time must be set';
$string['timecannotbezero'] = 'Time can not be zero';
$string['nogroupingscreated'] = 'This activity is group mode type but no groupings are created on this course.
It is required that you create firstly a grouping on this course to be able to choose it on this activity.';
$string['notallowedspecialchars'] = 'No special characters allowed: ?!<>\\';
$string['notallowedpasting'] = 'Pasting text is not allowed';
$string['units'] = 'Units';
$string['unit'] = 'Unit';
$string['statement_improvising'] = 'Improvise question Cloud of Tags';
$string['waitteacher'] = 'Waiting for the teacher';
$string['teacherimprovising'] = 'The teacher is improvising a "Cloud of Tags" question, where you have to answer a question with one word.<br>As soon as the teacher finishes, the question will appear and you will be able to answer it, to see the answers together with those of all your classmates.';
$string['statement_improvise'] = 'Statement of the cloud of tags';
$string['statement_improvise_help'] = 'Remember that it should be a question that can preferably be answered in one word.';
$string['reply_improvise'] = 'Response';
$string['reply_improvise_help'] = 'Be the first to add a word to the word cloud. (Optional)';
$string['reply_improvise_student_help'] = 'Try to answer the question with one word.';
$string['submit'] = 'Submit';
$string['sessionrankingreport'] = 'Session Ranking Report';
$string['groupsessionrankingreport'] = 'Group Session Ranking Report';
$string['sessionquestionsreport'] = 'Session Questions Report';
$string['reportlink'] = 'Report Link';
$string['questionid'] = 'Id';
$string['isevaluable'] = 'Is evaluable?';
$string['alreadyanswered'] = 'A member of your group has already answered!';
$string['groupdisconnected'] = 'Group {$a} has been disconnected';
$string['groupmemberdisconnected'] = 'This group member {$a} has been disconnected';
$string['groupingremoved'] = 'This activity grouping has been removed or it has no members. You can not continue with this session.';
$string['groupremoved'] = 'Your group has been removed or it is not a member of this activity grouping. You can not continue with this session.';
$string['gocourse'] = 'Go back to your course';
$string['sessionerror'] = 'This session is not correctly configured';
$string['httpsrequired'] = 'It is mandatory to use https protocol on the platform to use Kuet.';
$string['sessionsnum'] = 'Number of sessions';
