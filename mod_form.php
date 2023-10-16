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
 * Capability definitions for the quiz module.
 *
 * @package     mod_jqshow
 * @author      3&Punt <tresipunt.com>
 * @author      2023 Tomás Zafra <jmtomas@tresipunt.com> | Elena Barrios <elena@tresipunt.com>
 * @copyright   3iPunt <https://www.tresipunt.com/>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
global $CFG;
require_once($CFG->dirroot.'/course/moodleform_mod.php');

class mod_jqshow_mod_form extends moodleform_mod {

    /**
     * @return void
     * @throws coding_exception
     */
    public function definition() {
        $mform =& $this->_form;
        $mform->addElement('text', 'name', get_string('name', 'jqshow'), ['size' => '64']);
        $mform->setType('name', PARAM_TEXT);

        $this->standard_intro_elements(get_string('introduction', 'jqshow'));

        // Grade settings.
        $this->standard_grading_coursemodule_elements();
        $mform->removeElement('grade');
        if (property_exists($this->current, 'grade')) {
            $currentgrade = $this->current->grade;
        } else {
            $currentgrade = get_config('core', 'gradepointmax');
        }
        $mform->addElement('hidden', 'grade', $currentgrade);
        $mform->setType('grade', PARAM_FLOAT);

        $grademethodelement = $mform->createElement('select', 'grademethod', get_string('grademethod', 'jqshow'),
            mod_jqshow_get_grading_options());
        $mform->disabledIf('gradecat', 'grademethod', 'eq', \mod_jqshow\api\grade::MOD_OPTION_NO_GRADE);
        $mform->disabledIf('gradepass', 'grademethod', 'eq', \mod_jqshow\api\grade::MOD_OPTION_NO_GRADE);
        $mform->insertElementBefore($grademethodelement, 'gradecat');
        $mform->addHelpButton('grademethod', 'grademethod', 'jqshow');

        // Course module elements.
        $this->standard_coursemodule_elements();

        // Teams grade.
//        $mform->addElement('header', 'teamsgrade', get_string('teamsgradeheader', 'jqshow'));
//        $options = [groupmode::TEAM_GRADE_FIRST => get_string('team_grade_first', 'mod_jqshow'),
////            groupmode::TEAM_GRADE_LAST => 'last',
////            groupmode::TEAM_GRADE_AVERAGE => 'average'
//        ];
//        $mform->addElement('select', 'teamgrade', get_string('teamgrade', 'jqshow'), $options);
//        $mform->disabledIf('teamgrade', 'groupmode', 'eq', 0);
//        $mform->addHelpButton('teamgrade', 'teamgrade', 'jqshow');
//        $mform->setType('teamgrade', PARAM_RAW);

        $this->add_action_buttons();
    }

    /**
     * Add custom completion rules.
     *
     * @return array Array of string IDs of added items, empty array if none
     * @throws coding_exception
     */
    public function add_completion_rules() {
        $mform =& $this->_form;

        $mform->addElement(
            'advcheckbox',
            'completionanswerall',
            get_string('completionansweralllabel', 'jqshow'),
            get_string('completionansweralldesc', 'jqshow')
        );
        // Enable this completion rule by default.
        $mform->setDefault('completionanswerall', 0);
        $mform->setType('completionanswerall', PARAM_INT);
        return ['completionanswerall'];
    }

    /**
     * Determines if completion is enabled for this module.
     *
     * @param array $data
     * @return bool
     */
    public function completion_rule_enabled($data) {
        return !empty($data['completionanswerall']);
    }
}