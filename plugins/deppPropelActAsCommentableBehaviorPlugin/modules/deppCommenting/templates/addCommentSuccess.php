<a href="#top" class="go-top">torna su</a>
<a name="comments"></a>
<?php include_partial('deppCommenting/commentsList', array('content' => $content)) ?>

<hr/>

<?php include_component('deppCommenting', 'addComment',  
                        array('content' => $content, 
                              'read_only' => sfConfig::get('app_ddl_comments_enabled', false),
                              'automoderation' => sfConfig::get('app_ddl_comments_automoderation', 'captcha')) ) ?>
