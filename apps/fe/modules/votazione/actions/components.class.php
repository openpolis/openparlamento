<?php
class votazioneComponents extends sfComponents
{

 public function executeChartEsito()
  {
   $fav=$this->votazione->getFavorevoli();
   $contr=$this->votazione->getContrari();
   $ast=$this->votazione->getAstenuti();
   $tot=$fav+$contr+$ast;
   
  
      $fav_perc=round($fav * 100 /$tot,1);
      $fav_label="Favorevoli: ".$fav." (".$fav_perc."%)";   
   
      $contr_perc=round($contr * 100 /$tot,1);
      $contr_label="Contrari: ".$contr." (".$contr_perc."%)";
   
      $ast_perc=round($ast * 100 /$tot,1);
      $ast_label="Astenuti: ".$ast." (".$ast_perc."%)";

   $gchart="http://chart.apis.google.com/chart?chs=180x200&chd=t:".round($fav_perc,0).",".round($contr_perc,0).",".round($ast_perc,0)."&cht=p&chdl=".$fav_label."|".$contr_label."|".$ast_label."&chco=00ff00,ff0000,0000ff&chdlp=tv&chf=bg,s,f7f7ff";
   
 
   $this->gchart = $gchart;
     
    
  }
  
   public function executeChartFavorevoli()
  {
   // FAV CONTR e AST
   $fav=$this->votazione->getFavorevoli();
   $contr=$this->votazione->getContrari();
   $ast=$this->votazione->getAstenuti();
   
   $label_fav="";
   $label_contr="";
   $label_ast="";
   $favorevoli="";
   $contrari="";
   $astenuti="";
   foreach ($this->risultati as $gruppo => $risultato)
    {
     $c1= new Criteria();
     $c1->add(OppGruppoPeer::NOME,$gruppo);
     $obj_gruppo=OppGruppoPeer::doSelectOne($c1);
     $gruppo_acr=$obj_gruppo->getAcronimo();
     
     if ($risultato['Favorevole']!==0) {
      $gruppo_fav= round($risultato['Favorevole'] * 100/$fav,0);
      $gruppo_label=$gruppo_acr." ".$risultato['Favorevole']." (".round($risultato['Favorevole'] * 100/$fav,1)."%)";
      if ($label_fav=="") $label_fav=$gruppo_label;
      else $label_fav=$label_fav."|".$gruppo_label;
      if ($favorevoli=="") $favorevoli=$gruppo_fav;
      else $favorevoli=$favorevoli.",".$gruppo_fav;
      }
      if ($risultato['Contrario']!==0) {
      $gruppo_contr= round($risultato['Contrario'] * 100/$contr,0);
      $gruppo_label=$gruppo_acr." ".$risultato['Contrario']." (".round($risultato['Contrario'] * 100/$contr,1)."%)";
      if ($label_contr=="") $label_contr=$gruppo_label;
      else $label_contr=$label_contr."|".$gruppo_label;
      if ($contrari=="") $contrari=$gruppo_contr;
      else $contrari=$contrari.",".$gruppo_contr;
      }
      if ($risultato['Astenuto']!==0) {
      $gruppo_ast= round($risultato['Astenuto'] * 100/$ast,0);
      $gruppo_label=$gruppo_acr." ".$risultato['Astenuto']." (".round($risultato['Astenuto'] * 100/$ast,1)."%)";
      if ($label_ast=="") $label_ast=$gruppo_label;
      else $label_ast=$label_ast."|".$gruppo_label;
      if ($astenuti=="") $astenuti=$gruppo_ast;
      else $astenuti=$astenuti.",".$gruppo_ast;
      }
     }
  
   
   $gchartFav="http://chart.apis.google.com/chart?chs=350x130&chd=t:".$favorevoli."&cht=p&chl=".$label_fav."&chdlp=bv";
   $gchartContr="http://chart.apis.google.com/chart?chs=350x130&chd=t:".$contrari."&cht=p&chl=".$label_contr."&chdlp=bv";
   $gchartAst="http://chart.apis.google.com/chart?chs=350x130&chd=t:".$astenuti."&cht=p&chl=".$label_ast."&chdlp=bv"; 
   
   $this->gchartFav = $gchartFav;
   $this->gchartContr = $gchartContr;
   $this->gchartAst = $gchartAst;
   $this->fav = $fav;
   $this->contr = $contr;
   $this->ast = $ast;
  }
  
     
   public function executeChartPresenze() {
    
   // ASSENTI E IN MISSIONE
   $voti=$this->votantiComponent;
   $arr_gruppi_ass_miss=array();
   $tot_ass_miss=0;
   $valore="";
   $label="";
   $tot_assente =0;
   $tot_missione =0;
  
  while($voti->next()) {
    if ($voti->getString(6)=='Assente' || $voti->getString(6)=='In missione' ) {
        if ($voti->getString(6)=='Assente') $tot_assente +=1;
        else $tot_missione +=1;
        $tot_ass_miss=$tot_ass_miss+1;
         if (!array_key_exists($voti->getString(7),$arr_gruppi_ass_miss)) 
             $arr_gruppi_ass_miss[$voti->getString(7)]=0;
        $arr_gruppi_ass_miss[$voti->getString(7)] += 1;
       
    }
   } 

    
    foreach ($arr_gruppi_ass_miss as $gruppo1 => $numvoto) {
      if ($numvoto>0) {
         if ($valore=="") $valore=round($numvoto*100/$tot_ass_miss,0);
         else $valore=$valore.",".round($numvoto*100/$tot_ass_miss,0);
         if ($label=="") $label=$gruppo1." ".$numvoto." (".round($numvoto*100/$tot_ass_miss,0)."%)";
         else $label=$label."|".$gruppo1." ".$numvoto." (".round($numvoto*100/$tot_ass_miss,0)."%)"; 
       }
     }    
         
    
   $gchartAssMiss="http://chart.apis.google.com/chart?chs=180x200&chd=t:".$valore."&cht=p&chdl=".$label."&chdlp=tv"; 
   
   if ($this->ramo=='Camera') $num=630;
   else $num=322;
   
   $presenze=round($this->votazione->getPresenti()*100/$num,0).",".round($tot_assente*100/$num,0).",".round($tot_missione*100/$num,0);
   
   $gchartPresenze="http://chart.apis.google.com/chart?chs=180x200&chd=t:".$presenze."&cht=p&chdl=Presenti ".$this->votazione->getPresenti()." (".round($this->votazione->getPresenti()*100/$num,1)."%)|Assenti ".$tot_assente." (".round($tot_assente*100/$num,1)."%)|In Missione ".$tot_missione." (".round($tot_missione*100/$num,1)."%)&chdlp=tv&chf=bg,s,f7f7ff";
 
        
   $this->tot_ass_miss=$tot_ass_miss;
   $this->gchartAssMiss=$gchartAssMiss;
   $this->gchartPresenze=$gchartPresenze;
    
  }
  
   public function executeChartRibelli() {
   
   $ribelli=$this->ribelli;
   $label="";
   $valore="";
   $ribelli_gruppi=array();
   
   foreach ($ribelli as $cognome => $ribelle) {
     $c1= new Criteria();
     $c1->add(OppGruppoPeer::NOME,$ribelle['gruppo']);
     $obj_gruppo=OppGruppoPeer::doSelectOne($c1);
     $gruppo_acr=$obj_gruppo->getAcronimo();
     
     if (!array_key_exists($gruppo_acr,$ribelli_gruppi)) 
             $ribelli_gruppi[$gruppo_acr]=0;
     $ribelli_gruppi[$gruppo_acr] += 1;
   }  
   
   foreach ($ribelli_gruppi as $gruppo1 => $numvoto) {
      if ($numvoto>0) {
         if ($valore=="") $valore=round($numvoto*100/$this->votazione->getRibelli(),0);
         else $valore=$valore.",".round($numvoto*100/$this->votazione->getRibelli(),0);
         if ($label=="") $label=$gruppo1." ".$numvoto." (".round($numvoto*100/$this->votazione->getRibelli(),0)."%)";
         else $label=$label."|".$gruppo1." ".$numvoto." (".round($numvoto*100/$this->votazione->getRibelli(),0)."%)"; 
       }
     }    
     
     $gchartRibelli="http://chart.apis.google.com/chart?chs=350x130&chd=t:".$valore."&cht=p&chl=".$label."&chdlp=bv"; 
     $this->gchartRibelli=$gchartRibelli;
   
   }
   
    public function executeKeyvotes()
  { 
     $c = new Criteria();
     $c->addJoin(OppVotazionePeer::ID,sfLaunchingPeer::OBJECT_ID);
      $c->addJoin(OppVotazionePeer::SEDUTA_ID,OppSedutaPeer::ID);
     $c->add(sfLaunchingPeer::OBJECT_MODEL,'OppVotazione'); 
     $c->add(sfLaunchingPeer::NAMESPACE,'key_vote');
     //$c->addDescendingOrderByColumn(sfLaunchingPeer::PRIORITY);
     $c->addDescendingOrderByColumn(OppSedutaPeer::DATA);
     if ($this->limit!=0)
        $c->setLimit($this->limit);
     $this->votazioni=OppVotazionePeer::doSelect($c);
     
  
  }
   
        
}

?>
