<?php if (count($monitored_acts) > 0): ?>
<h5 id="type_<?php echo $type_id;?>"class="subsection"><?php echo $type_denominazione; ?></h5>
<?php if ($n_total_acts > sfConfig::get('app_monitored_acts_per_type_limit') && $filters['act_type_id'] == 0): ?>
  <div class="show-all-results">
    <?php echo link_to('mostra tutti i '. $n_total_acts . ' risultati', 
                       '@monitoring_acts?user_token=' .$sf_user->getToken(). 
                       '&filter_act_type_id=' . $type_id, 
                       array('post' => true)); ?>
  </div>  
<?php endif ?>
	<table class="list-table column-table">
		<thead>
			<tr>
				<th class="evident" scope="col">aggiungi o rimuovi<br/>dai preferiti:</th>
				<th class="evident" scope="col"><br/>sigla/titolo:</th>
				<th class="evident" scope="col">stato di avanzamento</th>
				<th class="evident" scope="col">argomenti</th>
				<th class="evident W20_100" scope="col"><br/>notizie relative (<?php echo image_tag('ico-new.png', array('alt' => 'nuovo')) ?>):</th>
				<th class="evident" scope="col">il tuo voto:</th>
				<th class="evident" scope="col"><br/>smetti di monitorare:</th>
				</tr>
		</thead>
		<tbody>
      <?php foreach ($monitored_acts as $act): ?>
        <?php echo include_component('monitoring', 'actLine', 
                                     array('act' => $act, 
                                           'user' => $user, 
                                           'user_id' => $user_id, 
                                           'user_voting_act' => $act->getUserVoting($user_id))); ?>                                   
      <?php endforeach ?>
		</tbody>
	</table>

<?php endif ?>

