<?php   
 /* CAT:Labels */
require_once("../../config.php");
require_once("lib.php");
require_once("snalib.php");
$sid = optional_param('sid','', PARAM_INT);
$cm = get_coursemodule_from_id('sna', $sid);
$context = context_module::instance($cm->id);
if(has_capability('mod/sna:view', $context))
{
$id = optional_param('id','', PARAM_INT);
$type = optional_param('type','', PARAM_INT);
 /* pChart library inclusions */
require_once(dirname(__FILE__).'/pChart/class/pData.class.php');
require_once(dirname(__FILE__).'/pChart/class/pDraw.class.php');
require_once(dirname(__FILE__).'/pChart/class/pImage.class.php');
 /* Create and populate the pData object */
 $MyData = new pData();  
 if($type==3)
 {
	$connection_sum=sna_show_post_dots($id);
	$user_sum=sna_show_post_name_dots($id);
	$user_sums=array_values($user_sum);
	$chudu_shuzu=sna_outdegree_array($user_sums,$connection_sum);
	$rudu_shuzu=sna_arrays($user_sums,$connection_sum);
	$user_s=sna_show_post_name_dots($id);
 	}
 elseif($type==2)
 {
	$connection_sum=sna_show_course_dots($id);
	$user_sum=sna_show_course_name_dots($id);
	$user_sums=array_values($user_sum);
	$chudu_shuzu=sna_outdegree_array($user_sums,$connection_sum);
	$rudu_shuzu=sna_arrays($user_sums,$connection_sum);
	$user_s=sna_show_course_name_dots($id);
	 }
 elseif($type==1)
 {
	$connection_sum=sna_show_forum_dots($id);
	$user_sum=sna_show_forum_name_dots($id);
	$user_sums=array_values($user_sum);
	$chudu_shuzu=sna_outdegree_array($user_sums,$connection_sum);
	$rudu_shuzu=sna_arrays($user_sums,$connection_sum);
	$user_s=sna_show_forum_name_dots($id);
	 }
$chudu=array();
foreach($chudu_shuzu as $key=>$value)
{
	$chudu[$key]=count($value);
	}
$rudu=array();
foreach($rudu_shuzu as $key=>$value)
{
	$rudu[$key]=count($value);
	}
$sum_du=array();

foreach($user_s as $value)
{
	if(empty($rudu[$value]))
	{
		$rudu[$value]=0;
		}
	if(empty($chudu[$value]))
	{
		$chudu[$value]=0;
		}
	$sum_du[$value]=$rudu[$value]+$chudu[$value];
	}
	
$names=array_keys($sum_du);
$numbers=array_values($sum_du);
$username=array();
foreach($names as $id)
{
	$ftname=$DB->get_record('user', array('id'=>$id));
	$username[]=$ftname->lastname.$ftname->firstname;
}
$b=count($names);
$count_sy=2*($b-1);
$number=array();
for($i=0;$i<count($numbers);$i++) 
{
	$number[$i]=sprintf('%.3f',($numbers[$i]/$count_sy));
	}
  $MyData->addPoints($number,"Number");
  $MyData->setAxisName(0,"Point Centrality");
  $MyData->addPoints($username,"Browsers");
 $MyData->setSerieDescription("Browsers","Browsers");
 $MyData->setAbscissa("Browsers");

 /* Create the pChart object */
 $myPicture = new pImage(950,650,$MyData);
 $myPicture->drawGradientArea(0,0,950,650,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>100));
 $myPicture->drawGradientArea(0,0,950,650,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>20));
 $myPicture->setFontProperties(array("FontName"=>"pChart/fonts/MSYH.TTF","FontSize"=>6));

 /* Draw the chart scale */ 
 $myPicture->setGraphArea(100,30,930,630);
 $myPicture->drawScale(array("CycleBackground"=>TRUE,"DrawSubTicks"=>TRUE,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10,"Pos"=>SCALE_POS_TOPBOTTOM));

 /* Turn on shadow computing */ 
 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

 /* Create the per bar palette */
 $Palette = array("0"=>array("R"=>188,"G"=>224,"B"=>46,"Alpha"=>100),
                  "1"=>array("R"=>224,"G"=>100,"B"=>46,"Alpha"=>100),
                  "2"=>array("R"=>224,"G"=>214,"B"=>46,"Alpha"=>100),
                  "3"=>array("R"=>46,"G"=>151,"B"=>224,"Alpha"=>100),
                  "4"=>array("R"=>176,"G"=>46,"B"=>224,"Alpha"=>100),
                  "5"=>array("R"=>224,"G"=>46,"B"=>117,"Alpha"=>100),
                  "6"=>array("R"=>92,"G"=>224,"B"=>46,"Alpha"=>100),
                  "7"=>array("R"=>224,"G"=>176,"B"=>46,"Alpha"=>100));

 /* Draw the chart */ 
 $myPicture->drawBarChart(array("DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>TRUE,"Rounded"=>TRUE,"Surrounding"=>30,"OverrideColors"=>$Palette));

 /* Write the legend */ 
 $myPicture->drawLegend(20,20,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));


 /* Render the picture (choose the best way) */
 $myPicture->autoOutput("pChart/pictures/example.drawBarChart.vertical.png");
}
