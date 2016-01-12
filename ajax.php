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
 * Handle password submissions via javascript popup
 *
 * @package   availability_password
 * @copyright 2016 Davo Smith, Synergy Learning
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('AJAX_SCRIPT', true);

require_once(dirname(__FILE__).'/../../../config.php');
global $PAGE;

$cmid = required_param('id', PARAM_INT);
$password = required_param('password', PARAM_RAW);
/** @var cm_info $cm */
list($course, $cm) = get_course_and_cm_from_cmid($cmid);

$url = new moodle_url('/availability/condition/password/ajax.php', array('id' => $cm->id));
$PAGE->set_url($url);

require_login($course, false);
require_sesskey();

$ret = (object) [
    'error' => 0,
    'success' => 0,
];
if (\availability_password\condition::submit_password_for_cm($cm, $password)) {
    $ret->success = 1;
}

echo json_encode($ret);
die();