<?php use_helper('Date', 'I18N') ?>
  <head>
    <style>
      html { font-size:100.01%; /* fixes some browser bugs */ }
      
      body {
      	font:1em "Trebuchet MS",Verdana,Arial,Helvetica,sans-serif;
      	background-color: #<?php echo $bg_color ?>;
      	color: #<?php echo $text_color ?>;
      }
    
      #bill_status {
        font-size: 12px;
      }
#bill_status ul {
	margin-bottom:10px;
}
#title, #links, #powered {
	text-align:center;
	line-height:1.1em;
}
#title h1 {
	font-size:14px;
	font-weight:bold;
	margin:5px 5px 0 5px;
}
#title p {
	margin-top:4px;
}
#links {
	margin-bottom:5px;
}
#powered {
	font-size:10px;
	margin-bottom:3px;
}
	a {
        color: <?php echo $text_color ?>;
      }
      a:hover {
        text-decoration: none;
      }
      ul {
        list-style: none;
        margin: 0;
        padding: 0;
      }
    
      li {
        margin: 0 5px 2px 5px;
        line-height: 14px;
      }
    </style>
  </head>

  <body style="background:none repeat scroll 0 0 #<?php echo $bg_color ?>; color:#<?php echo $text_color ?>">
    
      <div id="bill_status" style="background:none repeat scroll 0 0 #<?php echo $bg_color ?>; color:#<?php echo $text_color ?>">
        <div class="syndicator_items">	
     
      <div id="title" style="margin:2px">
        
           <?php if($pos==1) : ?>
             <span style="font-size:18px; font-weight:bold; color:green; text-align:center;">
             sono favorevole <?php echo image_tag('/images/ico-thumb-up.png')?>
             </span>
          <?php elseif ($pos==2) : ?>
          <span style="font-size:18px; font-weight:bold; color:red; text-align:center;">
            sono contrario <?php echo image_tag('/images/ico-thumb-down.png')?>
            </span>
          <?php endif ?>  
          
      </div>  
			<div style="font-size:12px; margin:0 5px 5px; text-align:left;">
            	<span style="font-weight:bold;"><?php echo $tipo ?> <?php echo $ramo.".".$numfase ?></span>

				<span><?php echo $titolo ?> <a href="/feed/atto/<?php echo $id ?>" target="_top"><img alt="Feed-icon-10x10" border="0" src="/images/feed-icon-10x10.png" /></a></span>
			</div>
	        	<ul style="margin-bottom:0px;">
	        	  
	        	  <?php if ($firmatario) : ?>
  	        	  <li style="line-height:12px">
  	        	    <strong>presentato da:</strong> 
	            <?php echo link_to($firmatario->getNome()." ".$firmatario->getCognome(),'@parlamentare?'.$firmatario->getUrlParams(), array('target' => '_top')) ?>
	            </li>
	             <?php endif ?>
	             <li style="line-height:12px">
	             <?php if ($status) : ?>
	            <strong>status:</strong>  <?php echo format_date($status_data, 'dd/MM/yyyy') ?> - <?php echo $status ?>
	            <?php else : ?>
	             <strong>presentato il </strong><?php echo format_date($datapres, 'dd/MM/yyyy') ?>
	             <?php endif ?>
	             </li>
	            <div id="powered" style="text-align:center; margin: 5px 0 5px 5px;">
              <li style="line-height:12px;font-size:12px;">nella community di openpolis:</li>
	            <li style="line-height:12px"><span style="color:green; font-size:14px;"> <?php echo ($fav==0 ? 'nessun favorevole' :($fav==1 ?'<strong>uno</strong> favorevole' :'<strong>'.$fav.'</strong> favorevoli')) ?></span> e 
	            <span style="color:red; font-size:14px;"> <?php echo ($contr==0 ? 'nessun contrario' :($contr==1 ?'<strong>uno</strong> contrario' :'<strong>'.$contr.'</strong> contrari')) ?></span></li>
	            <li style="line-height:12px"><?php //echo ($commenti==0 ? 'nessun commento, ' :($commenti==1 ?'<strong>un</strong> commento, ' :'<strong>'.$commenti.'</strong> commenti, ')) ?>
	            <?php //echo ($monitor==0 ? 'nessuno monitora l\'atto' :($monitor==1 ?'<strong>un</strong> utente sta monitorando l\'atto' :'<strong>'.$monitor.'</strong> utenti stanno monitorando l\'atto')) ?></li>
	            </div>
	      		</ul>

			<div id="links" style="font-size:20px; font-weight:bold;">
            	<a href="/singolo_atto/<?php echo $id ?>" target="_top">vota anche tu!</a><br />

			</div>
			<div id="powered">
	            	<span>by <a href="/" target="_top"><em class="open">open</em><em class="parlamento">parlamento</em></a></span>

			</div>
      	</div>
	</div>
    
  </body>
