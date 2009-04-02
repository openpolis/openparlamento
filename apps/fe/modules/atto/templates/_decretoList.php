<?php echo use_helper('PagerNavigation'); ?>

<table class="disegni-decreti column-table">
        <thead>
          <tr> 
            <th scope="col">decreto legge:</th>
            <th scope="col">stato:</th>  
            <th scope="col">DDL di<br />conversione:</th>
            <th scope="col">voti e commenti<br />degli utenti:</th>
          </tr>
        </thead>
	   
	  <tbody>
	  <?php $tr_class = 'even' ?>
          <?php foreach ($pager->getResults() as $ddl): ?>
            <tr class="<?php echo $tr_class; ?>">
            <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?>
              <th scope="row">
                <p class="content-meta">			 
                  <?php if($ddl->getDataPres()): ?>
	                <span class="date"><?php echo format_date($ddl->getDataPres(), 'dd/MM/yyyy') ?></span>
                  <?php endif; ?>
	            </p>
			    <p><?php echo link_to('<em>DL.'.$ddl->getNumfase().'</em> '.$ddl->getTitolo(), 'atto/index?id='.$ddl->getId()) ?></p>
              </th>
              <td><?php include_partial('statoDecreto', array('ddl' => $ddl)) ?></td>
              <td><?php include_component('atto', 'ddlConversione', array('ddl' => $ddl)) ?></td>  
  	          <td>
                <div class="user-stats-column">
                  <span class="green thumb-up">10.677</span><span class="red thumb-down">17.903</span>
                  <p><?php echo link_to('1.130 <strong>commenti</strong>', '#') ?></p>
                </div>
              </td>	
            </tr>
          <?php endforeach; ?>
          <tr>
            <td align="center" colspan='4'>
              <?php echo pager_navigation($pager, 'atto/decretoList') ?>
            </td>
          </tr>
          <tr>
            <td align="center" colspan='4'>
              <?php echo format_number_choice('[0] nessun risultato|[1] 1 risultato|(1,+Inf] %1% risultati', array('%1%' => $pager->getNbResults()), $pager->getNbResults()) ?>
	        </td>
          </tr>
        </tbody>
      </table>	 