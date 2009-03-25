<p>
  <?php echo format_number_choice('[0]<strong>Nessuno</strong> monitora|[1]<strong>Un</strong> utente monitora|(1,+Inf]<strong>%1%</strong> utenti monitorano', array('%1%' => $nMonitoringUsers), $nMonitoringUsers) ?> questo <?php echo $item_type ?>
</p>

<?php if ($nMonitoringUsers > 0): ?>
  <p><a href="#monitoringusersdo" class="action">questi utenti monitorano anche...</a></p>		  
<?php endif ?>
    
    
