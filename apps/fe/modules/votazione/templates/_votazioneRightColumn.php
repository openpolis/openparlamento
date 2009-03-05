<p class="last-update">data di ultimo aggiornamento: <strong>25-11-2008</strong></p>
<?php 
  echo include_partial('sfSolr/votazioni_controls', 
                      array('query' => $query,
                            'title' => 'nelle votazioni'));
?>

<div class="section-box">
  <?php echo link_to(image_tag('ico-rss.png', array('alt' => 'RSS')), '/', array('class' => 'section-box-rss')) ?>
  <h6>News - Votazioni</h6>
  <div class="news-disegni-decreti float-container"> 
    <ul>
      <li>
        <strong>23-10-2008</strong>
        <p><a href="#">C.1386-B</a> <?php echo image_tag('ico-new.png', array('alt' => 'nuovo')) ?> <br />
        interventi in commissione cultura della <a href="#" class="tools-container">Camera</a></p>
      </li>
      <li>
        <strong>18-10-2008</strong>
        <p><a href="#">C.1386-B</a><br />
        aggiunto nuovo co-firmatario</p>
      </li>
      <li>
        <strong>17-10-2008</strong>
        <p><a href="#">C.1386-B</a><br />
        aggiunto nuovo co-firmatario</p>
      </li>
      <li>
        <strong>09-10-2008</strong>
        <p><a href="#">C.1386-B</a><br />
        assegnato in commissione</p>
      </li>
      <li>
        <strong>09-10-2008</strong>
        <p><a href="#">C.1386-B</a><br />
        presentato</p>
      </li>
    </ul>
    <a href="#" class="see-all tools-container">vedi tutta la cronologia</a>
  </div>
</div>