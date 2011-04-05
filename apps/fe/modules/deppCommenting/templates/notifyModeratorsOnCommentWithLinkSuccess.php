<?php echo use_helper('deppCommenting') ?>
<?php 
  $sf_site_url = sfConfig::get('sf_site_url', 'openparlamento');
?>

<p>&Egrave; stato ricevuto un nuovo commento contenente un link da un utente non registrato.</p>

<p>Questo il testo del commento: 
<div style="font-family:Courier; font-size: 12px; margin: 1em">
<?php echo $comment_object->getText() ?>
</div>
</p>

<p>Il commento si riferisce 
<?php switch ($comment_object->getCommentableModel()) {
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
} ?>  
<?php echo link_to_commentable_item($comment_object) ?>
</p>

<p>Il commento non &egrave; stato pubblicato. Per pubblicarlo, effettua il login ed entra nell'<a href="<?php echo $comments_backend_url ?>">interfaccia di gestione dei commenti</a></p>