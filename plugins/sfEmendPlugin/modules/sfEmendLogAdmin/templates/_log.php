<?php $log = $sf_emend_log ?>
<?php use_helper('Date') ?>
<i><?php echo $log->getCreatedAt('d/m/Y - h:i:s') ?>
</i>
<b><?php echo $log->getMsgType() ?></b>
<br/>
<?php echo $log->getMsg() ?>
</div>
