<hr />

<a href="#top" class="go-top">torna su</a>
<a name="comments"></a>
<?php include_partial('deppCommenting/commentsList', array('content' => $content)) ?>

<hr/>

<?php include_component('deppCommenting', 'addComment',  
                        array('content'        => $content, 
                              'original_url'   => $original_url, 
                              'read_only'      => $read_only,
                              'automoderation' => $automoderation) ) ?>

<hr/>