<div class="row" id="tabs-container">
    <ul id="content-tabs" class="float-container tools-container">
      <li class="current">
        <h2>
          Statistiche
        </h2>
      </li>
    </ul>
</div>

<div class="row">
	<div class="ninecol">
		
		<?php include_component('atto', 'ddl2legge', 
		                        array('leg' => '16','gruppo' => $gruppo) ) ?> 

		<h2>Argomenti dei ddl</h2>                        

		<?php include_component('atto', 'ddl2argomenti', 
		                        array('leg' => '16', 'approvato' => false) ) ?>  
		<h2>Argomenti dei ddl APPROVATI</h2>                         
		<?php include_component('atto', 'ddl2argomenti', 
		                        array('leg' => '16', 'approvato' => true) ) ?>
		
	</div>
</div>                        
