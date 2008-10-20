<?php echo isset($message) ? $message : '' ?>
<?php if (isset($token)): ?>
<script type="text/javascript">
$('<?php echo 'current_rating_'.$token ?>').style.width = '<?php echo (string)($star_width * $rating) ?>px';
</script>
<?php endif; ?>