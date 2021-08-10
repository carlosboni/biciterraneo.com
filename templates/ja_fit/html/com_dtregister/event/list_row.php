<?php

/**
* @version 3.2.5
* @package Joomla 3.x
* @subpackage DT Register
* @copyright Copyright (C) 2006 DTH Development
* @copyright contact dthdev@dthdevelopment.com
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

global $Itemid,$xhtml_url,$now,$event_title_link,$button_color,$googlekey,$amp,$show_event_image,$registrant_list,$event_image_link,$spots_column;
 
$eventTable = $this->getModel('event')->table;
$user = Jfactory::getUser();

$categoryTable = $this->getModel('category')->getTable();

$locationTable = $this->getModel('location')->table;

$config = $this->getModel('config');

$row = $this->row;

$bgRow = $this->bgRow;

$class = 'class="btn"';

$eventTable->load($row->slabId);

$eventTable->formatTimeproperty($row->dtstarttime);
$eventTable->formatTimeproperty($row->dtendtime);

$j=3;
if($config->getGlobal('price_column')){$j++;}
if($config->getGlobal('capacity_column')){$j++;}
if($config->getGlobal('registered_column')){$j++;}

$color = $config->getGlobal('button_color');

       $task = $eventTable->getTask($row);

		$article = $eventTable->getArticle($row->article_id);

		$article_ItemId = $eventTable->getArticleItemid($article);

        $eventTable->overrideGlobal($row->slabId); 

		 if($config->getGlobal('event_title_link') == "jevent"){
            $jevent_view_id = $eventTable->getJeventdetailId($row->eventId);

        	$jevent_href = JRoute::_("index.php?option=com_jevents&task=icalrepeat.detail&evid=".$jevent_view_id."&Itemid=".DTreg::getcomItemId('com_jevents'),$xhtml_url);
            $event_title_href = $jevent_href;

		 } elseif($config->getGlobal('event_title_link') == "article"){
			if ( isset($article->id)) { // isset($article_ItemId) &&
				
				$event_title_href = JRoute::_('index.php?option=com_content&view=article&id='.$article->id.':'.$article->alias.'&catid='.$article->catid.'&Itemid='.$article_ItemId.'&lang=en',$xhtml_url);
				$article->slug = $article->alias ? ($article->id . ':' . $article->alias) : $article->id;
				$article->catslug = isset($article->category_alias) &&  $article->category_alias  ? ($article->catid . ':' . $article->category_alias) : $article->catid;
				
		// TODO: Change based on shownoauth
		        $event_title_href = JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catslug));
				
			}else{
				$event_title_href = DTreg::register_href($row,$task);
			}
                 } elseif($config->getGlobal('event_title_link') == "dtevent"){
                     
                     $event_title_href = JRoute::_("index.php?option=com_dtregister&controller=event&task=detail&eventId=".$row->slabId."&Itemid=".$Itemid,$xhtml_url);
                     
		 } else {

			$event_title_href = DTreg::register_href($row,$task);

		 }
jimport('joomla.filesystem.file');
		?>

		<div class="col col-sm-6"> <!-- Start Col -->
		<div <?php echo 'class="'.$bgRow.' eventlist-row"'; ?> >
		<div class="event-detail"> <!-- Event Wrap -->
          <?php if($show_event_image){?>
         	<div class="event-image image-wrap">
             <?php 
						if($row->imagepath !=""){
							if($event_image_link == "zoom_image") {
								//JPATH_ROOT
								$file_path = JPATH_ROOT.'/images/dtregister/eventpics/'.$row->imagepath;
								
								if(JFile::exists($file_path)) {
								  $href = JUri::base( true ).'/images/dtregister/eventpics/'.$row->imagepath;
								  $file_path = 'images/dtregister/eventpics/'.$row->imagepath; 
								} else {
								   $href = JUri::base( true ).'/'.$row->imagepath;
								   $file_path = $row->imagepath;
								}
								$file_path = urlencode($file_path );
								$pop_class = 'class="colorbox" ';
							} else {
								//JPATH_ROOT
								$file_path = JPATH_ROOT.'/images/dtregister/eventpics/'.$row->imagepath;
								
								if(JFile::exists($file_path)) {
								  //$href = JUri::base( true ).'/images/dtregister/eventpics/'.$row->imagepath;
								  $file_path = 'images/dtregister/eventpics/'.$row->imagepath; 
								} else {
								   //$href = JUri::base( true ).'/'.$row->imagepath;
								   $file_path = $row->imagepath;
								}
								$file_path  = urlencode($file_path );
								$href =DTreg::register_href($row,$task); // $event_title_href;
								$pop_class = '';
							}
							$file_path = str_replace('=', '_', base64_encode($file_path));
						echo '<a href="'.$href.'" '.$pop_class.' ><img src="'.JRoute::_('index.php?option=com_dtregister&controller=file&task=thumb&w='.$config->getGlobal('event_thumb_width',100).'&h='.$config->getGlobal('event_thumb_height',100).'&filename='.$file_path ,$xhtml_url).'" border="0" alt=" " /></a>'; 
						}else{
						  echo "&nbsp;";	
						}
						?>

						<!-- Override Category -->
						<div class="category">
							<?php echo $this->loadTemplate('category'); ?>
						</div>
         </div>
      <?php }?>
         <div class="event-content">
         
        <?php if(((strtotime($row->dtend." ".$row->dtendtime) > $now->toUnix(true) || $row->dtend=="" || $row->dtend=="0000-00-00" ) && $row->future_event=='n')  
		           || $config->getGlobal('event_title_link') == "jevent" || (isset($article->id) && $config->getGlobal('event_title_link') == "article")){ ; ?> 

		  	<h3 class="event-title"><a href="<?php echo $event_title_href;?>" title="<?php echo $row->title;?>"><?php echo $row->title;?></a>

					<?php }else { ?>

				<h3 class="event-title"><?php echo $row->title;?></h3>

          <?php } ?>
        </h3>

         <?php if($config->getGlobal('event_date_show')){ echo '<div class="event-time">'.$eventTable->displaydatecolumn().'</div>'; } ?>

        <div class="event-meta">
         <?php 

           if($row->location_id !="" && $row->location_id > 0 && $config->getGlobal('showlocation',0)){

		      $locationTable->load($row->location_id);

			  if($locationTable->name !=""){

		   echo '<div class="location">'.JText::_('DT_LOCATION'); ?>: <a class="colorbox" href="<?php echo JRoute::_("index.php?option=com_dtregister&controller=location&task=show&id=".$row->location_id."&tmpl=component",$xhtml_url,false) ?>"><?php echo stripslashes($locationTable->name);?></a></div>

         <?php if($config->getGlobal('linktogoogle')==1){ ?>

         <?php } } } echo '<div class="moderator">'.$this->loadTemplate('moderator').'</div>'; ?>

		 	</div>

		 	<?php if($row->event_describe_set) { 
				  $Tagparser = new DT_Tagparser();
				  $Tagparser->event_only = true ;
				  $Tagparser->set_event($eventTable);
				  $row->event_describe = $Tagparser->parsetags($row->event_describe);
				  
				?>
		            
				<div class="event-desc">
					<?php echo stripslashes($eventTable->get_short_desc('short')); ?>
					
					<?php if ( ($config->getGlobal('capacity_column')) || ($config->getGlobal('registered_column')) || ($spots_column) ) { ?>

			    <footer class="event-footer">
			        <?php 
			         if ($config->getGlobal('capacity_column')) {
			                ?>

			            <span class="event-max-registrations">

			                <?php
			                if ($row->max_registrations > 0) {

			                    echo JText::_( 'DT_EVENT_MAX_REGISTRATION' ).': '.$row->max_registrations;
			                } else {

			                    echo JText::_( 'DT_EVENT_MAX_REGISTRATION' ).': '.JText::_( 'DT_UNLIMITED' );
			                }
			                ?>

			            </span>

			            <?php
			        }
			        ?>

			            <?php if ($config->getGlobal('registered_column')) { ?>

			            <span class="event-registered">

			                <?php echo $row->registered.' '.JText::_( 'DT_REGISTERED' ); ?>

			            </span>

			            <?php } ?>

			            <?php if ($spots_column) { ?>
			            <span class="event-max-registrations">
			                <?php
			                if ($row->max_registrations > 0) {
			                    echo JText::_( 'DT_SPOTS' ).': '.$eventTable->get_spots($row);
			                } else {
			                    echo JText::_( 'DT_SPOTS' ).': '.JText::_( 'DT_UNLIMITED' );
			                }
			                ?>
			            </span>
			        <?php } ?>
			    </footer>
			    <?php } ?>
				</div>

			<?php } ?>
			<div class="event-footer">
<?php
$br = false;

$start_brace = "";

$end_brace = "";

if ( $row->detail_link_show == 1) {

    $mosConfig_live_site = JUri::base(true);
    if(is_numeric($row->article_id) && $row->article_id > 0 ){
    $event_title_href = JRoute::_('index.php?option=com_content&view=article&id=' . $article->id . ':' . $article->alias . '&catid=' . $article->catid . '&Itemid=' . $article_ItemId . '&lang=en', $xhtml_url);
        $article->slug = $article->alias ? ($article->id . ':' . $article->alias) : $article->id;
        $article->catslug = isset($article->category_alias) && $article->category_alias ? ($article->catid . ':' . $article->category_alias) : $article->catid;

        // TODO: Change based on shownoauth
        $detail_href = JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catslug));
    }else{
        $detail_href = JRoute::_("index.php?option=com_dtregister&controller=event&task=detail&eventId=" . $row->slabId . "&Itemid=" . $Itemid, $xhtml_url);
    }
    if ($config->getGlobal('front_link_type')) {

        // old button code
        //$title = '<img src="'.JUri::root(true).'/components/com_dtregister/assets/images/'.$button_color.'/view_details_62x14.png" class="event_button" alt="'.JText::_('DT_VIEW_DETAILS').'" />';

        $title = '<span>' . JText::_('DT_VIEW_DETAILS') . '</span>';

        $class = 'class="dth-btn dth-btn-default"';

        $start_brace = '';

        $end_brace = '';
    } else {

        $start_brace = '[';

        $end_brace = ']';

        $title = JText::_('DT_VIEW_DETAILS');

        $class = 'class="dth-btn dth-btn-default"';
         $start_brace = '';

        $end_brace = '';
    }

    
    // TODO: Change based on shownoauth
    if ($config->getGlobal('event_detail_link', 'dtevent') == "dtevent") {
        $href = JRoute::_("index.php?option=com_dtregister&controller=event&task=detail&eventId=" . $row->slabId . "&Itemid=" . $Itemid, $xhtml_url);
    } else {
        $href = $detail_href;
    }

    echo $start_brace . '<a ' . $class . ' href="' . $href . '">' . $title . '</a>' . $end_brace;
}

if ($row->show_registrant == 1 && in_array($registrant_list, $user->getAuthorisedViewLevels())) {

    if ($config->getGlobal("front_link_type", 0) == 1) {

        $title = '<span>' . JText::_('DT_VIEW_REGISTRANTS') . '</span>';

        $class = 'class="dth-btn dth-btn-primary"';

        $start_brace = '';

        $end_brace = '';
    } else {

        $start_brace = '[';

        $end_brace = ']';

        $title = JText::_('DT_VIEW_REGISTRANTS');

        $class = 'class="dth-btn dth-btn-primary"';
         $start_brace = '';

        $end_brace = '';
    }

    $br = true;

    echo $start_brace . '<a ' . $class . ' href="' . JRoute::_('index.php?option=com_dtregister&eventId=' . $row->slabId . '&task=registrant&controller=event&Itemid=' . $Itemid, $xhtml_url) . '">' . $title . '</a>' . $end_brace;
}

if ($config->getGlobal('show_registration_button', 0) == 1 && (strtotime($row->dtend . " " . $row->dtendtime) > $now->toUnix(true) || $row->dtend == "" || $row->dtend == "0000-00-00" ) && $row->future_event == 'n') {

    $br = false;

    if ($task === 'cut_off') {
        $class = 'class="dth-btn dth-btn-danger"';
    } else {
        $class = 'class="dth-btn dth-btn-primary"';
    }


    echo $start_brace . DTreg::register_link_small($row, $task, $class, $color, $config->getGlobal('front_link_type')) . $end_brace;
}
?>

        </div>

	<?php if($config->getGlobal('price_column')){?>

				<div class="event-price">

				<?php

						if($eventTable->getIndividualRate($row) > 0){  

						   $price = $eventTable->getIndividualRate($row);

                           echo DTreg::displayRate($price,$config->getGlobal('currency_code','USD'));
						   global $show_price_tax;
						   if($show_price_tax && $eventTable->tax_enable){
							     $price += ($price*$eventTable->tax_amount)/100;
							     echo " (".JText::_("DT_WITHOUT_TAX").")"."<br />" . DTreg::displayRate($price,$config->getGlobal('currency_code','USD'))." (".JText::_("DT_WITH_TAX").")";
						  }

						}else{

						   echo JText::_( 'DT_FREE' );

						}

					?>

				</div>

			<?php }

			if($config->getGlobal('capacity_column')){

			?>

				<div class="event-max-registrations hide">

				<?php

				if($row->max_registrations>0){

					echo $row->max_registrations;

				} else {

					// echo JText::_( 'DT_UNLIMITED' );

				}

				?>

				</div>

			<?php

			}

			?>

			<?php if($config->getGlobal('registered_column')){?>

				<div class="event-registered">

				<?php echo $row->registered;?>

				</div>

			<?php } ?>
            <?php
             if($spots_column){ ?>
			 	<div class="event-max-registrations hide">
                <?php
				if($row->max_registrations > 0) {
					echo $eventTable->get_spots($row);
				} else {
					// echo JText::_( 'DT_UNLIMITED' );
				}
				?>
                </div>
			<?php }
			?>
            
            <?php
			global $locationdistanceunit;
			if($this->show_distance_col) {
            ?>
             <div class="event-howfar"><?php echo round($row->distance,2)."&nbsp;"; echo ($locationdistanceunit=="km")?JText::_('DT_KILOMETERS'):JText::_('DT_MILES'); ?></div>
            <?php
			}
			?>

			</div>

		</div>
	</div> <!-- // Event Wrap -->
	</div> <!-- // End Col -->
		<?php 

     	$eventTable->resumeGlobal();	

?>