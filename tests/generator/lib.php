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

defined('MOODLE_INTERNAL') || die();

/**
 *
 * @package     mod_jqshow
 * @author      3&Punt <tresipunt.com>
 * @author      2023 Tomás Zafra <jmtomas@tresipunt.com> | Elena Barrios <elena@tresipunt.com>
 * @category   test
 * @copyright   3iPunt <https://www.tresipunt.com/>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_jqshow_generator extends testing_module_generator {

    /**
     * @param $record
     * @param array|null $options
     * @return stdClass
     * @throws coding_exception
     */
    public function create_instance($record = null, array $options = null) {
        $record = (array)$record;
        $record['showdescription'] = 1;
        return parent::create_instance($record, $options);
    }

    /**
     * @param stdClass $jqshow
     * @return int
     * @throws \core\invalid_persistent_exception
     * @throws coding_exception
     */
    public function create_session(stdClass $jqshow, stdClass $sessionmock) {
        $sessions = new \mod_jqshow\models\sessions($jqshow, $jqshow->cmid);
        return $sessions::save_session($sessionmock);
    }
}
