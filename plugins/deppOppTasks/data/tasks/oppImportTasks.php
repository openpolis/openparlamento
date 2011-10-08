<?php
/*
 * This file is part of the oppImportTasks package.
 *
 * (c) 2011 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */
?>
<?php
/**
 * @package    
 * @subpackage Task per importare atti in openparlamento
 * @author     Guglielmo Celata <guglielmo.celata@depp.it>
 */
pake_desc("import ddl a partire da file yaml");
pake_task('opp-import-ddl-from-yaml', 'project_exists');

pake_desc("update ddl a partire da file yaml");
pake_task('opp-update-ddl-from-yaml', 'project_exists');

pake_desc("prepara uno o più ddl per l'upgrade test");
pake_task('opp-prepare-ddl-for-test', 'project_exists');

/**
 * Importa dei ddl a partire da un file yaml
 */
function run_opp_import_ddl_from_yaml($task, $args, $options)
{
  static $loaded;

  // load application context
  if (!$loaded)
  {
    _loader();
  }

  $dry_run = false;
  if (array_key_exists('dry-run', $options)) {
    $dry_run = true;
  }
  
  if (array_key_exists('yaml-file', $options)) {
    $yaml_file = strtolower($options['yaml-file']);
  } else {
    throw new Exception("Specificare il file contenente i dati dei ddl con l'opzione --yaml-file=FILE_COMPLETE_PATH");
  }

  if (array_key_exists('leg', $options)) {
    $leg = strtolower($options['leg']);
  } else {
    throw new Exception("Specificare la legislatura con l'opzione --leg=LEGISLATURA");
  }

  echo "memory usage: " . memory_get_usage( ) . "\n";
  $start_time = time();
  
  $msg = sprintf("import ddl da $yaml_file\n");
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));
  
  if (file_exists($yaml_file)) {
    $ddls = sfYaml::Load($yaml_file);
  } else {
    throw new Exception("Impossibile trovare il file $yaml_file");
  }

  foreach ($ddls as $key => $ddl) {
    $atto = new OppAtto();
    $atto->setLegislatura($leg);
    $atto->setParlamentoId($ddl['parlamento_id']);
    $atto->setRamo(strtoupper($ddl['ramo']));
    $atto->setNumfase($ddl['numfase']);
    $atto->setTipoAttoId(1);
    $atto->setDataPres($ddl['presentazione_date']);
    $atto->setDataAgg($ddl['update_date']);

    $atto->setTitolo($ddl['titolo']);
    $atto->setIniziativa($ddl['iniziativa']);
    if ($dry_run)
    {
      var_dump($ddl);      
    }
    else
    {
      $atto->save();
      $msg = sprintf("atto %s.%s aggiunto - parlamento_id:%d, opp_id:%d\n", 
                     $atto->getRamo(), $atto->getNumfase(), $atto->getParlamentoId(), $atto->getId());
      echo pakeColor::colorize($msg, array('fg' => 'green', 'bold' => false));      
    }
    unset($atto);
  }

  $msg = sprintf("%d atti elaborati\n", count($ddls));
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));

  $msg = sprintf(" [%4d sec] [%10d bytes]\n", time() - $start_time, memory_get_usage( ));
  echo pakeColor::colorize($msg, array('fg' => 'red', 'bold' => false));      
}


/**
 * Processa il file specificato in --yaml-file per l'upgrade di un atto
 *
 */
function run_opp_update_ddl_from_yaml($task, $args, $options)
{
  static $loaded;

  // load application context
  if (!$loaded)
  {
    _loader();
  }

  $dry_run = false;
  if (array_key_exists('dry-run', $options)) {
    $dry_run = true;
  }
  
  if (array_key_exists('yaml-file', $options)) {
    $yaml_file = strtolower($options['yaml-file']);
  } else {
    throw new Exception("Specificare il file contenente i dati dei ddl con l'opzione --yaml-file=FILE_COMPLETE_PATH");
  }
  
  echo "memory usage: " . memory_get_usage( ) . "\n";
  $start_time = time();
  
  $msg = sprintf("upgrade ddl da $yaml_file\n");
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));
  
  if (file_exists($yaml_file)) {
    $up_ddl = sfYaml::Load($yaml_file);
  } else {
    throw new Exception("Impossibile trovare il file $yaml_file");
  }

	$con = Propel::getConnection(OppAttoPeer::DATABASE_NAME);

  $opp_id = $up_ddl['opp_id'];
  $atto = OppAttoPeer::retrieveByPK($opp_id);

  $parl_id = $up_ddl['parl_id'];
  if (is_null($atto->getParlamentoId()) || $atto->getParlamentoId() != $parl_id)
    $atto->setParlamentoId($parl_id);


  $key = 'titolo';
  if (array_key_exists($key, $up_ddl))
  {
    $titolo = $up_ddl['titolo'];
    $atto->setTitolo($titolo);  
    print ("$key\n");
    print (str_repeat("=", strlen($key)) . "\n");
    print ("$titolo\n");
    print ("\n");
  }

  # firme
  $firmatari = array(
    'P' => 'primi_firmatari', 
    'R' => 'relatori', 
    'C' => 'co_firmatari'
  );
  foreach ($firmatari as $tipo_firma => $key) {
    if (array_key_exists($key, $up_ddl) &&
        !is_null($up_ddl[$key]))
    {
      print ("$key\n");
      print (str_repeat("=", strlen($key)) . "\n");
      foreach ($up_ddl[$key] as $id => $signature_data) 
      {
        $ca = new OppCaricaHasAtto();
        $ca->setAttoId($opp_id);
        $ca->setCaricaId($id);
        $ca->setTipo($tipo_firma);
        $name = $signature_data['nome'];
        $signature_date = $signature_data['data_firma'];
        $ca->setData($signature_date);
        $ca->save();
        print "  $name ($id) il $signature_date\n";
      }
      print ("\n");
    }
  }
  
  
  # commissioni
  $commissioni = array(
    'referente',
    'consultiva',
  );
  foreach ($commissioni as $tipo_commissione){
    if (array_key_exists($tipo_commissione, $up_ddl))
    {
      print ("$tipo_commissione\n");
      print (str_repeat("=", strlen($tipo_commissione)) . "\n");
      foreach ($up_ddl[$tipo_commissione] as $id => $name) 
      {
        $as = new OppAttoHasSede();
        $as->setAttoId($opp_id);
        $as->setSedeId($id);
        $as->setTipo(ucfirst($tipo_commissione));
        $as->save();
        print "  $name ($id)\n";
      }      
      print ("\n");
    }
  }

  # tagging
  if (array_key_exists('tags', $up_ddl))
  {
    print ("tagging\n");
    print ("=======\n");
    foreach ($up_ddl['tags'] as $tag_id => $name)
    {
      $t = new Tagging();
      $t->setTaggableModel('OppAtto');
      $t->setTaggableId($opp_id);
      $t->setTagId($tag_id);
      $t->save();
      print "  $name ($tag_id)\n";
    }
    print "\n";
  }
  
  
  # documenti
  if (array_key_exists('documenti', $up_ddl))
  {
    print ("documenti\n");
    print ("=========\n");
    foreach ($up_ddl['documenti'] as $cnt => $doc)
    {
      if (!array_key_exists('titolo', $doc))
        $doc['titolo'] = "Testo della Proposta di Legge";

      $d = new OppDocumento();
      $d->setAttoId($opp_id);
      $d->setTitolo($doc['titolo']);
      $d->setUrlPdf($doc['url_pdf']);
      $d->setUrlTesto($doc['url_testo']);
      
      printf("titolo: %s\n", $doc['titolo']);
      printf("  pdf:  %s\n", $doc['url_pdf']);
      printf("  html: %s\n", $doc['url_testo']);
      
      if (file_exists($doc['file_testo']))
      {
        $doc_txt = file_get_contents($doc['file_testo']);
        $d->setTesto($doc_txt);
        printf("  text: %s\n", $doc['file_testo']);
      }
    
      $d->save();
    }
    print("\n");
  }
  
  #pred e succ
  if (array_key_exists('pred_id', $up_ddl))
  {
    $atto->setPred($up_ddl['pred_id']);
    printf(" pred: %d\n\n", $up_ddl['pred_id']);   
  }
  
  if (array_key_exists('succ_id', $up_ddl))
  {
    $atto->setSucc($up_ddl['succ_id']);
    printf(" succ: %d\n\n", $up_ddl['succ_id']);   
  }

  # iter
  if (array_key_exists('iter', $up_ddl))
  {
    print ("iter\n");
    print ("====\n");
    foreach ($up_ddl['iter'] as $id => $details) 
    {
      $ai = new OppAttoHasIter();
      $ai->setAttoId($opp_id);
      $ai->setIterId($id);
      $ai->setData($details['data_pres']);
      $ai->save();
      printf("  %s (%s) - %s\n", $details['fase'], $id, $details['data_pres']);
    }      
    print "\n";    
  }
  
  # relazioni
  if (array_key_exists('relazioni', $up_ddl))
  {
    print ("relazioni\n");
    print ("=========\n");
    foreach ($up_ddl['relazioni'] as $key => $details) 
    {
      $r = new OppRelazioneAtto();
      $r->setAttoFromId($details['from_id']);
      $r->setAttoToId($details['to_id']);
      $r->setTipoRelazioneId($details['tipo_id']);
      $r->save();
      printf("  from: %s to: %s - %s (%s)\n", 
             $details['from_id'], $details['to_id'], 
             $details['tipo_relazione'], $details['tipo_id']);
    }      
    print "\n";    
  }
  
  # trattazione (esiti, sedute e interventi)
  $tipi_commissione = array(
    'primaria' => 'Primaria', 
    'consultiva' => 'Consultiva',
    'assemblea' => 'Aula'
  );
  foreach ($tipi_commissione as $key => $tipo_commissione){
    $trattazione_key = "trattazione_$key";
    if (array_key_exists('trattazioni', $up_ddl))
    {
      print ("trattazione $tipo_commissione\n");
      print ("============" . str_repeat("=", strlen($tipo_commissione)) . "\n");
      foreach ($up_ddl['trattazioni'][$trattazione_key] as $seduta_id => $details) 
      {
        list($seduta, $id) = explode("_", $seduta_id);
        $es = new OppEsitoSeduta();
        $es->setAttoId($opp_id);
        $es->setSedeId($details['comm_id']);
        $es->setData($details['date']);
        $es->setEsito($details['esito']);
        $es->setTipologia($details['comm_type']);
        $es->save();
        print "  seduta $id\n";
        printf("    %s - %s: %s\n", $details['date'], $details['comm_type'], $details['comm_id']);
        printf("    esito: %s\n", $details['esito']);
        printf("    %d interventi\n", count($details['interventi']));
        foreach ($details['interventi'] as $carica_id => $i_details) {          
      		try {
      			$con->begin();
            # cancella tutti i record con interventi di carica su atto, in sede e data
            $c = OppInterventoPeer::criterionByAttoCaricaSedeData($opp_id, $carica_id, $details['comm_id'], $details['date']);
            $deleted = OppInterventoPeer::doDelete($c, $con);
            printf("      trovati e rimossi %d record\n", $deleted);
            # riscrive un solo record, con tutte le url raggruppate
            $i = new OppIntervento();
            $i->setAttoId($opp_id);
            $i->setCaricaId($carica_id);
            $i->setData($details['date']);
            $i->setSedeId($details['comm_id']);
            $i->setTipologia($details['comm_type']);
            $i->setUrl($i_details['urls']);
            $i->save($con);
            printf("      %s (%d) - %s\n", $i_details['cognome'], $carica_id, $i_details['urls']);

      			$con->commit();
      		} catch (PropelException $e) {
            printf("problemi nell'aggiornamento interventi di %d su %d, sede %d, data %s\n%s\n",
                   $carica_id, $opp_id, $details['comm_id'], $details['date'], $e->getMessage());
                   
      			$con->rollback();
      		}
        }
      }      
      print ("\n");
    }
  }
  

  $atto->setDataAgg(time());
  $atto->save($con);

  # l'md5 viene ri-salvato dopo il salvataggio per evitare che atti inconsistenti siano
  # marcati come uguali
  $atto->setMd5($up_ddl['md5']);
  $atto->save();
  
  unset($atto);

  $msg = sprintf("fine elaborazione atto\n");
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));

  $msg = sprintf(" [%4d sec] [%10d bytes]\n", time() - $start_time, memory_get_usage( ));
  echo pakeColor::colorize($msg, array('fg' => 'red', 'bold' => false));      
}


/**
 * Prepara uno o più atti, specificati dall'id nell'elenco argomenti per un test
 * Vengono rimossi tutti i dati accessori:
 *  firme, assrgnazioni in commissione, documenti, tagging, esiti, interventi
 * Sono resettati il titolo e l'md5
 *
 * Necessario per pulire un oggetto prima di un test di upgrade
 */
function run_opp_prepare_ddl_for_test($task, $args, $options)
{
  static $loaded;

  // load application context
  if (!$loaded)
  {
    _loader();
  }

  $dry_run = false;
  if (array_key_exists('dry-run', $options)) {
    $dry_run = true;
  } 
  
	$con = Propel::getConnection(OppAttoPeer::DATABASE_NAME);

  echo "memory usage: " . memory_get_usage( ) . "\n";
  $start_time = time();

  try {
    $atti_rs = OppAttoPeer::getRSFromIDArray($args, $con);            
  } catch (Exception $e) {
    throw new Exception("Specificare degli ID validi. \n" . $e);
  }
  
  $n_atti = $atti_rs->getRecordCount();
  $cnt = 0;
  while ($atti_rs->next())
  {
    $a = $atti_rs->getRow();
    $atto_id = $a['id'];
    print ("atto: $atto_id\n");
    $atto = OppAttoPeer::retrieveByPK($atto_id);
    $atto->setTitolo("");
    $atto->setMd5("");
    $atto->save();
    print ("  titolo e md5 annullat1\n");
    
    # firme
    $items = $atto->getOppCaricaHasAttos(null, $con);
    $nitems = count($items);
    foreach ($items as $cnt => $item)
      $item->delete($con);
    print ("  $nitems firme rimosse\n");
    
    # assegnazioni
    $items = $atto->getOppAttoHasSedes(null, $con);
    $nitems = count($items);
    foreach ($items as $cnt => $item)
      $item->delete($con);
    print ("  $nitems assegnazioni in commissione rimosse\n");
    
    # tag (sf_tagging)
    $items = $atto->getTagsAsTaggingObjects(null, $con);
    $nitems = count($items);
    foreach ($items as $cnt => $item)
      $item->delete($con);
    print ("  $nitems tagging dell'atto rimossi\n");

    # documenti
    $items = $atto->getOppDocumentos(null, $con);
    $nitems = count($items);
    foreach ($items as $cnt => $item)
      $item->delete($con);
    print ("  $nitems documenti allegati rimossi\n");

    # iter
    $last_iter = $atto->getLastIter();
    $last_iter->delete();
    
    # relazioni
    $items = $atto->getRelazioni();
    $nitems = count($items);
    foreach ($items as $cnt => $item)
      $item->delete($con);
    print ("  $nitems relazioni rimosse\n");
    
    # esito sedute
    $items = $atto->getOppEsitoSedutas();
    $nitems = count($items);
    foreach ($items as $cnt => $item)
      $item->delete($con);
    print ("  $nitems esiti rimossi\n");

    # interventi
    $items = $atto->getOppInterventos();
    $nitems = count($items);
    foreach ($items as $cnt => $item)
      $item->delete($con);
    print ("  $nitems interventi rimossi\n");
    
    print "\n";
  }

  $msg = sprintf("fine task\n");
  echo pakeColor::colorize($msg, array('fg' => 'cyan', 'bold' => true));

  $msg = sprintf(" [%4d sec] [%10d bytes]\n", time() - $start_time, memory_get_usage( ));
  echo pakeColor::colorize($msg, array('fg' => 'red', 'bold' => false));      
}

