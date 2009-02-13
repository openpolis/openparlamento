<ul id="content-tabs" class="float-container tools-container">
   <li class="current"><h2><?php echo link_to( $item_name, $sf_user->getAttribute('referer', '@homepage')) ?></h2></li>
</ul>
<div id="content" class="tabbed float-container">
  <div id="main">
    <div class="W100_100 float-left">
	<div class="float-container">
           <?php include_partial('page_tools', array('uriParams' => 'page=' . urlencode($page->getName()), 'canView' => $canView, 'canEdit' => $canEdit)) ?>
        </div>
        <?php include_partial('page_history', array('page' => $page, 'compare' => true, 'revision1' => $revision1, 'revision2' => $revision2, 'diff' => $diff, 'canView' => $canView, 'canEdit' => $canEdit)) ?>
     </div>
     <div class="clear-both"></div>
 </div> 	
</div>

<?php echo include_partial('breadcrumbs_slot', 
                           array('item_type' => $item_type, 
                                 'item_name' => $item_name, 
                                 'link_back' => $sf_user->getAttribute('referer', '@homepage'))); ?>
