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
require_once(dirname(__FILE__).'/pChart/class/pSpring.class.php');

 /* Create the pChart object */
 $myPicture = new pImage(700,700);

 /* Draw the background */
 $Settings = array("R"=>250, "G"=>250, "B"=>250, "Dash"=>1, "DashR"=>250, "DashG"=>253, "DashB"=>207);
 $myPicture->drawFilledRectangle(0,0,700,700,$Settings);

 /* Overlay with a gradient */
 $Settings = array("StartR"=>215, "StartG"=>215, "StartB"=>215, "EndR"=>245, "EndG"=>245, "EndB"=>245, "Alpha"=>150);
 $myPicture->drawGradientArea(0,0,700,700,DIRECTION_VERTICAL,$Settings);
 $myPicture->drawGradientArea(0,0,700,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>100,"EndG"=>100,"EndB"=>100,"Alpha"=>80));

 /* Add a border to the picture */
 $myPicture->drawRectangle(0,0,699,699,array("R"=>0,"G"=>0,"B"=>0));

 /* Write the picture title */ 
 $myPicture->setFontProperties(array("FontName"=>"pChart/fonts/MSYH.TTF","FontSize"=>6));
 $myPicture->drawText(10,13,"The Sociogram",array("R"=>255,"G"=>255,"B"=>255));

 /* Set the graph area boundaries*/ 
 $myPicture->setGraphArea(60,30,540,570);

 /* Set the default font properties */ 
 $myPicture->setFontProperties(array("FontName"=>"pChart/fonts/MSYH.TTF","FontSize"=>9,"R"=>80,"G"=>80,"B"=>80));

 /* Enable shadow computing */ 
 $myPicture->setShadow(TRUE,array("X"=>2,"Y"=>2,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

 /* Create the pSpring object */ 
 $SpringChart = new pSpring();

 /* Create some nodes */ 
 

 if($type==3)
 {
	$conns1=array();
	$conns1=sna_show_post_dot($id);
	}
 elseif($type==2)
 {
	$conns1=array();
	$conns1=sna_show_course_dot($id);	
	}
 elseif($type==1)
 {
	$conns1=array();
	$conns1=sna_show_forum_dot($id);	
	}
	$conns=sna_show_dot_name($conns1);
	$dots=array();
	$dots_conn=array();
	for($i=0;$i<count($conns);$i++)
	{
	
		$name_id=array();
		$names=$conns[$i][1];
		if($i==0)
		{
			$SpringChart->addNode($i,array("Shape"=>NODE_SHAPE_SQUARE,"Name"=>"$names"));	
			
			}
		else
		{
			if(!in_array($conns[$i][1],$dots))
			{
				if($conns[$i][0]==null)
				{
					$SpringChart->addNode($i,array("Shape"=>NODE_SHAPE_SQUARE,"Name"=>"$names"));
					
					}
				else
				{
					$dot_id=sna_find_id($conns[$i][0],$dots_conn);
					$SpringChart->addNode($i,array("Shape"=>NODE_SHAPE_SQUARE,"Name"=>"$names","Connections"=>"$dot_id"));
				
					}	
				}
			else
			{
		
			$dot_id0=sna_find_id($conns[$i][0],$dots_conn);
			$dot_id1=sna_find_id($conns[$i][1],$dots_conn);

			$SpringChart->addNode($dot_id1,array("Shape"=>NODE_SHAPE_SQUARE,"Connections"=>"$dot_id0","Name"=>"$names"));	
			$SpringChart->addConn($dot_id1,array("Connections"=>"$dot_id0"));
				}
				
		}
		if(!in_array($conns[$i][1],$dots))
		{
			$dots[]=$conns[$i][1];
			$name_id[]=$conns[$i][1];
			$name_id[]=$i;
			$dots_conn[]=$name_id;
		}

	}
	
  /* Set the nodes color */ 
 $SpringChart->setNodesColor(0,array("R"=>215,"G"=>163,"B"=>121,"BorderR"=>166,"BorderG"=>115,"BorderB"=>74));
 $SpringChart->setNodesColor(array(1,2),array("R"=>150,"G"=>215,"B"=>121,"Surrounding"=>-30));
 $SpringChart->setNodesColor(array(3,4,5),array("R"=>216,"G"=>166,"B"=>14,"Surrounding"=>-30));
 $SpringChart->setNodesColor(array(6,7,8),array("R"=>179,"G"=>121,"B"=>215,"Surrounding"=>-30));

 /* Set the link properties */ 
 $SpringChart->linkProperties(0,1,array("R"=>255,"G"=>0,"B"=>0,"Ticks"=>2));
 $SpringChart->linkProperties(0,2,array("R"=>255,"G"=>0,"B"=>0,"Ticks"=>2));

 /* Draw the spring chart */ 
 $Result = $SpringChart->drawSpring($myPicture);

 /* Output the statistics */ 
 // print_r($Result);

 /* Render the picture (choose the best way) */
 $myPicture->autoOutput("pChart/pictures/example.spring.relations.png");

}
