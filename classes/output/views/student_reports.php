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
 * Student reports rendered
 *
 * @package    mod_kuet
 * @copyright  2023 Proyecto UNIMOODLE {@link https://unimoodle.github.io}
 * @author     UNIMOODLE Group (Coordinator) <direccion.area.estrategia.digital@uva.es>
 * @author     3IPUNT <contacte@tresipunt.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_kuet\output\views;

use coding_exception;
use dml_exception;
use JsonException;
use mod_kuet\api\grade;
use mod_kuet\helpers\reports;
use mod_kuet\kuet;
use moodle_exception;
use moodle_url;
use renderable;
use renderer_base;
use stdClass;
use templatable;

/**
 *  Student reports renderable class
 */
class student_reports implements renderable, templatable {

    /**
     * @var int kuet module
     */
    public int $kuetid;
    /**
     * @var int course module id
     */
    public int $cmid;
    /**
     * @var int sessionid
     */
    public int $sid;

    /**
     * Contructor
     *
     * @param int $cmid
     * @param int $kuetid
     * @param int $sid
     */
    public function __construct(int $cmid, int $kuetid, int $sid) {
        $this->kuetid = $kuetid;
        $this->cmid = $cmid;
        $this->sid = $sid;
    }

    /**
     * Export for template
     *
     * @param renderer_base $output
     * @return stdClass
     * @throws JsonException
     * @throws coding_exception
     * @throws dml_exception
     * @throws moodle_exception
     */
    public function export_for_template(renderer_base $output): stdClass {
        global $USER;
        $kuet = new kuet($this->cmid);
        $data = new stdClass();
        $data->kuetid = $this->kuetid;
        $data->cmid = $this->cmid;
        if ($this->sid === 0) {
            $data->allreports = true;
            $data->endedsessions = $kuet->get_completed_sessions();
            $data->groupmode = false;
            foreach ($data->endedsessions as $endedsession) {
                $endedsession->viewreporturl = (new moodle_url('/mod/kuet/reports.php',
                    ['cmid' => $this->cmid, 'sid' => $endedsession->sessionid, 'userid' => $USER->id]))->out(false);
                $data->score = round(grade::get_session_grade($USER->id, $endedsession->sessionid, $this->kuetid), 2);
            }
        } else {
            $data = reports::get_student_report($this->cmid, $this->sid);
        }
        return $data;
    }
}
