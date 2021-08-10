<?php

/**
* @version 3.2.6
* @package Joomla 3.x
* @subpackage DT Register
* @copyright Copyright (C) 2006 DTH Development
* @copyright contact dthdev@dthdevelopment.com
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

 global $Itemid,$month_arr,$now,$xhtml_url,$googlekey,$amp,$show_event_image,$eventListOrder,$spots_column,$hide_full_event,$showlocationfilter,$locationdistanceunit,$eventListOrder;

 $config = $this->getModel('config');

 $categoryTable = $this->getModel('category')->getTable();
 
 $locationTable = $this->getModel('location')->table;

 $eventTable = $this->getModel('event')->table;

 $document = JFactory::getDocument();

 $document->addScript( JUri::root(true).'/components/com_dtregister/assets/js/dt_jquery.js');

 $document->addScript( JUri::root(true).'/components/com_dtregister/assets/js/jquery.lightbox.js');
 $request = JFactory::getApplication()->input->request->getArray();
  if(!JModuleHelper::isEnabled('s5_box')){
     $document->addStyleSheet(JUri::root(true).'/components/com_dtregister/assets/css/jquery.lightbox.css');
  }

  
 $document->addStyleSheet(JUri::root(true).'/components/com_dtregister/assets/css/font-awesome/css/font-awesome.min.css');
 

 $document->addStyleSheet(JUri::root(true).'/components/com_dtregister/assets/css/main.css');


 if($config->getGlobal('googlekey','')!==""){

   //$document->addScript( "http://maps.google.com/maps?file=api".$amp."v=2.x".$amp."key=".$googlekey);

 }
 
 //$document->addScript("http://maps.googleapis.com/maps/api/js?sensor=false&language=ja");

 $limit = trim( JFactory::getApplication()->input->getInt('limit',$config->getGlobal('event_list_number','')) );

$where = array();

$limitstart = trim( JFactory::getApplication()->input->getInt('limitstart', 0 ) );

$month = JFactory::getApplication()->input->get('month','');

$year = JFactory::getApplication()->input->get('year','');//date('Y',$now->toUnix(true))

jimport('joomla.html.pagination');

$category = JFactory::getApplication()->input->get('category',"");
$location = JFactory::getApplication()->input->get('location',"");
$moderator = JFactory::getApplication()->input->get('moderator',"");
$cartcontinue = JFactory::getApplication()->input->get('cart','');
$advance_search = JFactory::getApplication()->input->get('advance_search',"");
$search = htmlentities(JFactory::getApplication()->input->getString('search'));

$zip = JFactory::getApplication()->input->get('zip',"");
$distance = JFactory::getApplication()->input->get('distance',"");
$task = JFactory::getApplication()->input->get('task',''); 
$categories = array();
if($task == "category" ){

	$cats = array();

	for($i=1;$i<=12;$i++){

	   $cat_id = JFactory::getApplication()->input->getInt('list'.$i,'');

	   if( $cat_id > 0){
		  $categories[] = $cat_id;
		  $cats[] = $config->getDBO()->quote($config->getDBO()->escape( $cat_id));

	   }

	}
    $cat_id = JFactory::getApplication()->input->getInt('category','');
	
	if($cat_id > 0){
		$categories[] = $cat_id;
		$cats[] = $config->getDBO()->quote($config->getDBO()->escape( $cat_id));
	}
   

	if(isset($request['cat']) && $request['cat'] && $request['cat'] != 'all') {
		foreach($request['cat'] as $cat_id) {
			if($cat_id > 0) {
				$categories[] = $cat_id;
				$cats[] = $config->getDBO()->quote($config->getDBO()->escape( $cat_id));
			}
			
		}
	}
	
	if(count($cats)>0){
   
	  // $where[] = " ( c.categoryId in( ".implode(",",$cats)." ) or c.parent_id in (".implode(",",$cats).") )";
	   
	}

 }

if (isset($location) && $location != "") {
	$locations[] = $location;
	// dtpr($locations);
	$where[] = "  b.location_id in( ".implode(",",$locations)." ) ";
}
$this->show_distance_col = false;

if($zip !== "") {
	
	if($distance != "") {
		$loc = $this->lnglat($zip);
		if($loc['success']) {
			$where['distance'] = array('lat'=>$loc['location']->lat,'lng'=>$loc['location']->lng,'distance'=>$distance);
			//$where['distance'] = "(GLENGTH( LINESTRING(( POINTFROMWKB( POINT( ".$loc['location']->lat." , ".$loc['location']->lng." ))), ( POINTFROMWKB( POINT( l.lat, l.lng ) ))))) * 100 < '$distance'";
			//$where[] = " l.zip = '$zip'";
			//dtpr($where);
			$this->show_distance_col = true;
		} else {
		
			$where[] = " l.zip = '$zip'";
		
		}
		
	} else {
		$where[] = " l.zip = '$zip'";
	}
}
$search = $config->getDBO()->escape( trim( strtolower( $search ) ) );

if ($search){

   $where[] = "(b.event_describe LIKE '%{$search}%' OR b.title LIKE '%{$search}%' OR c.categoryName LIKE '%{$search}%'  OR l.name LIKE '%{$search}%' OR b.dtstart LIKE '%{$search}%' OR b.dtend LIKE '%{$search}%' OR l.zip like '%{$search}%'  OR l.city like '%{$search}%'  OR l.state like '%{$search}%'  OR l.country like '%{$search}%') ";
	$searchs[] = $search;
	//$where[] = "  b.title LIKE  '%".implode(",",$searchs)."%' ";
	//$where[] = "(b.title LIKE '%{$search}%') ";
	if($moderator != "") {
		
		$where[] = " (u.id = $moderator) ";
		
	}
	if($category != "") {
		$categories[] = $category;
		//$where[] = " (c.categoryId = $category) ";
		
	}
	if($location != "") {
		
		$where[] = " ( l.id = $location ) ";
		
	}

}else if($search && $advance_search != "") {
/*	
title
date
category name
location name
location city, state, country
description
moderator name / username
*/
	
	$where[] = "(b.event_describe LIKE '%{$search}%' OR b.title LIKE '%{$search}%' OR c.categoryName LIKE '%{$search}%'  OR l.name LIKE '%{$search}%' OR b.dtstart LIKE '%{$search}%' OR b.dtend LIKE '%{$search}%' OR u.name LIKE '%{$search}%' OR u.username LIKE '%{$search}%' OR l.city LIKE '%{$search}%' OR l.state LIKE '%{$search}%' OR l.country LIKE '%{$search}%') ";
	
	if($moderator != "") {
		
		$where[] = " (u.id = $moderator) ";
		
	}
	
	if($category != "") {
		$categories[] = $category;
		//$where[] = " (c.categoryId = $category) ";
		
	}
	
	if($location != "") {
		
		$where[] = " ( l.id = $location ) ";
		
	}
} else if($search == "" && $advance_search != "") {
	
	if($moderator != "") {
		
		$where[] = " (u.id = $moderator) ";
		
	}
	
	if($category != "") {
		$categories[] = $category;
		//$where[] = " (c.categoryId = $category) ";
		
	}
	
	if($location != "") {
		
		$where[] = " ( l.id = $location ) ";
		
	}
	
} else {
 if($moderator != "") {
		
		$where[] = " (u.id = $moderator) ";
		
	}

}

if($cartcontinue == 'continue' && DT_Session::get('register.User') && count(array_filter(DT_Session::get('register.User')))){
 // dtpr($_SESSION);
 $users = array_values(array_filter(DT_Session::get('register.User')));
  $eventId = $users[0]['eventId'];
  $evtTcart = $this->getModel('event')->table;
  $evtTcart->load($eventId);
  $where[] = " b.payment_id = ".$evtTcart->payment_id;
 // dtprd($_SESSION);
    	
}

if(!$config->getGlobal('show_past_event',0)){

   $where[] = " (b.dtend >= '". $now->format('%Y-%m-%d') ."' or b.dtend = '0000-00-00' or b.dtend Is Null) ";

}

$mainframe = JFactory::getApplication();
$tzoffest = new DateTimeZone ($mainframe->getCfg('offset'));
if($month !="" && $year !="" ){
   
   if(isset($request['day'])) {
   		$start_date = new JDate($year."-".$month."-".$request['day']);
   } else {
   		$start_date = new JDate($year."-".$month."-01");
   }

$start_date->setTimezone($tzoffest);

$end_month = $month + 1;

if($end_month > 12){

      $end_month = "01";

	  $end_year = $year + 1;

   }else{

      $end_year = $year;

   }
   
   if(isset($request['day'])) { 
        $end_date = new JDate($year."-".$month."-".$request['day']);
   } else {
   		$end_date = new JDate($end_year."-".$end_month."-01");
   }

$end_date->setTimezone($tzoffest);
if(isset($request['day'])) { 

  $where[] = "( b.dtstart <= '".($start_date->format('Y-m-d'))."'   and b.dtend >=  '".($end_date->format('Y-m-d'))."' )";
} else {
   $where[] = " b.dtstart >= '".($start_date->format('Y-m-d'))."' and b.dtstart <  '".($end_date->format('Y-m-d'))."' ";
}

}

if($month =="" && $year !="" ){

   $start_date = $year."-01-01";

   $end_year = $year + 1;

   $end_date = $end_year."-01-01";

   $where[] = " b.dtstart >= '".($start_date)."' and b.dtstart <  '".($end_date)."' ";

}


$my = JFactory::getUser();

if(!$my->id){  // not logged in view only public event

}
$user = JFactory::getUser();
$access_levels = $user->getAuthorisedViewLevels();

$rows2 = $locationTable->find(' 1=1 ');
$arrLocation = array();
foreach ($rows2 as $rows) {
	$arrLocation[$rows->id] = $rows->name;
}
	$having = array();
if($hide_full_event){
   $having[] = "if(b.max_registrations > 0 and( b.max_registrations - sum(a.memtot))<1 , 0 , 1 )";
   $where['having'] = $having;
}
$ordering = "b.ordering ASC";
$groupby = " group by b.slabId ";
if($eventListOrder == 3) {
   $ordering = " c.lft asc, b.ordering ASC ";
   $groupby = "  group by c.categoryId , b.slabId ";
}

$where['group'] = $groupby;
        $rows = $eventTable->findallevents($categories,array_filter($where)," $ordering ",$limitstart,$limit);
		dtpr($rows);
		$cnt = $eventTable->getLastCount($eventTable->count_sql); unset($eventTable->count_sql);
		dtpr($cnt);
		$pageNav = new DtPagination( $cnt, $limitstart, $limit );
        dtpr($pageNav);
		$link="index.php?option=".DTR_COM_COMPONENT."&Itemid=$Itemid";
  // $this->assign('pageNav',$pageNav);
// dtpr($rows);

?>
<div class="dtregister-wrap dtregister-events-list">

	<script type="text/javascript">

	  //<![CDATA[

		DTjQuery(function(){ 

	  window.status='test';

	  DTjQuery(".event-image .colorbox").colorbox();
	  DTjQuery(".event-meta .colorbox").colorbox({width:550, height:550,iframe:true});

	  DTjQuery().bind('cbox_complete', function(){

		 // initialize();

	      //setTimeout($.fn.colorbox.next, 1500);

	     });

	});

	  //]]>

	</script>

	<form action="<?php echo  JRoute::_("index.php?option=".DTR_COM_COMPONENT."&Itemid=".$Itemid, $xhtml_url ); ?>" method="post" name="frmcart">

	<h2><?php echo JText::_( 'DT_EVENT_REGISTRATION' );?></h2>

	<div class="event_message"><?php echo JText::_( 'DT_EVENT_LIST_INSTRUCTIONS' );?></div>

	<div class="event-filters btn-toolbar">

	  <?php if($config->getGlobal('event_search_show',0)==1){ ?>

	  <label for="event-search" ><?php echo JText::_( 'DT_SEARCH' ); ?>:</label> 

	  <input id="event-search" type="text" name="search" value="<?php echo htmlspecialchars(JFactory::getApplication()->input->get('search','','HTML')); ?>" class="inputbox dtreg" />

	  <input class="dth-btn dth-btn-primary" type="submit" value="<?php echo JText::_( 'DT_SEARCH_GO' );?>" />

	  <?php } ?>

	  <div class="pull-right">
	  <?php 

		if($config->getGlobal('month_filter_show',0)) { // month filter flag 

	  $month_opts=DtHtml::options($month_arr,JText::_( 'DT_SELECT_MONTH' ));

	  echo JHtml::_('select.genericlist', $month_opts,"month",'onchange="submit()" class="dtreg"',"value","text",$month); 

	    $year_opts = array();

	  $year_opts[] = JHtml::_('select.option',"",JText::_( 'DT_SELECT_YEAR' ));

	    for($i=2020; $i > 2012; $i-- ){

	    $year_opts[]=JHtml::_('select.option',$i,$i);

	  }

	  echo JHtml::_('select.genericlist', $year_opts,"year",'onchange="submit()" class="dtreg"',"value","text",$year); 

	  ?>
	 

	     <?php } else {

	     $month = "";

	   } ?> 

	       <?php if($config->getGlobal('event_filter_show',0)==1){?>

	      <?php

		$options = DtHtml::options( $categoryTable->optionslist_filtered(),JText::_( 'DT_CATEGORY_VIEW' ));
		echo JHtml::_('select.genericlist', $options,"category",'onchange="submit()" class="dtreg"',"value","text",JFactory::getApplication()->input->get('category','')); ?>

	      <?php } ?>

	       <?php if($config->getGlobal('event_location_show',0)==1){?>

	      <?php

		 $options = DtHtml::options( $locationTable->optionslist(),JText::_( 'DT_LOCATION_VIEW' ));

		 echo JHtml::_('select.genericlist', $options,"location",'onchange="submit()" class="dtreg"',"value","text",JFactory::getApplication()->input->get('location','')); ?>

	       <?php } ?>
	 
	    <?php if($showlocationfilter) {?>

	       <?php echo JText::_('DT_ZIPCODE');?>
		 
		 <input size="5" type="text" name="zip" value="<?php echo JFactory::getApplication()->input->get('zip',''); ?>" class="inputbox dtreg" />

	       <?php echo JText::_('DT_WITHIN')."&nbsp;";

	       $options = DtHtml::options( array(5=>5,10=>10,20=>20,30=>30,50=>50,100=>100,200=>200),JText::_( 'DT_DISTANCE' ));

		 echo JHtml::_('select.genericlist', $options,"distance",'onchange="submit()" class="dtreg"',"value","text",JFactory::getApplication()->input->get('distance',''));

		 if($locationdistanceunit == 'km') {
		  	
			 echo JText::_('DT_KILOMETERS');
			 
		 } else {
		 	
			 echo JText::_('DT_MILES');		 				
		 }
		 ?>
	        
	    <?php } ?>
	  	</div>

	</div>

	<div class="eventlists equal-height row">
	<?php
	  $page_links = $pageNav->getPagesLinks($link);
	?>
	<?php

	if($rows){
	   
	//Get the number of registrants

	//End the number of registrants

	$link="index.php?option=com_dtregister&Itemid=$Itemid";

	$prevCat=NULL;

	$currCat=NULL;

	// Display an event on each row

	  $k = 0;

	$prevCat = NUll;

	$parent = $categoryTable;
	  
	for($i=0,$n=count($rows);$i<$n;$i++){
		if($k == 0){
			$bgRow='eventListRow1';
		} else {
			$bgRow='eventListRow2';}

		$row=$rows[$i];
		
	      if($row->max_registrations > 0 && $hide_full_event == 1 && ($row->max_registrations - $row->registered) < 1) {
			
			continue;
		}
		
	      $currCat = $row->categoryId;

		if(($currCat!=$prevCat || $currCat=="") && $eventListOrder == 3){

				$cat_str = "";
				foreach( $parent->getPath($row->categoryId) as $cat) {
					if(strtolower($cat->categoryName) ==  'root'){
					   continue;
					}
					if($cat_str != "") {
					     $cat_str .= " >> ";
					 }
					$cat_str .= $cat->categoryName;
				}
				if($cat_str != "")
				echo '<div class="categoryRow">'.$cat_str .'</div>';

		}

	  $this->assign('row',$row);

		$this->assign('bgRow',$bgRow);

		$this->assign('prevCat',$prevCat);

		$this->assign('currCat',$currCat);

		echo $this->loadTemplate('row');

		$prevCat = $currCat;

		$k = 1-$k;

	} ?>

	<?php 

	  $link="index.php?option=".DTR_COM_COMPONENT."&Itemid=$Itemid";
	    if(strlen(trim($page_links))) {
		  
	  		echo '<div class="pagination">'.$pageNav->getPagesLinks($link)."</div>";
			
	  }

	}else if (!$rows && $search){

		echo "<div>".JText::_( 'DT_NO_SEARCH_RESULTS' )."</div>";

	} else {

		// no events to list

		echo "<div>".JText::_( 'DT_NO_EVENTS' )."</div>";

	} // END -> if($rows)

	?>

	 </div> 

	 <input type="hidden" name="option" value="<?php echo DTR_COM_COMPONENT; ?>" />
	 <input type="hidden" name="controller" value="event" />
	 <input type="hidden" name="task" value="category" />
	 <input type="hidden" name="limitstart" value="<?php echo $pageNav->limitstart; ?>" />
	  <?php
	 if($advance_search !="") {
	 ?>
	 	<input type="hidden" name="advance_search" value="yes" />  
	  
	 <?php
	  }
	 ?>
	 
	  <?php
	 if($moderator !="") {
	 ?>
	 	<input type="hidden" name="moderator" value="<?php echo $moderator ?>" />
	 <?php
	  }
	 ?>
	 <?php
	 if($config->getGlobal('event_filter_show',0)!=1 && $advance_search !="" && $category !=""){
	 ?>	   
	 
	   <input type="hidden" name="category" value="<?php echo $category ?>" />
	 <?php  
	 }
	 ?>

	 <?php
	 if($config->getGlobal('event_location_show',0)!=1 && $advance_search !="" && $location !=""){
	 ?>	   
	 
	   <input type="hidden" name="location" value="<?php echo $location ?>" />
	 <?php  
	 }
	 ?>
	</form>
	<script type="text/javascript">

	DTjQuery(function() {
		
		DTjQuery('#simple_search').click(function(){
			reset_adv_search();
			
			document.frmcart.submit();
		});
		
	});
	function reset_adv_search() {
		
		document.frmcart.limitstart.value = '0';
		if(typeof document.frmcart.moderator != 'undefined')
		document.frmcart.moderator.value = "";
		if(typeof document.frmcart.advance_search != 'undefined')
		document.frmcart.advance_search.value = "";
		
	}
	</script>
</div>