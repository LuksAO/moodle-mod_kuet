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

// This line protects the file from being accessed by a URL directly.
defined('MOODLE_INTERNAL') || die();
global $PAGE, $CFG, $ADMIN;

if ($ADMIN->fulltree) {
    $settings = new theme_boost_admin_settingspage_tabs('modsettingjqshow', get_string('configtitle', 'mod_jqshow'));
    $page = new admin_settingpage('mod_jqshow_general', get_string('generalsettings', 'mod_jqshow'));

    // Modedit defaults.
    $setting = new admin_setting_heading('jqshow_header',
        get_string('jqshow_header', 'mod_jqshow'), '');
    $page->add($setting);

    $setting = new admin_setting_configtext('mod_jqshow/questiontime',
        get_string('questiontime', 'mod_jqshow'),
        get_string('questiontime_desc', 'mod_jqshow'), '40', PARAM_INT);
    $page->add($setting);

    $settings->add($page);


    $maxbytes = get_user_max_upload_file_size($PAGE->context, $CFG->maxbytes);
    $page = new admin_settingpage('mod_jqshow_ssl', get_string('sslcertificates', 'mod_jqshow'));
    $setting = new admin_setting_configstoredfile (
        'jqshow/certificate',
        get_string('certificate', 'mod_jqshow'),
        get_string('certificate_desc', 'mod_jqshow'),
        'certificate_ssl',
        0,
        ['maxfiles' => 1, 'accepted_types' => ['.crt', '.pem'], 'maxbytes' => $maxbytes]
    );
    $page->add($setting);

    $setting = new admin_setting_configstoredfile (
        'jqshow/privatekey',
        get_string('privatekey', 'mod_jqshow'),
        get_string('privatekey_desc', 'mod_jqshow'),
        'privatekey_ssl',
        0,
        ['maxfiles' => 1, 'accepted_types' => ['.pem', '.key'], 'maxbytes' => $maxbytes]
    );
    $page->add($setting);

    $setting = new admin_setting_configtext_with_maxlength(
        'jqshow/port',
        get_string('port', 'mod_jqshow'),
        get_string('port_desc', 'mod_jqshow'), '8080', PARAM_INT, 4, 4);
    $page->add($setting);

    $setting = new admin_setting_description(
        'jqshow/testssl',
        get_string('testssl', 'mod_jqshow'),
        html_writer::div(
            get_string('warningtest', 'mod_jqshow'),
            'alert alert-danger',
            ['role' => 'alert']) .
        html_writer::link(
            new moodle_url('/mod/jqshow/testssl.php'),
            get_string('testssl_desc', 'mod_jqshow'),
            ['target' => '_blank']
        ) .
        html_writer::tag('hr', '')
    );
    $page->add($setting);

    $settings->add($page);
}
