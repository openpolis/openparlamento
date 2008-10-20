<a href="#top" class="go-top">torna su</a>
<a name="comments"></a>
<?php include_partial('deppCommenting/commentsList', array('content' => $contenuto)) ?>

<hr/>

<?php include_component('deppCommenting', 'addComment',  
                        array('content' => $contenuto, 
                              'read_only' => sfConfig::get('app_ddl_comments_enabled', false),
                              'automoderation' => sfConfig::get('app_ddl_comments_automoderation', 'captcha')) ) ?>
