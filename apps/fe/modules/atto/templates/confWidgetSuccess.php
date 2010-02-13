<script src="/js/widget/panel_generator.js" type="text/javascript"></script>
<div class="tabbed float-container" id="content">
  <div id="main">
    <div class="W73_100 float-left">
      
      <dl class="tool_form bill_status">

<p>Ecco il widget che hai selezionato. Se vuoi puoi configurare i colori, poi semplicemente copia e incolla il codice HTML, che trovi in fondo alla pagina, nel tuo blog o sito.
Le informazioni contenute verranno sempre aggiornate </p>
            <dt><label><?php echo $atto->getOppTipoAtto()->getDescrizione()?>:</label></dt>
            <dd style="font-size:1em;padding-top:3px;display:block;"><?php echo link_to(($atto->getTipoAttoId()==1 ? $atto->getRamo().".".$atto->getNumfase()." ".$atto->getTitolo() : Text::denominazioneAtto($atto, 'list')),'/singolo_atto/'.$id) ?></dd>
            
        <input id="panel_bill_id" name="panel[bill_id]" type="hidden" value="<?php echo $id ?>" />

        <dt><label for="post_info_url">La tua posizione sull'atto:</label></dt>   
        <dd><select id="panel_pos_select" name="panel[pos_select]" onChange="updateBillStatusFields('panel_pos');">
        <option value="0" <?php echo ($pos==0 ? 'selected="selected"' :'') ?>>non voglio visualizzare la mia posizione</option>  
        <option value="1" <?php echo ($pos==1 ? 'selected="selected"' :'') ?>>sono favorevole</option>
        <option value="2" <?php echo ($pos==2 ? 'selected="selected"' :'') ?>>sono contrario</option></select>
        <input id="panel_pos" name="panel[pos]" size="6" type="hidden" value="<?php echo $pos ?>" /></dd>
         
        <dt><label for="post_info_url">Colore dello sfondo:</label></dt>
      <dd><select id="panel_bgcolor_select" name="panel[bgcolor_select]" onChange="updateBillStatusFields('panel_bgcolor');"><option value="cccccc">Grigio</option>
      <option value="0000ff">Blu</option>
      <option value="ff0000">Rosso</option>
      <option value="008000">Verde</option>
      <option value="3167cb">Blu chiaro</option>
      <option value="ffff00">Giallo</option>
      <option value="000000">Nero</option>
      <option value="ffffff" selected="selected">Bianco</option></select><br>
          <div class="form_note">Oppure, decidi tu (codice hex a sei cifre):
      <input id="panel_bgcolor" maxlength="6" name="panel[bgcolor]" size="6" type="text" value="ffffff" /></div></dd>

      <dt><label for="post_info_url">Colore del bordo:</label></dt>
      <dd><select id="panel_bordercolor_select" name="panel[bordercolor_select]" onChange="updateBillStatusFields('panel_bordercolor');"><option value="cccccc">Grigio</option>
      <option value="0000ff">Blu</option>
      <option value="ff0000">Rosso</option>
      <option value="008000">Verde</option>
      <option value="3167cb">Blu chiaro</option>
      <option value="ffff00">Giallo</option>
      <option value="000000">Nero</option>
      <option value="ffffff">Bianco</option></select><br>
          <div class="form_note">Oppure, decidi tu (codice hex a sei cifre):
      <input id="panel_bordercolor" maxlength="6" name="panel[bordercolor]" size="6" type="text" value="999999" /></div></dd>

      <dt><label for="post_info_url">Colore del testo:</label></dt>
      <dd><select id="panel_textcolor_select" name="panel[textcolor_select]" onChange="updateBillStatusFields('panel_textcolor');"><option value="cccccc">Grigio</option>
      <option value="0000ff">Blu</option>
      <option value="ff0000">Rosso</option>
      <option value="008000">Verde</option>
      <option value="3167cb">Blu chiaro</option>
      <option value="ffff00">Giallo</option>
      <option value="000000">Nero</option>
      <option value="ffffff">Bianco</option></select><br>
          <div class="form_note">Oppure, decidi tu (codice hex a sei cifre):
      <input id="panel_textcolor" maxlength="6" name="panel[textcolor]" size="6" type="text" value="333333" /></div></dd>

        <input name="commit" onClick="updateBillStatusFields();" type="submit" value="Update Panel Preview &gt;&gt; " />

        <input id="panel_bill_id" name="panel[bill_id]" type="hidden" />
        <input id="panel_path" name="panel[path]" type="hidden" value="/widget_atto" />
        <input id="panel_hostname" name="panel[hostname]" type="hidden" value="http://op_openparlamento.openpolis.it/" />

        </dl>  
        <div id="preview_container">

        <div id="preview_bill_status_preview">
        Ecco come si presenta il widget:<br>
        <iframe id="bill_status_panel" name="oc_bill_status_frame" width="250" scrolling="no" frameborder="0" style="border: 1px solid #999;" allowtransparency="true" hspace="0" vspace="0" marginheight="0" marginwidth="0" src="/widget_atto?bill_id=<?php echo $id ?>&bg_color=ffffff&textcolor=333333&pos=0"></iframe>
        </div>

        <div id="preview_bill_status_code">
        Copia e incolla questo codice nella tua pagina web:<br>

        <textarea cols="68" id="panel_code" name="panel[code]" rows="20"></textarea>

        </div>

        </div>
        <!-- The following image forces the fields to update on the initial load of the page -->
          <img alt="Blank" class="noborder" height="0" onLoad="updateBillStatusFields();" src="/images/blank.gif?1264486214" width="0" />
        
    </div>
  </div> 
</div>  
	 
			




  

 