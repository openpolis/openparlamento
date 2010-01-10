<?php use_helper('DeppNews') ?>
 
<?php if (count($news)>0): ?>
  <div class="section-box">
    <?php if (isset($rss_link)): ?>
      <?php echo link_to(image_tag('ico-rss.png', array('alt' => 'RSS')), $rss_link, array('class' => 'section-box-rss')) ?>      
    <?php endif ?>
    <h6>News - <?php echo $title ?></h6>
    <div class="news-disegni-decreti float-container"> 
        <table class="table-news">
        <?php foreach ($news as $n): ?>
          <?php
          // fetch del modello e dell'oggetto che ha generato la notizia
          $generator_model = $n->getGeneratorModel();
          if ($n->getGeneratorPrimaryKeys())
          {
            $pks = array_values(unserialize($n->getGeneratorPrimaryKeys()));
            $generator = call_user_func_array(array($generator_model.'Peer', 'retrieveByPK'), $pks);          
          } else {
            $pks = array();
            $generator = null;
          }
          ?>
          
          <tr style='border-top:1px solid #DFE0E0;'>
            <td><?php echo news_date($n->getDate('d/m/Y')) ?></td>
          </tr>
          <tr>
            <td>
              <?php echo news_text($n, $generator_model, $pks, $generator, array('context' => $context)) ?>
            </td>
          </tr>
        <?php endforeach ?>
        </table>
      <?php echo link_to("<strong>vedi tutta la cronologia</strong>", $all_news_url, array('class'=>"see-all tools-container")) ?>
    </div>
  </div>  
<?php endif ?>
