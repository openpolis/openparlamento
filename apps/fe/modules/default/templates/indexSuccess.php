<?php echo use_helper('DeppNews'); ?>

<div id="content" class="float-container">
   
<div id="teasers">

<div class="teaser-box W33_100 float-right">
<h6>Dov'&egrave l'on. Rossi?</h6>
preview del grafico delle distanze
</div>	
	
      <div class="teaser-box W66_100 float-left">
	 <h4>
	 Ogni giorno in parlamento si propongono, discutono e votano<br />
	 <em>leggi</em> che <em>cambiano</em> la <strong>TUA vita</strong>.
	 </h4>			
	 <h3>
         <strong>Intervieni</strong>, <strong>organizzati</strong> e<br />
	 <strong>monitora</strong>. Ti riguarda, <strong>ci riguarda</strong>.
	 </h3>
      </div>
      <div class="clear-both"></div>
     </div>
     
     <div id="main">
       <div class="W45_100 float-right">
            <!-- Box rotazione parlamentari -->
            <div class="section-box"> 
            <h3>i <?php echo $nome_carica ?> <span style="color:<?php echo $color ?>;"><?php echo $string ?></span></h3> 
            </div> 
            <?php echo include_partial('boxparlamentari',array('parlamentari' => $parlamentari, 'cosa' => $cosa, 'nome_carica' => $nome_carica)); ?>
		
	    <div class="clear-both"></div>
	    
            <!-- Box news dal parlamento -->
            <div class="section-box">
                <?php echo link_to(image_tag('ico-rss.png', array('alt' => 'rss')), '@feed', array('class' => 'section-box-rss')) ?>
		
		<h3>le ultime dal parlamento</h3>
		</div>
		<?php echo include_partial('news/newslisthome',array('pager' => $pager,'context' => 1)); ?>
		
		
		  
		  
	      <div class="clear-both"></div>
	   
	    <!-- Box attivita' utenti -->
            <div class="section-box">   
		
		<h3>le ultime dalla comunit&agrave;</h3>
		<ul>
		  <?php foreach ($latest_activities as $activity): ?>
		    <?php $news_text = community_news_text($activity); ?>
		      <?php if ($news_text != ''): ?>
		         <li class="float-container">
			     <div class="date"> <?php echo $activity->getCreatedAt("d/m/Y H:i"); ?></div>							
			     <?php echo $news_text ?>
			  </li>         
                       <?php endif ?>
                      <?php endforeach; ?>
		  </ul>
		  <div class="section-box-scroller tools-container has-next">
		       <?php echo link_to('<strong>vedi le ultime 100 attivit&agrave;</strong>','@news_comunita',array('class' => 'see-all')) ?>
		  </div> 
	      <div class="clear-both"></div>
	    </div>
         
            
	 </div>     
          
           <!-- in evidenza dal blog -->
          <div class="W52_100 float-left"> 
          <div class="section-box"  style="padding-bottom:20px;">
             <?php echo link_to(image_tag('ico-rss.png', array('alt' => 'rss')), '/sfSimpleBlog/postsFeed/format/rss', array('class' => 'section-box-rss')) ?>
             <h3>in evidenza dal blog</h3>
             <div class="news-disegni-decreti float-container" >
		<ul>
		  <li>
		    <strong>25/04/2009</strong>   
		    <p style="font-size:14px; font-weight: bolder; "><a href="#">Lorem blehevv vv3 vghvh dvhgv vhgvd dvhgvd dvhgvd</a></p>
		    <p>testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo </p>
	          </li>        
	          <li>
		    <strong>25/04/2009</strong>   
		    <p style="font-size:14px; font-weight: bolder; "><a href="#">Lorem blehevv vv3 vghvh dvhgv vhgvd dvhgvd dvhgvd</a></p>
		    <p>testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo </p>
	          </li>      
	          <li>
		    <strong>25/04/2009</strong>   
		    <p style="font-size:14px; font-weight: bolder; "><a href="#">Lorem blehevv vv3 vghvh dvhgv vhgvd dvhgvd dvhgvd</a></p>
		    <p>testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo </p>
	          </li>
	          <li>
		    <strong>25/04/2009</strong>   
		    <p style="font-size:14px; font-weight: bolder; "><a href="#">Lorem blehevv vv3 vghvh dvhgv vhgvd dvhgvd dvhgvd</a></p>
		    <p>testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo </p>
	          </li>        
	          <li>
		    <strong>25/04/2009</strong>   
		    <p style="font-size:14px; font-weight: bolder; "><a href="#">Lorem blehevv vv3 vghvh dvhgv vhgvd dvhgvd dvhgvd</a></p>
		    <p>testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo </p>
	          </li>      
	          <li>
		    <strong>25/04/2009</strong>   
		    <p style="font-size:14px; font-weight: bolder; "><a href="#">Lorem blehevv vv3 vghvh dvhgv vhgvd dvhgvd dvhgvd</a></p>
		    <p>testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo testo </p>
	          </li>                  
		</ul>
		<a href="/blog" class="see-all tools-container">vai al blog di OpenParlamento</a>
	      </div>	
	  </div>
	   <!-- box in evidenza dal parlamento -->
          <div class="section-box">
	      
			<h3>in evidenza dal parlamento</h3>
				<ul class="section-tab-switch float-container tools-container">
					<li class="current">disegni di legge e altri atti</li>
					<li><a href="#">votazioni</a></li>
					
				</ul>				
				<ul id="law-n-acts-proposals">
					<li class="float-container">
						<p>02/04/2009, disegno di legge al Senato di FLERES</p>

						<div class="user-votes"><span class="green thumb-up">9.677</span> <span class="red thumb-down">21.903</span></div>					
						<p><a href="singolo_atto.html"><em>C.1256</em> Conversione in legge, con modificazioni, del decreto-legge 25 giugno 2008 n. 112, recante disposizioni urgenti per lo...</a></p>
						<div class="user-comments"><a href="#">130 <strong>commenti</strong></a></div>
					</li>
					<li class="float-container">

						<p>02/04/2009, disegno di legge al Senato di FLERES</p>
						<div class="user-votes"><span class="green thumb-up">677</span> <span class="red thumb-down">903</span></div>											
						<p><a href="singolo_atto.html"><em>C.1256</em> Conversione in legge, con modificazioni, del decreto-legge 25 giugno 2008 n. 112, recante disposizioni urgenti per lo...</a></p>
						<div class="user-comments"><a href="#">1.130 <strong>commenti</strong></a></div>

					</li>
					<li class="float-container">
						<p>02/04/2009, mozione al Senato di FLERES</p>
						<div class="user-votes"><span class="green thumb-up">5.677</span> <span class="red thumb-down">1.903</span></div>																	
						<p><a href="singolo_atto.html"><em>C.1256</em> Conversione in legge, con modificazioni, del decreto-legge 25 giugno 2008 n. 112, recante disposizioni urgenti per lo...</a></p>

						<div class="user-comments"><a href="#">30 <strong>commenti</strong></a></div>
					</li>
					<li class="float-container">
						<p>02/04/2009, disegno di legge al Senato di FLERES</p>

						<div class="user-votes"><span class="green thumb-up">9.677</span> <span class="red thumb-down">21.903</span></div>					
						<p><a href="singolo_atto.html"><em>C.1256</em> Conversione in legge, con modificazioni, del decreto-legge 25 giugno 2008 n. 112, recante disposizioni urgenti per lo...</a></p>
						<div class="user-comments"><a href="#">130 <strong>commenti</strong></a></div>
					</li>
					<li class="float-container">

						<p>02/04/2009, disegno di legge al Senato di FLERES</p>
						<div class="user-votes"><span class="green thumb-up">677</span> <span class="red thumb-down">903</span></div>											
						<p><a href="singolo_atto.html"><em>C.1256</em> Conversione in legge, con modificazioni, del decreto-legge 25 giugno 2008 n. 112, recante disposizioni urgenti per lo...</a></p>
						<div class="user-comments"><a href="#">1.130 <strong>commenti</strong></a></div>

					</li>
					<li class="float-container">
						<p>02/04/2009, mozione al Senato di FLERES</p>
						<div class="user-votes"><span class="green thumb-up">5.677</span> <span class="red thumb-down">1.903</span></div>																	
						<p><a href="singolo_atto.html"><em>C.1256</em> Conversione in legge, con modificazioni, del decreto-legge 25 giugno 2008 n. 112, recante disposizioni urgenti per lo...</a></p>

						<div class="user-comments"><a href="#">30 <strong>commenti</strong></a></div>
					</li>
					
				</ul>
			</div>		
	</div>
	  
      </div>
</div>      	  