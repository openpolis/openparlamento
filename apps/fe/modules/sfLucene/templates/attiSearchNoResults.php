<?php include_partial('atto/tabs', array('current' => $type)) ?>

<div id="content" class="tabbed float-container">

  <div id="main">
    <div class="W25_100 float-right">
      <?php 
        echo include_partial('sfLucene/specialized_controls', 
                            array('query' => $query,
                                  'type'  => $type,
                                  'title' => $title));
      ?>

  	</div>

    <div class="W73_100 float-left">


      <div class="tabbed float-container" id="content">
      	<div id="main">
      	  <div class="W100_100 float-left" style="margin-bottom: 20px">

            <h2></h2>
            <p style="height: 300px; margin-top: 50px; margin-left: auto; margin-right: auto; font-size: 14px; font-weight: bold">La tua ricerca del termine <em><?php echo $query ?></em>  <?php echo $title ?> non ha prodotto alcun risultato</p>

          </div>
        </div>
      </div>

    </div>
  </div>

</div>



