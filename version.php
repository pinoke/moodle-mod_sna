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
 * @package   mod_sna
 * @copyright 2014 SunYu 648133664@qq.com
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
defined('MOODLE_INTERNAL') || die();
 

$module->requires  = 2013051400;
$module->cron      = 0;
$module->component = 'mod_sna';
$module->maturity  = MATURITY_STABLE;
$module->release   = 'v2.6-r1';//http://docs.moodle.org/dev/version.php
$module->version   = 2014071000;
$module->dependencies = array(
    'mod_forum' => ANY_VERSION,
);
