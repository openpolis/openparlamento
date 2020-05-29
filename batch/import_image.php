<?php

define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$c=new Criteria();
$c->add(OppCaricaPeer::TIPO_CARICA_ID, array(1,4,5), Criteria::IN);
$parls=OppCaricaPeer::doSelect($c);
foreach($parls as $p)
{
	if ($p->getTipoCaricaId()==1)
		shell_exec("curl http://documenti.camera.it/_dati/leg18/schededeputatiprototipo/foto/scheda_big/d".$p->getParliamentId().".jpg -o foto_parlamentari/".$p->getPoliticoId().".jpg");
	else
	{
		$id=$p->getParliamentId();
		while (strlen($id)<8)
			$id='0'.$id;
		shell_exec("curl http://www.senato.it/leg/18/Immagini/Senatori/".$id.".jpg -o foto_parlamentari/".$p->getPoliticoId().".jpg");
	}
}


?>