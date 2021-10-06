<p class="last-update">data di ultimo aggiornamento: <strong>25-11-2008</strong></p>			
<?php echo form_tag('#', array("id"=>"search-ddl")) ?>
  <h6>negli atti non legislativi</h6>
    <fieldset id="search-ddl-fbox">
      <input type="text" id="search-ddl-field" class="blur" />
      <?php echo submit_image_tag('btn-cerca-small.png', array('id' => 'search-ddl-go', 'alt' => 'cerca' )) ?>      
	  <div class="search-ddl-type-container">
        <div id="search-ddl-type" style="display: none;">
          <input name="search-ddl-type" id="search-ddl-0" type="radio" value="0" checked="checked" />
          <label for="search-ddl-0" class="focus">tutto</label><br />
          <input name="search-ddl-type" id="search-ddl-1" type="radio" value="1" />
          <label for="search-ddl-1">codice DDL</label><br />
          <input name="search-ddl-type" id="search-ddl-2" type="radio" value="2" />
          <label for="search-ddl-2">titolo DDL</label><br />
          <input name="search-ddl-type" id="search-ddl-3" type="radio" value="3" />
          <label for="search-ddl-3">descrizione</label><br />
          <input name="search-ddl-type" id="search-ddl-4" type="radio" value="4" />
          <label for="search-ddl-4">teseo</label><br />
          <input name="search-ddl-type" id="search-ddl-5" type="radio" value="5" />
          <label for="search-ddl-5">cofirmatari e relatori</label><br />					
        </div>
      </div>						
    </fieldset>
  </form>

  <div class="section-box">
    <?php echo link_to(image_tag('ico-rss.png', array('alt' => 'RSS', 'width' => '32', 'height' => '13')), '/', array('class' => 'section-box-rss')) ?>
    <h6>News - Atti non legislativi</h6>
    <div class="news-disegni-decreti float-container"> 
    <ul>
      <li>
        <strong>23-10-2008</strong>
        <p><a href="#">C.1386-B</a> <?php echo image_tag('ico-new.png', array('alt' => 'nuovo', 'width' => '18', 'height' => '10')) ?><br />
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
