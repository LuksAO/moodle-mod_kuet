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
 * Sessions view
 *
 * @package    mod_kuet
 * @copyright  2023 Proyecto UNIMOODLE {@link https://unimoodle.github.io}
 * @author     UNIMOODLE Group (Coordinator) <direccion.area.estrategia.digital@uva.es>
 * @author     3IPUNT <contacte@tresipunt.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_kuet\output\views;
use coding_exception;
use core\invalid_persistent_exception;
use mod_kuet\models\sessions;
use moodle_exception;
use renderable;
use stdClass;
use templatable;
use renderer_base;

/**
 * Sessions view renderable class
 */
class sessions_view implements renderable, templatable {

    /**
     * @var stdClass kuet module
     */
    protected stdClass $kuet;

    /**
     * @var int course module id
     */
    protected int $cmid;

    /**
     * Constructor
     *
     * @param stdClass $kuet
     * @param int $cmid
     */
    public function __construct(stdClass $kuet, int $cmid) {
        $this->kuet = $kuet;
        $this->cmid = $cmid;
    }

    /**
     * Template exporter
     *
     * @param renderer_base $output
     * @return stdClass
     * @throws coding_exception
     * @throws invalid_persistent_exception
     * @throws moodle_exception
     */
    public function export_for_template(renderer_base $output): stdClass {
        return (new sessions($this->kuet, $this->cmid))->export();
    }
}
