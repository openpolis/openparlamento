<?php if($atto->getTipoAttoId()>1 && $atto->getTipoAttoId()<12) :?>
  <?php if (is_int($atto->getPred())) : ?>
    <?php echo '<ul style="margin-bottom: 12px;" class="presentation float-container">' ?>
      <li>
        <?php echo '<h6>atto originario: <em>'.link_to(OppAttoPeer::retrieveByPk($atto->getPred())->getNumfase(),'/singolo_atto/'.$atto->getPred()).'</em></h6>' ?>
      </li>
    </ul>   
  <?php endif; ?>
  <?php if(is_int($atto->getSucc())) : ?>  
     <?php echo '<ul style="margin-bottom: 12px;" class="presentation float-container">' ?>
      <li>
        <?php echo '<h6>trasformato in atto: <em>'.link_to(OppAttoPeer::retrieveByPk($atto->getSucc())->getNumfase(),'/singolo_atto/'.$atto->getSucc()).'</em></h6>' ?>
       </li>
      </ul>
  <?php endif; ?>  
<?php endif; ?>