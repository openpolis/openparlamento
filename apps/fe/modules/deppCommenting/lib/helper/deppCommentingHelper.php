<?php
function link_to_commentable_item($comment)
{
  $id = $comment->getCommentableId();
  
  switch ($comment->getCommentableModel()) {
    case 'OppEmendamento':
      $module = 'emendamento';
      break;
    case 'OppAtto':
      $module = 'atto';
      break;
    case 'OppVotazione':
      $module = 'votazione';
      break;
    
    default:
      return '';
      break;
  }
  
  $env = sfConfig::get('sf_environment', 'prod');
  $controller = $env=='prod'?'index.php':"fe_$env.php";
  $url = 'http://' . sfConfig::get('sf_site_url') . "/$controller/$module/commenti/id/$id";
  
  return "<a href=\"$url\">$module: $id</a>";
}