<?php
function sna_show_username($arrs)
{
	global $DB;
	global $CFG;
	$shu=0;
	echo("<table width='700' border='0' cellspacing='2' cellpadding='2'>
	<tr style='background-color:#84cbe0'>
    <td>username</td>
    <td>last login time</td>
	<td>last login time---now</td>
	<td>send message</td>
    </tr>");
	 foreach ($arrs as $id)
	  {	
		$userinfo=$DB->get_record("user",array("id"=>$id));
		$username=$userinfo->lastname.$userinfo->firstname;
		$datestring = userdate($userinfo->lastaccess);
		$lastaccess=html_writer::tag('dd', $datestring);
		$datestring1=format_time(time() - $userinfo->lastaccess);
		$last=html_writer::tag('dd', $datestring1);
		$url=$CFG->wwwroot.'/message/index.php?id='.$userinfo->id;
		if($shu%2==0)
		{
		echo(
  "<tr style='background-color:#a5d5e2'>
    <td>$username</td>
    <td>$lastaccess</td>
	<td>$last</td>
	<td><a href='$url'>send message</a></td>
  </tr>");
			}
		else
		{
	echo(
  "<tr style='background-color:#d2eaf1'>
    <td>$username</td>
    <td>$lastaccess</td>
	<td>$last</td>
	<td><a href='$url'>send message</a></td>
  </tr>");
			}
		$shu=$shu+1;	
	  }
	  echo("</table>");
	}


function sna_show_course_dots($course)
{
	global $DB;
	if($discussions=$DB->get_records("forum_discussions",array("course"=>$course)))
	{
	$arr=array();
	$user_num=array();
	foreach($discussions as $discussion)
	{	
		if($posts=$DB->get_records("forum_posts",array("discussion"=>$discussion->id)))
		{
		$test=array();
		foreach($posts as $row)
		{	
			$leslie=$row->parent;
			if($leslie!=0)
			{
				$post=$DB->get_record("forum_posts",array("id"=>$leslie));
				if(($row->userid)!=($post->userid))
				{
					unset($test);
					$arr[]=$post->userid;	
					$test[]=$post->userid;
					$test[]=$row->userid;	
					if(!sna_check($user_num,$test))
					{
						$user_num[]=$test;
						}		
				}
			}

		 }
	}
	}
  return $user_num;
	}
}

function sna_show_forum_dots($forumid)
{
	global $DB;
	if($discussions=$DB->get_records("forum_discussions",array("forum"=>$forumid)))
	{
	$arr=array();
	$user_num=array();
	foreach($discussions as $discussion)
	{	
		if($posts=$DB->get_records("forum_posts",array("discussion"=>$discussion->id)))
		{
		$test=array();
		foreach($posts as $row)
		{	
			$leslie=$row->parent;
			if($leslie!=0)
			{
				$post=$DB->get_record("forum_posts",array("id"=>$leslie));
				if(($row->userid)!=($post->userid))
				{
					unset($test);
					$arr[]=$post->userid;	
					$test[]=$post->userid;
					$test[]=$row->userid;	
					if(!sna_check($user_num,$test))
					{
						$user_num[]=$test;
						}		
				}
			}

		 }
	}
	}
  return $user_num;
	}
}

function sna_show_post_dots($post)
{
	global $DB;
	if($posts=$DB->get_records("forum_posts",array("discussion"=>$post)))
	{
	$user_num=array();
	$test=array();
	$arr=array();
	foreach($posts as $row)
	{	
		$leslie=$row->parent;
		if($leslie!=0)
		{
			$post=$DB->get_record("forum_posts",array("id"=>$leslie));
			if(($row->userid)!=($post->userid))
			{
				unset($test);
				$arr[]=$post->userid;	
				$test[]=$post->userid;
				$test[]=$row->userid;	
				if(!sna_check($user_num,$test))
				{
					$user_num[]=$test;
					}		
			}
		}

 	 }
	  return $user_num;
	}
}
function sna_check($arr,$arr1)
{
	foreach($arr as $value)
	{
		if($value[0]==$arr1[0]&&$value[1]==$arr1[1])
		{
			return true;
			}
		}
	}

function sna_show_course_name_dots($course)
{
	global $DB;
	$arr=array();
	if($forums=$DB->get_records("forum_discussions",array("course"=>$course)))
	{
	foreach($forums as $forum)
	{	
		if($posts=$DB->get_records("forum_posts",array("discussion"=>$forum->id)))
		{
			foreach($posts as $row)
			{	
				$arr[]=$row->userid;
			 }
		}
	}
	}
    $arrs = array_unique($arr);
	return $arrs;
}
function sna_show_forum_name_dots($forumid)
{
	global $DB;
	$arr=array();
	if($forums=$DB->get_records("forum_discussions",array("forum"=>$forumid)))
	{
	foreach($forums as $forum)
	{	
		if($posts=$DB->get_records("forum_posts",array("discussion"=>$forum->id)))
		{
			foreach($posts as $row)
			{	
				$arr[]=$row->userid;
			 }
		}
	}
	}
    $arrs = array_unique($arr);
	return $arrs;
}
function sna_show_post_name_dots($post)
{
	global $DB;
	if($posts=$DB->get_records("forum_posts",array("discussion"=>$post)))
	{
	foreach($posts as $row)
	{	
		$arr[]=$row->userid;
	}
    $arrs = array_unique($arr);
	return $arrs;
	}
}
function sna_arrays($user_sum,$connection_sum)
{
	for($i=0;$i<count($user_sum);$i++)
		{
			for($j=0;$j<count($connection_sum);$j++)
			{
				$conn=$connection_sum[$j];
				if($user_sum[$i]==$conn[0])
				{				
					$key = $conn[1]; 
					$sum[]=$key;
					}
				}
				
				if(!empty($sum))
				{
					$sy_name=$user_sum[$i];
					$sums[$sy_name]=$sum;
					}
				
				unset($sum);
		}
		
		return $sums;
	}
function sna_outdegree_array($user_sum,$connection_sum)
{
	for($i=0;$i<count($user_sum);$i++)
		{
			for($j=0;$j<count($connection_sum);$j++)
			{
				$conn=$connection_sum[$j];
				if($user_sum[$i]==$conn[1]&&$conn[0]!=0)
				{				
					$key = $conn[0]; 
					$sum[]=$key;
					}
				}
				
				if(!empty($sum))
				{
					$sy_name=$user_sum[$i];
					$sums[$sy_name]=$sum;
					}
				
				unset($sum);
		}
		
		return $sums;
	}

function sna_show_course_dot($course)
{
	global $DB;
	if($discussions=$DB->get_records("forum_discussions",array("course"=>$course)))
	{
	$arr=array();
	$user_num=array();
	foreach($discussions as $discussion)
	{	
		if($posts=$DB->get_records("forum_posts",array("discussion"=>$discussion->id)))
		{
		$test=array();
		foreach($posts as $row)
		{	
			$leslie=$row->parent;
			if($leslie!=0)
			{
				$post=$DB->get_record("forum_posts",array("id"=>$leslie));
				if(($row->userid)!=($post->userid))
				{
					unset($test);
					$arr[]=$post->userid;	
					$test[]=$post->userid;
					$test[]=$row->userid;	
					if(!sna_check($user_num,$test))
					{
						$user_num[]=$test;
						}		
				}
			}
			else
			{
				unset($test);
				$arr[]=0;
				$test[]=0;
				$test[]=$row->userid;
				if(!sna_check($user_num,$test))
				{
					$user_num[]=$test;
					}	
			}	
		 }
	}
	}
  return $user_num;
	}
}

function sna_show_forum_dot($forumid)
{
	global $DB;
	if($discussions=$DB->get_records("forum_discussions",array("forum"=>$forumid)))
	{
	$arr=array();
	$user_num=array();
	foreach($discussions as $discussion)
	{	
		if($posts=$DB->get_records("forum_posts",array("discussion"=>$discussion->id)))
		{
		$test=array();
		foreach($posts as $row)
		{	
			$leslie=$row->parent;
			if($leslie!=0)
			{
				$post=$DB->get_record("forum_posts",array("id"=>$leslie));
				if(($row->userid)!=($post->userid))
				{
					unset($test);
					$arr[]=$post->userid;	
					$test[]=$post->userid;
					$test[]=$row->userid;	
					if(!sna_check($user_num,$test))
					{
						$user_num[]=$test;
						}		
				}
			}
			else
			{
				unset($test);
				$arr[]=0;
				$test[]=0;
				$test[]=$row->userid;
				if(!sna_check($user_num,$test))
				{
					$user_num[]=$test;
					}	
			}	
		 }
	}
	}
  return $user_num;
	}
}

function sna_show_post_dot($post)
{
	global $DB;
	if($posts=$DB->get_records("forum_posts",array("discussion"=>$post)))
	{
	$user_num=array();
	$test=array();
	$arr=array();
	foreach($posts as $row)
	{	
		$leslie=$row->parent;
		if($leslie!=0)
		{
			$post=$DB->get_record("forum_posts",array("id"=>$leslie));
			if(($row->userid)!=($post->userid))
			{
				unset($test);
				$arr[]=$post->userid;	
				$test[]=$post->userid;
				$test[]=$row->userid;	
				if(!sna_check($user_num,$test))
				{
					$user_num[]=$test;
					}		
			}
		}
		else
		{
			unset($test);
			$arr[]=0;
			$test[]=0;
			$test[]=$row->userid;
			if(!sna_check($user_num,$test))
			{
				$user_num[]=$test;
				}	
		}	
 	 }
	  return $user_num;
	}
}

function sna_find_id($username,$arr)
{
	for($i=0;$i<count($arr);$i++)
	{
		if($arr[$i][0]==$username)
		{
			return $arr[$i][1];
			}
		}
		return null;
	}
function sna_show_dot_name($arr)
{
	global $DB;
	$arrs=array();
	foreach($arr as $values)
	{
		$names=array();
		foreach($values as $value)
		{
			if(!empty($value))
			{
				$userinfo=$DB->get_record("user",array("id"=>$value));
				$username=$userinfo->lastname.$userinfo->firstname;
				$names[]=$username;
				}
			else
			{
				$names[]=null;
				}
			}
		$arrs[]=$names;
		
		}
	return $arrs;
	}

