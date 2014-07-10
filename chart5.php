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
require_once(dirname(__FILE__).'/pChart/class/pData.class.php');
require_once(dirname(__FILE__).'/pChart/class/pDraw.class.php');
require_once(dirname(__FILE__).'/pChart/class/pImage.class.php');
require_once(dirname(__FILE__).'/pChart/class/pPie.class.php');

 /* Create and populate the pData object */
 $MyData = new pData();  
 if($type==1)
{
		$a=count(sna_show_forum_dots($id));
		$b=count(sna_show_forum_name_dots($id));
		$c=$a/($b*($b-1));
		$d=1-$c;
		$MyData->addPoints(array($c,$d),"ScoreA");
		$MyData->setSerieDescription("ScoreA","Application A");
		$forum_name=$DB->get_record("forum",array("id"=>$id));
		$MyData->addPoints(array($forum_name->name,null),"Labels");
} 
 else if($type==2)
{
		$a=count(sna_show_course_dots($id));
		$b=count(sna_show_course_name_dots($id));
		$c=$a/($b*($b-1));
		$d=1-$c;
		$MyData->addPoints(array($c,$d),"ScoreA");
		$MyData->setSerieDescription("ScoreA","Application A");
		$forum_name=$DB->get_record("course",array("id"=>$id));
		$MyData->addPoints(array($forum_name->fullname,null),"Labels");
} 
 else if($type==3)
{
		$a=count(sna_show_post_dots($id));
		$b=count(sna_show_post_name_dots($id));
		$c=$a/($b*($b-1));
		$d=1-$c;
		$MyData->addPoints(array($c,$d),"ScoreA");
		$MyData->setSerieDescription("ScoreA","Application A");
		$forum_name=$DB->get_record("forum_discussions",array("id"=>$id));
		$MyData->addPoints(array($forum_name->name,null),"Labels");
} 

 

 /* Define the absissa serie */

 $MyData->setAbscissa("Labels");

 /* Create the pChart object */
 $myPicture = new pImage(400,230,$MyData,TRUE);

 /* Draw a solid background */
 $Settings = array("R"=>240, "G"=>240, "B"=>240, "Dash"=>1, "DashR"=>193, "DashG"=>172, "DashB"=>237);
 $myPicture->drawFilledRectangle(0,0,400,230,$Settings);

 /* Draw a gradient overlay */
 $Settings = array("StartR"=>240, "StartG"=>240, "StartB"=>231, "EndR"=>111, "EndG"=>213, "EndB"=>138, "Alpha"=>50);
 $myPicture->drawGradientArea(0,0,400,230,DIRECTION_VERTICAL,$Settings);
 $myPicture->drawGradientArea(0,0,400,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>100));

 /* Add a border to the picture */
 $myPicture->drawRectangle(0,0,399,229,array("R"=>0,"G"=>0,"B"=>0));

 /* Write the picture title */ 
 $myPicture->setFontProperties(array("FontName"=>"pChart/fonts/MSYH.TTF","FontSize"=>8));
 $myPicture->drawText(10,13,"Network Density",array("R"=>255,"G"=>255,"B"=>255));

 /* Set the default font properties */ 
 $myPicture->setFontProperties(array("FontName"=>"pChart/fonts/MSYH.TTF","FontSize"=>10,"R"=>80,"G"=>80,"B"=>80));

 /* Create the pPie object */ 
 $PieChart = new pPie($myPicture,$MyData);

 /* Define the slice color */
 $PieChart->setSliceColor(0,array("R"=>143,"G"=>197,"B"=>0));
 $PieChart->setSliceColor(1,array("R"=>230,"G"=>230,"B"=>230));





 /* Enable shadow computing */ 
 $myPicture->setShadow(TRUE,array("X"=>3,"Y"=>3,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

 /* Draw a splitted pie chart */ 
 $PieChart->draw3DPie(200,125,array("WriteValues"=>TRUE,"DataGapAngle"=>10,"DataGapRadius"=>6,"Border"=>TRUE));



 /* Write the legend box */ 
 $myPicture->setFontProperties(array("FontName"=>"pChart/fonts/MSYH.TTF","FontSize"=>6,"R"=>255,"G"=>255,"B"=>255));
 $PieChart->drawPieLegend(100,8,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));

 /* Render the picture (choose the best way) */
 $myPicture->autoOutput("pChart/pictures/example.draw3DPie.png");
}

