<?php echo form_tag('#', array("id"=>"disegni-decreti-filter")) ?>
  <fieldset class="labels">
    <label for="topic">argomento:</label>
    <label for="type">tipologia:</label>
  </fieldset>
  <p>filtra per</p>
  <fieldset>
    <select id="topic" name="topic">
      <option value="0" selected="selected">tutti</option>
      <option value="1">1. lorem ipsum lorem ipsum</option>
      <option value="2">2. lorem ipsum</option>
      <option value="3">3. lorem ipsum lorem ipsum</option>
      <optgroup label="economia">
      <option value="4">4. lorem ipsum lorem ipsum</option>
      <option value="5">5. lorem ipsum lorem ipsum</option>
      <option value="6">6. lorem ipsum lorem ipsum</option>
      <option value="7">7. lorem ipsum lorem ipsum</option>
      <option value="8">8. lorem ipsum lorem ipsum</option>				
    </optgroup>

    <optgroup label="ambiente">				
      <option value="9">9. lorem ipsum lorem ipsum</option>
      <option value="10">10. lorem ipsum lorem ipsum</option>
      <option value="11">11. lorem ipsum lorem ipsum</option>
    </optgroup>
    <optgroup label="finanza">								
      <option value="12">12. lorem ipsum lorem ipsum</option>
      <option value="13">13. lorem ipsum lorem ipsum</option>
      <option value="14">14. lorem ipsum lorem ipsum</option>
      <option value="15">15. lorem ipsum lorem ipsum</option>
      <option value="16">16. lorem ipsum lorem ipsum</option>
    </optgroup>
  </select>
  <select id="type" name="type">
    <option value="0" selected="selected">tutte</option>
    <option value="1">attuativo di legge delega</option>
    <option value="2">attuativo di direttive comunitarie</option>
    <option value="3">attuativo di statuti speciali</option>
  </select>	
  <?php echo submit_image_tag('btn-applica.png', array('id' => 'disegni-decreti-filter-apply', 'alt' => 'applica', 'style' => 'display: none;', 'name' => 'disegni-decreti-filter-apply' )) ?>
  </fieldset>
</form>