<div style="color: #626262; font-family: Arial, Helvetica, sans-serif; font-size: 11px; text-align: center; margin-top: 20px">
  
    <?php if ($msg_type == 'alerts'): ?>
      <p>Per rimuovere gli avvisi, vai nella sezione <i>i miei avvisi</i> delle <a href="http://<?php echo $site_url?>/monitoring">tue pagine personali</a> (effettuare il login al sito inserendo la email e la password)</p>    
    <?php else: ?>
      <p>Per modificare le impostazioni del monitoraggio e consultare le tue notizie online, <br/>
        vai nelle <a href="http://<?php echo $site_url?>/monitoring">tue pagine personali</a> (effettuare il login al sito inserendo la email e la password)</p>      
    <?php endif ?>

    <?php if ($user->isAdhoc()): ?>
      <p><strong>politicaldesk</strong> è un servizio di <a href="http://www.depp.it">depp srl</a> - Informazione e assistenza: servizi@depp.it, Tel. +39.0683608392</p>      
    <?php endif ?>

</div>
