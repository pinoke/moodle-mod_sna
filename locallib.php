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
 * Internal library of functions for module sna
 *
 * All the sna specific functions, needed to implement the module
 * logic, should go here. Never include this file from your lib.php!
 *
 * @package    mod
 * @subpackage sna
 * @copyright  2014 Sun Yu
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once("show.js");
require_once("snalib.php");

function sna_pt_show($course_id,$sna_id,$module_id)
{
	global $DB;
	global $CFG;
	$courseid = optional_param('courseid',null, PARAM_INT);
	$forumid = optional_param('forumid',null, PARAM_INT);
	$postsid = optional_param('postsid',null, PARAM_INT);
	$chartid = optional_param('chartid',null, PARAM_RAW);
	$sna_module_name='forum';
	$sna_module=$DB->get_record("modules",array("name"=>$sna_module_name));
	$sna_module_id=$sna_module->id;	
	$pt=$DB->record_exists("forum",array("course"=>$course_id));

	if($pt)
	{
	$pts=$DB->get_records("forum",array("course"=>$course_id));
	$url =$CFG->wwwroot.'/mod/sna/view.php?id='.$sna_id;
	echo "<form action=\"$url\" method=\"post\" id=\"sna_show\">";
	echo '<br>';
	echo (get_string('result', 'sna'));
    echo "<br />";
    echo "<input type=\"button\" id=\"butn\" value=\"course\" onclick=\"toggle('div1')\" />";
	echo "<br />";
	echo "<input type=\"button\" id=\"butn\" value=\"forum\" onclick=\"toggle('div2')\" />";
	echo "<br />";
	echo "<input type=\"button\" id=\"butn\" value=\"post\" onclick=\"toggle('div3')\" />";
	echo "<br />";
		
	echo "<div id=\"div1\"  style=\"display:none\">";
	echo (get_string('course', 'sna'));
	echo "<br>";
	$ptss=$DB->get_record("course",array("id"=>$course_id));
	echo "<input type=\"radio\"  name=\"courseid\" value=\"$course_id\" />$ptss->fullname";
	echo "</div>";
		
	echo "<div id=\"div2\"  style=\"display:none\">";
	echo (get_string('forum', 'sna'));
	echo "<br>";
	foreach($pts as $forum)
	{
		echo "<input type=\"radio\"  name=\"forumid\" value=\"$forum->id\" />$forum->name";
		echo "<br>";
		}
	echo "</div>";
	
	echo "<div id=\"div3\"  style=\"display:none\">";
	$count=1;
	echo (get_string('forum', 'sna'));
	echo "<br>";
	foreach($pts as $value)
	{
		echo "<input type=\"button\" style=\"background-color:yellow\" value=\"$value->name\" onclick=\"tog('divs$count')\"/>";
		echo "<br>";
		echo "<div  id=\"divs$count\"  style=\"display:none\">";
		echo (get_string('post', 'sna'));
		echo "<br>";
			$postss=$DB->get_records("forum_discussions",array("forum"=>$value->id));
			foreach($postss as $posts)
			{
				echo "<input type=\"radio\"  name=\"postsid\" value=\"$posts->id\" />$posts->name";
				echo "<br>";
			}
		echo "</div>";
		$count++;
		}
		echo "</div>";
		
		//choose chart
	echo '<br>';
	echo 'Please choose the chart';
	echo '<br>';
	echo "<input type=\"radio\"  name=\"chartid\" value=\"chart3\" />Sociogram";
	echo '<br>';
	echo "<input type=\"radio\"  name=\"chartid\" value=\"chart1\" />The names of the people involved";
	echo '<br>';
	echo "<input type=\"radio\"  name=\"chartid\" value=\"chart2\" />Indegree";
	echo '<br>';
	echo "<input type=\"radio\"  name=\"chartid\" value=\"chart4\" />Outdegree";
	echo '<br>';
	echo "<input type=\"radio\"  name=\"chartid\" value=\"chart5\" />Density";
	echo '<br>';
	echo "<input type=\"radio\"  name=\"chartid\" value=\"chart6\" />Point Centrality";
	echo '<br>';
	echo '<br>';
	echo "<input type=\"submit\" value=\"submit\" />";
	echo "</form>";
	echo '<br>';
	echo '<br>';	
		sna_draw_graph($sna_id,$courseid,$postsid,$forumid,$chartid);
	}
	else
	{
		get_string('error', 'sna');
		}
	}
function sna_draw_graph($sna_id,$courseid,$postsid,$forumid,$chartid)
{
	global $CFG;

	if($chartid=="chart1")
	{
		if($forumid)
		{
		sna_show_username(sna_show_forum_name_dots($forumid));
		echo(get_string('number', 'sna').count(sna_show_forum_name_dots($forumid)));
		}
		if($courseid)
		{
		sna_show_username(sna_show_course_name_dots($courseid));
		echo(get_string('number', 'sna').count(sna_show_course_name_dots($courseid)));
		}
		if($postsid)
		{
		sna_show_username(sna_show_post_name_dots($postsid));
		echo(get_string('number', 'sna').count(sna_show_post_name_dots($postsid)));
		}
	}
	else
	{		
		if($forumid)
		{
			
			$id1 =$forumid;
			$urli =$CFG->wwwroot.'/mod/sna/'.$chartid.'.php?id='.$id1.'&type=1'.'&sid='.$sna_id;
			echo "<img src=\"$urli\" />";
		}
		if($courseid)
		{
			$id1 =$courseid;
			$urli =$CFG->wwwroot.'/mod/sna/'.$chartid.'.php?id='.$id1.'&type=2'.'&sid='.$sna_id;
			echo "<img src=\"$urli\" />";
		}
		if($postsid)
		{
			$id1 =$postsid;
			$urli =$CFG->wwwroot.'/mod/sna/'.$chartid.'.php?id='.$id1.'&type=3'.'&sid='.$sna_id;
			echo "<img src=\"$urli\" />";
		}
	}	
}

