<?php 
/**
* @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
* @license		GNU General Public License version 3 or later; see LICENSE.txt
*/

// No direct access to this file
defined('_JEXEC') or die;

// Explicitly declare the type of content
header("Content-type: text/javascript; charset=UTF-8");

// DO NOT ADD COMMENTS TO THE CODE -  IT WILL PREVENT COMPRESSION
?>

(function($){ 
	$(window).load(function() {
	
	    $("<?php echo $css_prefix ?>.newslist").pajinate({
			item_container_id : ".latestnews-items",
			nav_panel_id : ".items_pagination",
			items_per_page: <?php echo $visibleatonce ?>,
			num_page_links_to_display: <?php echo $num_links ?>,
			wrap_around: true,
			<?php if (!$arrows) : ?>
				show_prev_next: false,
			<?php else : ?>	
				<?php if (empty($prev_label)) : ?>
					<?php if (!$horizontal && $pagination_position == 'around') : ?>
						nav_label_prev: "<span class='SYWicon-arrow-up2'></span>",
					<?php else : ?>
						nav_label_prev: "<span class='SYWicon-arrow-left2'></span>",
					<?php endif; ?>
				<?php else : ?>	
					nav_label_prev: "<span><?php echo $prev_label ?></span>",
				<?php endif; ?>
				<?php if (empty($next_label)) : ?>
					<?php if (!$horizontal && $pagination_position == 'around') : ?>
						nav_label_next: "<span class='SYWicon-arrow-down2'></span>"
					<?php else : ?>
						nav_label_next: "<span class='SYWicon-arrow-right2'></span>"
					<?php endif; ?>
				<?php else : ?>	
					nav_label_next: "<span><?php echo $next_label ?></span>"
				<?php endif; ?>
			<?php endif; ?>		
		});
		
		<?php if ($pagination_style): ?>
    		<?php if ($bootstrap_version == 3 || $bootstrap_version == 4) : ?>
        		var pagination = $("<?php echo $css_prefix ?> .items_pagination ul");
        		pagination.addClass("pagination");
        		<?php if ($pagination_size) : ?>
                	pagination.addClass("<?php echo $pagination_size ?>");
            	<?php endif; ?>
        		<?php if ($bootstrap_version == 4) : ?>
                	<?php if ($pagination_align) : ?>
                        pagination.addClass("<?php echo $pagination_align ?>");
                    <?php endif; ?>
        			pagination.find("li").addClass("page-item");
        			pagination.find("a").addClass("page-link");
        		<?php endif; ?>
    		<?php endif; ?>
    	<?php endif; ?>	

    	setTimeout(() => $("<?php echo $css_prefix ?>.newslist").fadeTo('slow', 1), 500);
	}); 
})(jQuery); 
