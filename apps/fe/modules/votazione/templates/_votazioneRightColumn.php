<p class="last-update">data di ultimo aggiornamento: <strong>25-11-2008</strong></p>
<?php 
  echo include_partial('sfSolr/votazioni_controls', 
                      array('query' => $query,
                            'title' => 'nelle votazioni'));
?>

