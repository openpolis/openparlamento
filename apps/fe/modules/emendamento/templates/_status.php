<?php 
if ($last_status->getOppEmIter()->getFase()!='Presentato')
{
  echo '<ul style="margin-bottom: 12px;" class="presentation float-container">';
  echo '<li><h5>';
  echo 'status: <em>';
  if ($last_status->getOppEmIter()->getFase()!='Altro')
  {
    if ($last_status->getOppEmIter()->getFase()=='Approvato' || $last_status->getOppEmIter()->getFase()=='Accolto')
      echo '<span style="color:green;">';
    else
    {
      if ($last_status->getOppEmIter()->getFase()=='Respinto' || $last_status->getOppEmIter()->getFase()=='Ritirato' || $last_status->getOppEmIter()->getFase()=='Inammissibile' || $last_status->getOppEmIter()->getFase()=='Precluso')
        echo '<span style="color:red;">';
      else
        echo '<span>';
    }  
      
    echo $last_status->getOppEmIter()->getFase();
    echo '</span>';
  }  
  if ($last_status->getNota()!=NULL )
  {
    $link_collegato="";
    
    if (preg_match('#^Id. em. #',$last_status->getNota()) || preg_match('#^Sost. id. em. #',$last_status->getNota()) || preg_match('#^V. em. #',$last_status->getNota()))
    {
      $tmpfase=explode(' em. ',$last_status->getNota());
      $tmpfase=trim($tmpfase[1]);
      $c=new Criteria();
      $c->addJoin(OppEmendamentoPeer::ID,OppAttoHasEmendamentoPeer::EMENDAMENTO_ID);
      $c->add(OppEmendamentoPeer::SEDE_ID,$last_status->getOppEmendamento()->getSedeId());
      $c->add(OppEmendamentoPeer::NUMFASE,$tmpfase);
      $c->add(OppAttoHasEmendamentoPeer::ATTO_ID,$relatedAttos[0]->getOppAtto()->getId());
      $collegato=OppEmendamentoPeer::doSelectOne($c);
      if ($collegato)
      {
        $c=new Criteria();
        $c->addJoin(OppEmendamentoHasIterPeer::EM_ITER_ID,OppEmIterPeer::ID);
        $c->add(OppEmendamentoHasIterPeer::EMENDAMENTO_ID,$collegato->getId());
        $status_coll=OppEmIterPeer::doSelectOne($c);
        $link_collegato= link_to($last_status->getNota(),'/emendamento/'.$collegato->getId());
        if ($status_coll)
           $link_collegato= $link_collegato." (".$status_coll->getFase().")";
      }     
    }
    
    if (preg_match('#^V. testo #',$last_status->getNota()))
    {
      $tmpfase=explode('V. ',$last_status->getNota());
      if (substr_count($last_status->getOppEmendamento()->getNumfase(),"(")>0)
      {
        $numero_fase=explode("(",$last_status->getOppEmendamento()->getNumfase());
        $numero_fase=trim($numero_fase[0]);
      }
      else $numero_fase=$last_status->getOppEmendamento()->getNumfase();
      
      $c=new Criteria();
      $c->addJoin(OppEmendamentoPeer::ID,OppAttoHasEmendamentoPeer::EMENDAMENTO_ID);
      $c->add(OppEmendamentoPeer::SEDE_ID,$last_status->getOppEmendamento()->getSedeId());
      $c->add(OppEmendamentoPeer::NUMFASE,$numero_fase." (".$tmpfase[1].")");
      $c->add(OppAttoHasEmendamentoPeer::ATTO_ID,$relatedAttos[0]->getOppAtto()->getId());
      $collegato=OppEmendamentoPeer::doSelectOne($c);
      if ($collegato)
      {
        $c=new Criteria();
        $c->addJoin(OppEmendamentoHasIterPeer::EM_ITER_ID,OppEmIterPeer::ID);
        $c->add(OppEmendamentoHasIterPeer::EMENDAMENTO_ID,$collegato->getId());
        $status_coll=OppEmIterPeer::doSelectOne($c);
        $link_collegato= link_to($last_status->getNota(),'/emendamento/'.$collegato->getId());
        if ($status_coll)
           $link_collegato= $link_collegato." (".$status_coll->getFase().")";
      }
    }
    
    if ($last_status->getOppEmIter()->getFase()!='Altro') 
      echo " (".$last_status->getNota().")";
    else
    {
      if ($link_collegato=="")
        echo $last_status->getNota();
      else
        echo $link_collegato;
    }
  }
    
  echo '</em>';
  echo '</h5></li>';
  echo '</ul>';
}

?>