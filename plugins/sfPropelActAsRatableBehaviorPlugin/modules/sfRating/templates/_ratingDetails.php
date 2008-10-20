<?php sfLoader::loadHelpers('I18N') ?>
<?php if (isset($object)): ?>
<?php $dom_id = 'sf_rating_details_'.$object_type.'_'.$object->getId() ?>
<table class="rating_details_table" 
       onmouseout="$('<?php echo $dom_id ?>').style.display = 'none'">
  <?php foreach ($rating_details as $rating => $details): ?>
  <tr>
    <th><?php echo sprintf(__('%d stars'), $rating) ?></th>
    <td class="sf_rating_bar_bg">
      <div style="width:<?php echo $details['percent'] * 2 ?>px">
        &nbsp;
      </div>
    </td>
    <td>(<?php echo $details['count'] ?>)</td>
  </tr>
  <?php endforeach; ?>
</table>
<?php endif; ?>