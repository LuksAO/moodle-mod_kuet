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
 * @package     mod_jqshow
 * @author      3&Punt <tresipunt.com>
 * @author      2023 Tomás Zafra <jmtomas@tresipunt.com> | Elena Barrios <elena@tresipunt.com>
 * @copyright   3iPunt <https://www.tresipunt.com/>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


/**
 * @return bool
 */
function xmldb_jqshow_uninstall(): bool {
    global $DB;
    try {
        $syscontext = context_system::instance();
        $fs = get_file_storage();
        if ($fs !== null && $syscontext !== null) {
            $certificatefiles = $fs->get_area_files(
                $syscontext->id, 'jqshow', 'certificate_ssl', 0, 'filename', false
            );
            foreach ($certificatefiles as $file) {
                $file->delete();
            }
            $privatekeyfiles = $fs->get_area_files(
                $syscontext->id, 'jqshow', 'privatekey_ssl', 0, 'filename', false
            );
            foreach ($privatekeyfiles as $file) {
                $file->delete();
            }
        }
        $dbman = $DB->get_manager();
        $jqshow = new xmldb_table('jqshow');
        $dbman->drop_table($jqshow);
        $jqshowgrades = new xmldb_table('jqshow_grades');
        $dbman->drop_table($jqshowgrades);
        $jqshowquestions = new xmldb_table('jqshow_questions');
        $dbman->drop_table($jqshowquestions);
        $questionsresponses = new xmldb_table('questions_responses');
        $dbman->drop_table($questionsresponses);
        $jqshowsessions = new xmldb_table('jqshow_sessions');
        $dbman->drop_table($jqshowsessions);
        $jqshowsessionsgrades = new xmldb_table('jqshow_sessions_grades');
        $dbman->drop_table($jqshowsessionsgrades);
        $jqshowuserprogress = new xmldb_table('jqshow_user_progress');
        $dbman->drop_table($jqshowuserprogress);
        return true;
    } catch (Exception $e) {
        return false;
    }
}