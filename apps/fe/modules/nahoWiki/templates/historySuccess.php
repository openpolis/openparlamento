<ul id="content-tabs" class="float-container tools-container">
   <li class="current"><h2><?php echo link_to( $item_name, $sf_user->getAttribute('referer', '@homepage')) ?></h2></li>
</ul>

<div class="row">
	<div class="twelvecol">
		
		
		 <?php include_partial('page_tools', array('uriParams' => $uriParams, 'canView' => $canView, 'canEdit' => $canEdit)) ?>
        </div>
        <?php include_partial('page_history', array('page' => $page, 'compare' => count($page->getRevisions()) > 1, 'canView' => $canView, 'canEdit' => $canEdit)) ?>
		
	</div>
</div>

<?php echo include_partial('breadcrumbs_slot', 
                           array('item_type' => $item_type, 
                                 'item_name' => $item_name, 
                                 'item'      => $item,
                                 'link_back' => $sf_user->getAttribute('referer', '@homepage'))); ?>
