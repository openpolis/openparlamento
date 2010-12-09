<?php echo use_helper('PagerNavigation'); ?>

<h5 class="subsection"><?php echo $pager->getNbResults() ?> interventi</h5>

<table class="disegni-decreti column-table">
  <thead>
    <tr> 
      <th scope="col">data:</th>
      <th scope="col">sede:</th>
      <th scope="col">atto:</th>  
      <th scope="col">parere utenti:</th>  
      <th scope="col">il tuo parere:</th>
    </tr>
  </thead>

  <tbody>
  <?php $tr_class = 'even' ?>			
    <?php foreach ($pager->getResults() as $intervento): ?>
      <?php $atto = $intervento->getOppAtto(); ?>
       <tr class="clickable <?php echo $tr_class; ?>">
       <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?> 
        <th scope="row">
          <p class="content-meta">
            <span class="date"><?php echo ($intervento->getData() ? $intervento->getData('d-m-Y') : '') ?></span>
          </p>
        </th>
        <td>
          <p>
            <?php echo $intervento->getOppSede()->getDenominazione() ?>
          </p>
        </td>
        <th scope="row">
         <p class="content-meta">
         <?php echo $atto->getOppTipoAtto()->getDescrizione().($atto->getRamo()=='C' ? ' alla Camera' : ' al Senato') ?>
         </p>
          <p>
            <?php echo link_to(Text::denominazioneAtto($atto, 'list'), 'atto/index?id='.$atto->getId()) ?>
            <?php echo link_to(image_tag('extlink.gif',
                                         array('title' => 'Vai all\'intervento sul sito '.($intervento->getOppSede()->getRamo() == 'C'?'della Camera':'del Senato'))) ,
                              (preg_match("#^http:#",$intervento->getUrl()) ? $intervento->getUrl() : sfConfig::get('app_url_sito_camera', 'http://nuovo.camera.it/').$intervento->getUrl()),
                              array('class' => 'external-url-container') ) ?>
          </p>
        </th>
        <td>
          <div class="user-stats-column">
            <?php include_component('deppVoting', 'votingDetailsSmall', array('object' => $intervento)) ?>
          </div>
        </td>
        <td>
          <div class="user-vote-column">
            <?php include_component('deppVoting', 'votingBlockSmall', array('object' => $intervento)) ?>            
          </div>
        </td>
      </tr>
    <?php endforeach; ?>
    <tr>
      <td align="center" colspan='5'>
        <?php echo pager_navigation($pager, '@parlamentare_interventi?id='.$parlamentare_id) ?>
      </td>
    </tr>

    <tr>
      <td align="center" colspan='5'>
        <?php echo format_number_choice('[0] nessun risultato|[1] 1 risultato|(1,+Inf] %1% risultati', array('%1%' => $pager->getNbResults()), $pager->getNbResults()) ?>
      </td>
    </tr>
  </tbody>
</table>

<div id="popupContent">
  <a href="#" id="popupContentClose">x</a>
  <h1>Preview e voto</h1>
  <iframe style="width: 100%; height: 88%" id="contentArea" src=""></iframe>
</div>
<div id="backgroundPopup"></div>

<!-- slider jQuery per gli atti e le notizie relative -->
<script type="text/javascript">
//<![CDATA[

jQuery.noConflict();
(function($) {
  $().ready(function(){

    var popupStatus = 0;
    
    //loading popup with jQuery magic!
    function loadPopup(page_url){
      //loads popup only if it is disabled
      if(popupStatus==0){
        $("#backgroundPopup").css({
          "opacity": "0.7"
        });
        $("#backgroundPopup").fadeIn("slow");
        $("#popupContent").fadeIn("slow");
        $("#contentArea").attr("src", page_url);
        popupStatus = 1;
      }
    }

    //disabling popup with jQuery magic!
    function disablePopup(){
      //disables popup only if it is enabled
      if(popupStatus==1){
        $("#backgroundPopup").fadeOut("slow");
        $("#popupContent").fadeOut("slow");
        popupStatus = 0;
      }
    }    

    //centering popup
    function centerPopup(){
      //request data for centering
      var windowWidth = document.documentElement.clientWidth;
      var windowHeight = document.documentElement.clientHeight;
      var popupHeight = $("#popupContent").height();
      var popupWidth = $("#popupContent").width();
      //centering
      $("#popupContent").css({
        "position": "fixed",
        "top": windowHeight/2-popupHeight/2,
        "left": windowWidth/2-popupWidth/2
      });
      //only need force for IE6

      $("#backgroundPopup").css({
        "height": windowHeight
      });

    }

    $('a.external-url-container').click(function(){
  		var page_url = $(this).attr('href');
  	  centerPopup();
  		loadPopup(page_url);
  		return false;
    });

    //Click out event!  
    $("#backgroundPopup").click(function(){  
      disablePopup();  
    });  
    
    $("#popupContentClose").click(function(){
      disablePopup();
      return false;
    });
    
    $(".clickable").click(function(){
      if($(this).css('background-color') != 'rgb(255, 238, 238)')
      {
        $(this).css({
          "background-color": "#ffeeee"
        });        
      } else {
        if($(this).attr('class') == 'clickable even')
          $(this).css('background-color', '#ffffff');
        else
          $(this).css('background-color', '#fafafa');
      }
    });

    //Press Escape event!  
    $(document).keypress(function(e){  
      if(e.keyCode==27 && popupStatus==1){  
        disablePopup();  
      }
    });

    
    // behavior per gestire richieste ajax al click su link
    function bind_voting_behavior(scope){
      $('a', scope).click(function(e){
        e.preventDefault();

        var table_row = $(this).parents('tr');
        var user_stats_col = table_row.find('.user-stats-column');
        var user_vote_col = table_row.find('.user-vote-column');
        var token = user_stats_col.find('div').attr('id');

        // send request
        $.get($(this).attr('href'), function(data) {
          user_vote_col.html(data);
          bind_voting_behavior(user_vote_col);
          user_stats_col.load("/deppVoting/votingDetails?type=small&token="+token);
        });
        
      });
    };
    
    // associazine del behavior ai link della colonna dei voti
    bind_voting_behavior($('.user-vote-column'));
      

    

  })
})(jQuery);

//]]>
</script>
