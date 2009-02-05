<?php $comment = $sf_simple_blog_comment ?>
<?php use_helper('Date') ?>
<div<?php if($comment->getIsModerated()): ?> class="moderated"<?php endif; ?>>
<?php echo $comment->getContent() ?>
<br />
<i><?php echo __('Posted on %2%, by %1% (%11%%12%)<br/>about <b>%3%</b>', array(
  '%1%'  => $comment->getAuthorName(),
  '%11%' => mail_to($comment->getAuthorEmail()),
  '%12%' => $comment->getAuthorUrl() ? ', '.link_to($comment->getAuthorUrl()) : '',
  '%2%'  => format_date($comment->getCreatedAt('U')),
  '%3%'  => link_to($comment->getPostTitle(), 'sfSimpleBlogPostAdmin/edit?id='.$comment->getsfSimpleBlogPost()->getId())
  )) ?>
</i>
</div>
