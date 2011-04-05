<?php echo use_helper('deppCommenting') ?>
<?php 
  $sf_site_url = sfConfig::get('sf_site_url', 'openparlamento');
?>

E' stato ricevuto un nuovo commento 
contenente un link da un utente non registrato.

Questo il testo del commento: 

===
<?php echo $comment_object->getText() ?>

===

Il commento si riferisce <?php switch ($comment_object->getCommentableModel()) {
  case 'OppEmendamento':
    echo "all'emendamento ";
    break;
  case 'OppVotazione':
    echo "alla votazione ";
    break;
  case 'OppAtto':
    echo "all'atto ";
    break;
  
  default:
    # code...
    break;
} ?>con ID <?php echo $comment_object->getCommentableId() ?>

Il commento non e' stato pubblicato. 

Per pubblicarlo, effettua il login ed entra nell'interfaccia di gestione dei commenti: 
<?php echo $comments_backend_url ?>