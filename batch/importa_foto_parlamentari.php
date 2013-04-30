<?php

define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'dev');
define('SF_DEBUG',       false);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$c= new Criteria();
$pols=OppPoliticoPeer::doSelect($c);
foreach($pols as $pol)
{
 shell_exec("cd /root/op/op_openparlamento17/");
 shell_exec("/root/op/op_openparlamento17/./symfony opp-sync-polimages ". $pol->getId());
 shell_exec ("s3cmd --add-header 'Cache-control: max-age=86400' --acl-public \
            sync web/images/parlamentari/picture/".$pol->getId().".jpeg \
            s3://op_openparlamento_images/parlamentari/picture/".$pol->getId().".jpeg");
 shell_exec("s3cmd --add-header 'Cache-control: max-age=86400' --acl-public \
             sync web/images/parlamentari/thumb/".$pol->getId().".jpeg \
             s3://op_openparlamento_images/parlamentari/thumb/".$pol->getId().".jpeg");
}




?>
