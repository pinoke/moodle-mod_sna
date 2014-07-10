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
 * The main hotpot configuration form
 *
 * It uses the standard core Moodle formslib. For more info about them, please
 * visit: http://docs.moodle.org/en/Development:lib/formslib.php
 *
 * @package   mod_sna
 * @copyright SunYu <648133664@qq.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot . '/course/moodleform_mod.php');
class mod_sna_mod_form extends moodleform_mod {
	function definition() {
	    global $CFG ,$COURSE, $DB;
	    $mform    =& $this->_form;	  
	    $mform->addElement('text', 'name', get_string('name','sna'), array('size'=>'64'));
	    $mform->setType('name', PARAM_CLEANHTML);
	    $mform->addRule('name', null, 'required', null, 'client');
        // Introduction.
        $this->add_intro_editor(false, get_string('introduction', 'sna')); 
        $this->standard_coursemodule_elements();
        $this->add_action_buttons();
    }
}
