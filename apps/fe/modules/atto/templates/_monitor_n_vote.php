<?php use_helper('deppVotingYesNo', 'deppPrioritising', 'deppLaunching', 'deppOmnibus'); ?>

<div id="monitor-n-vote">

  <h6>monitora questo atto</h6>
  <p class="tools-container"><a class="ico-help" href="#">che significa monitorare</a></p>
          <div style="display: none;" class="help-box float-container">
              <div class="inner float-container">

                  <a class="ico-close" href="#">chiudi</a><h5>che significa monitorare ?</h5>
                  <p>Registrandoti e entrando nel sito puoi attivare il monitoraggio per atti, parlamentari e argomenti. Da quel momento nella tua pagina personale e nella tua email riceverai tutti gli aggiornamenti riferiti agli elementi che stai monitorando.<br />
                  </p>
              </div>
          </div>
  <!-- component per la gestione del monitoring di questo atto -->
  <?php echo include_component('monitoring', 'manageItem', 
                               array('item' => $atto, 'item_type' => 'atto')); ?>
  <hr class="dotted" />            

  <h6>sei favorevole o contrario?</h6>

  <!-- blocco voting -->
  <?php include_component('deppVoting', 'votingBlock', array('object' => $atto)) ?>
  <hr class="dotted" />
  
   <!-- blocco lanci home x admin, priorita atti e flag omnibus -->
  <?php if ($sf_user->isAuthenticated() && $sf_user->hasCredential('amministratore')): ?>
    <div>
        <h6 class="slider-button">lanci in home page</h6>
        <?php echo include_partial('deppLaunching/launcher', array('object' => $atto, 'namespace' => 'home')); ?>    
    </div>
    <hr class="dotted" />

    <div>
        <h6 class="slider-button">in evidenza per CittadinoLex</h6>
        <?php echo include_partial('deppLaunching/launcher', array('object' => $atto, 'namespace' => 'lex')); ?>    
    </div>
    
    
    <?php 
    //use_javascript('/js/jquery-1.4.3.min.js');
    use_javascript('/js/jquery-ui-1.8.16.sortable.min.js'); ?>

    <script type="text/javascript">
        /* when the DOM is ready */
        var alreadyLoaded = 0;
        /* jQuery UI used for drag and dropping admin elements */
        jQuery(document).ready(function() {
            if ( alreadyLoaded == 1 )
                return;
            alreadyLoaded = 1;
            jQuery('h6.slider-button').click(function(){
                jQuery(this).parent().find('.vote-administration').slideToggle();
            });

            jQuery('.vote-administration')
                .hide()
                .sortable({
                    placeholder: 'vote-administration-highlight',
                    update: function(event , ui)
                    {
                        var diff = ui.item.index() - ui.item.data('old-index');
                        var action;
                        if ( diff > 0 ) { action = jQuery('.movedown-vote', ui.item ); }
                        else { action = jQuery('.moveup-vote', ui.item ); diff = -1 * diff; }
                        jQuery.ajax({
                            type: 'get',
                            url: action.attr('href') +'/paths/'+ diff,
                            complete: function() { ui.item.effect('highlight', {}, 3000); }
                        });
                    },
                    start: function( e, ui ) {
                        ui.item.data('old-index', ui.item.index() );
                    }
                })
                .disableSelection()
                .find('a')
                .click(function(event){
                    event.preventDefault();
                    var action = jQuery(this);
                    var container = action.parent().parent();
                    switch ( action.attr('class') )
                    {
                        case 'moveup-vote' : container.prev().before(container);
                            break;
                        case 'movedown-vote' : container.next().after(container);
                            break;
                        case 'remove-vote' : container.remove();
                            break;
                    }
                    jQuery.ajax({
                        type: 'get',
                        url: action.attr('href'),
                        complete: function() { container.effect('highlight', {}, 3000); }
                    });
                });
        });

    </script>
    
    <hr class="dotted" />

    <h6>assegna priorit&agrave; a questo atto</h6>
    <?php echo depp_prioritising_block($atto,
        $sf_flash->has('depp_prioritising_message')?$sf_flash->get('depp_prioritising_message'):'') ?>

    <h6>&egrave; atto <em>omnibus</em>?</h6>
    <?php echo depp_omnibus_block($atto,
        $sf_flash->has('depp_omnibus_message')?$sf_flash->get('depp_omnibus_message'):'') ?>
    
  <?php endif ?>
</div>
