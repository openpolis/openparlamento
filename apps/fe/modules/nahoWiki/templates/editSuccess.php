<ul id="content-tabs" class="float-container tools-container">
   <li class="current"><h2><?php echo link_to('atto', $sf_user->getAttribute('referer', '@homepage')) ?></h2></li>
</ul>
<div id="content" class="tabbed float-container">
  <div id="main">
    <div class="W100_100 float-left">
	<div class="float-container">
           <?php include_partial('page_tools', array('uriParams' => $uriParams, 'canView' => $canView, 'canEdit' => $canEdit)) ?>
        </div>
        <?php include_partial('page_edit', array('page' => $page, 'revision' => $revision, 'uriParams' => $uriParams, 'userName' => $userName, 'canView' => $canView, 'canEdit' => $canEdit)) ?>
     </div>
     <div class="clear-both"></div>
 </div> 	
</div>
