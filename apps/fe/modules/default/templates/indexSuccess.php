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
		<a class="section-box-rss" href="#"><img alt="rss" src="images/ico-rss.png"/></a>
		<h3>i deputati pi&ugrave; <span style="color:red">assenti</span></h3>
		<table class="disegni-decreti column-table">
		<tbody>		  
                 <tr class="even">
                  <th scope="row">
                    <p class="politician-id">
                    <img width="40" height="53" src="/images/parlamentari/thumb/332669.jpeg" alt="4573" />	
                      <a href="/parlamentare/4573">Giancarlo ABELLI</a> (PdL)
	               </p>
                   </th>
                   <td>
                     <b>86</b>% <br /><span class="small">(2626 su 3041 votazioni)</span>
                   </td>

                  </tr>
                  <tr class="odd">
                  <th scope="row">
                    <p class="politician-id">
                    <img width="40" height="53" src="/images/parlamentari/thumb/332669.jpeg" alt="4573" />	
                      <a href="/parlamentare/4573">Rosa Maria VILLECCO CALIPARI</a> (PD)
	               </p>
                   </th>
                   <td>
                     <b>86</b>% <br /><span class="small">(2626 su 3041 votazioni)</span>
                   </td>
                  </tr>
                  <tr class="even">
                  <th scope="row">
                    <p class="politician-id">
                    <img width="40" height="53" src="/images/parlamentari/thumb/332669.jpeg" alt="4573" />	
                      <a href="/parlamentare/4573">Giancarlo ABELLI</a> (PdL)
	               </p>
                   </th>
                   <td>
                     <b>86</b>% <br /><span class="small">(2626 su 3041 votazioni)</span>
                   </td>
                  </tr>
                   <th scope="row">
                    
                   </th>
                   <td>
                     <a href="#"><strong>vai alla classifica</strong></a>
                   </td>
                  </tr>
                </tbody>
                </table>    
	      <div class="clear-both"></div>
	    </div>
            <!-- Box news dal parlamento -->
            <div class="section-box">   
		<a class="section-box-rss" href="#"><img alt="rss" src="images/ico-rss.png"/></a>
		<h3>le ultime dal parlamento</h3>
		<ul>
		  <li class="float-container">
						<div class="date">04-10-2008</div>
						<div class="ico-type float-left"><img src="images/ico-type-votazione.png" alt=" " /></div>
						<p>votazione, alla <a href="#">Camera</a></p>					
						<p><a href="singolo_atto.html"><em>C.1256</em> Conversione in legge, con modificazioni, del decreto-legge 25 giugno 2008 n. 112, recante disposizioni urgenti per lo...</a></p>

					</li>
					<li class="float-container">
						<div class="date">29-09-2008</div>
						<div class="ico-type float-left"><img src="images/ico-type-votazione.png" alt=" " /></div>
						<p>votazione, alla <a href="#">Camera</a></p>					
						<p><a href="singolo_atto.html"><em>C.1256</em> Conversione in legge, con modificazioni, del decreto-legge 25 giugno 2008 n. 112, recante disposizioni urgenti per lo...</a></p>					
					</li>

					<li class="float-container">
						<div class="date">28-09-2008</div>
						<div class="ico-type float-left"><img src="images/ico-type-proposta.png" alt=" " /></div>
						<p>votazione, alla <a href="#">Camera</a></p>					
						<p><a href="singolo_atto.html"><em>C.1256</em> Conversione in legge, con modificazioni, del decreto-legge 25 giugno 2008 n. 112, recante disposizioni urgenti per lo...</a></p>					
					</li>
					<li class="float-container">

						<div class="date">19-09-2008</div>
						<div class="ico-type float-left"><img src="images/ico-type-approvato.png" alt=" " /></div>
						<p>votazione, alla <a href="#">Camera</a></p>					
						<p><a href="singolo_atto.html"><em>C.1256</em> Conversione in legge, con modificazioni, del decreto-legge 25 giugno 2008 n. 112, recante disposizioni urgenti per lo...</a></p>					
					</li>
					

		  </ul>
		  <div class="section-box-scroller tools-container has-next">
		       <a href="#" class="see-all"><strong>vedi tutta la cronologia</strong></a>
		  </div>
	      <div class="clear-both"></div>
	    </div>
	    <!-- Box attivita' utenti -->
            <div class="section-box">   
		<a class="section-box-rss" href="#"><img alt="rss" src="images/ico-rss.png"/></a>
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
		       <a href="#" class="see-all"><strong>vedi tutta la cronologia</strong></a>
		  </div> 
	      <div class="clear-both"></div>
	    </div>
         
            
	 </div>     
          
           <!-- in evidenza dal blog -->
          <div class="W52_100 float-left"> 
          <div class="section-box"  style="padding-bottom:20px;">
             <a class="section-box-rss" href="#"><img alt="rss" src="images/ico-rss.png"/></a>
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
		<a href="/news_attiDisegni" class="see-all tools-container">vai al blog di OpenParlamento</a>
	      </div>	
	  </div>
	   <!-- box in evidenza dal parlamento -->
          <div class="section-box">
	      <a href="#" class="section-box-rss"><img src="images/ico-rss.png" alt="RSS" /></a>
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