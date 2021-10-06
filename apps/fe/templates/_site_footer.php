<!--  Main Footer -->
<footer class="container">
    <section class="row" id="global-navigation">            
        <nav class="threecol">
            <h3>Fondazione Openpolis</h3>
            <ul>
                <li><a href="http://www.openpolis.it/fondazione/">Perché. Cosa. Come.</a></li>
                <li><a href="http://www.openpolis.it/fondazione/chi-siamo">Chi siamo</a></li>
                <li><a href="http://www.openpolis.it/fondazione/documentazione">Statuto e bilanci</a></li>
                <li><a href="http://www.openpolis.it/fondazione/sostienici/dona/">Fai una donazione</a></li>
            </ul>
        </nav>
        <nav class="threecol">
            <h3>Open parlamento</h3>
            <ul>
                <li><?php echo link_to('Il progetto','@progetto'); ?></li>
                <li><?php echo link_to('FAQ','@faq'); ?></li>
                <li><?php echo link_to('Regolamento','@static_page?action=regolamento'); ?></li>
                <li><?php echo link_to('Condizioni d\'uso','@static_page?action=condizioni'); ?></li>
                <li><?php echo link_to('Informativa sui dati personali','https://www.openpolis.it/privacy-policy/'); ?></li>
				<li><a href="https://parlamento17.openpolis.it/">Legislatura XVII (2013-2018)</a></li>
				<li><a href="https://parlamento16.openpolis.it/">Legislatura XVI (2008-2013)</a></li>
            </ul>
        </nav>
        <section class="threecol">
            <h3>Software Libero</h3>
            <ul>
                <li><a href="http://github.com/openpolis/openparlamento">Codice sorgente</a></li>
                <li><a href="http://www.gnu.org/copyleft/gpl.html">Licenza GNU/GPL</a></li>
            </ul>
            <div class="clearfix"></div>
        </section>
        <section class="threecol last">
            <h3>Restiamo in contatto</h3>	
            <p>Per segnalazioni, suggerimenti, lamentele ma anche incoraggiamenti:</p>
            <h4>Fondazione Openpolis</h4>
            <p>via Merulana 19 - 00185 Roma<br />
                T. 06.83608392 <span class="email-nascosta">fondazione[chioccia]openpolis[punto]it</span> <br /> 
                C.F. 97954040586
            </p>
            <a href="http://www.facebook.com/openpolis"><span class="icon facebook">Facebook</span></a>
            <a href="http://feeds.feedburner.com/openpolis"><span class="icon feed">Feed RSS</span></a>
            <a href="http://twitter.com/openpolis"><span class="icon twitter">Twitter</span></a>
        </section>            
    </section>


    <nav id="sub-footer" class="row">
        <ul class="twelvecol">
<li><a href="http://www.openpolis.it"><img src="/img/footers/op_logo_footer.png" alt="Sito della Fondazione Openpolis" title="Fondazione Openpolis" width="103" height="23" /></a></li>
        <li><a href="http://parlamento.openpolis.it"><img src="/img/footers/openparlamento.png" alt="Open Parlamento" title="Open Parlamento" width="127" height="23" /></a></li>
        <li><a href="http://politici.openpolis.it"><img src="/img/footers/openpolitici.png" alt="Open politici" title="Open politici" width="101" height="23" /></a></li>
        <li><a href="http://voisietequi.openpolis.it"><img src="/img/footers/voisietequi.png" alt="Voi Siete Qui" title="Voi Siete Qui" width="95" height="23" /></a></li>
        <li><a href="http://www.openbilanci.it/"><img src="/img/footers/openbilanci.png" alt="Open Bilanci" title="Open Bilanci" width="101" height="23" /></a></li>
        </ul>            
    </nav>

</footer>
<script type="text/javascript">
    jQuery('.email-nascosta').each(function(){ jQuery(this).text(jQuery(this).text().replace('[chioccia]', '@').replace('[punto]','.')); });
</script>
<!--  /Main Footer -->
