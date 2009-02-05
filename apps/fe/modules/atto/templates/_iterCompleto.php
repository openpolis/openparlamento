<p class="indent">guarda tutta la cronistoria dell'atto ...	 [ <a href="#" class="btn-open action">apri</a> <a href="#" class="btn-close action" style="display:none;">chiudi</a> ]</p>
<div class="more-results float-container" style="display: none;">
   <ul class="square-bullet">
   <?php foreach($iter_completo as $iter => $data): ?>
     
        <li><em><?php echo format_date($data, 'dd/MM/yyyy') ?></em><br /> <?php echo $iter ?></li>

      
    <?php endforeach; ?>
    </ul>
    <div class="more-results-close">[ <a href="#" class="btn-close action">chiudi</a> ]</div>
</div>


