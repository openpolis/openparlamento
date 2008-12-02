<p class="last-update">data di ultimo aggiornamento: <strong>25-11-2008</strong></p>
<?php echo form_tag('#', array("id"=>"search-ddl")) ?>
  <h6>nei deputati</h6>
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