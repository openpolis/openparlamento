<div class="meter-bar float-container float-left" style="width: 72%">
	
	<div class="green-meter-bar" style="margin-left: 10px;">
		<div style="left: <?php echo number_format($interventi_avg_perc, 2) ?>%;" class="meter-average"><label>valore medio: <?php echo number_format($interventi_avg, 0) ?></label> </div>
		<div style="width: <?php echo number_format($interventi_perc, 2) ?>%;" class="meter-label"><?php echo number_format($interventi, 0) ?></div>									
		<div style="width: <?php echo number_format($interventi_perc, 2) ?>%;" class="meter-value"> </div>
	</div>
</div>
