<!--  Main Footer -->
<footer class="container">
    <section class="row" id="global-navigation">            
        <nav class="threecol">
            <h3>L'Associazione Openpolis</h3>
            <ul>
                <li><a href="http://www.openpolis.it/chi-siamo/">Chi siamo e cosa facciamo</a></li>
		<li><a href="http://www.openpolis.it/statuto/">Statuto</a></li>
                <!-- <li><a href="http://www.openpolis.it/faq">FAQ</a></li> -->
            </ul>
            <h3>Sostienici</h3>
            <ul>
                <li><a href="http://www.openpolis.it/sostienici/">Diventa socio</a></li>
                <li><a href="http://www.openpolis.it/sostienici/dona/">Fai una donazione</a></li>
                <li><a href="http://www.openpolis.it/sostienici/collabora/">Collabora con noi</a></li>
            </ul>
        </nav>
        <nav class="threecol">
            <h3>Open parlamento</h3>
            <ul>
                <li><?php echo link_to('Il progetto','@progetto'); ?></li>
                <li><?php echo link_to('FAQ','@faq'); ?></li>
                <li><?php echo link_to('Servizi premium','@sottoscrizioni_pro'); ?></li>
                <li><?php echo link_to('Regolamento','@static_page?action=regolamento'); ?></li>
                <li><?php echo link_to('Condizioni d\'uso','@static_page?action=condizioni'); ?></li>
                <li><?php echo link_to('Informativa sui dati personali','@static_page?action=informativa'); ?></li>
                <li><?php echo link_to('RSS/XML','@static_page?action=rssxml'); ?></li>
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
            <h4>Associazione Openpolis</h4>
            <p>via Merulana 19 - 00185 Roma<br />
                T. 06.83608392 <span class="email-nascosta">associazione[chioccia]openpolis[punto]it</span> <br /> 
                C.I. 97532050586
            </p>
            <a href="http://www.facebook.com/openpolis"><span class="icon facebook">Facebook</span></a>
            <a href="http://feeds.feedburner.com/openpolis"><span class="icon feed">Feed RSS</span></a>
            <a href="http://twitter.com/openpolis"><span class="icon twitter">Twitter</span></a>
        </section>            
    </section>


    <nav id="sub-footer" class="row">
        <ul class="twelvecol">
<li><a href="http://www.openpolis.it"><img src="/img/footers/openpolis.png" alt="Sito dell'associazione OpenPolis" title="Associazione Openpolis" /></a></li>
        <li><a href="http://parlamento.openpolis.it"><img src="/img/footers/openparlamento.png" alt="Open Parlamento" title="Open Parlamento" /></a></li>
        <li><a href="http://politici.openpolis.it"><img src="/img/footers/openpolitici.png" alt="Open politici" title="Open politici" /></a></li>
        <li><a href="http://voisietequi.openpolis.it"><img src="/img/footers/voisietequi.png" alt="Voi Siete Qui" title="Voi Siete Qui" /></a></li>
        <li><a href="http://www.openbilanci.it/"><img src="/img/footers/openbilanci.png" alt="Open Bilanci" title="Open Bilanci" /></a></li>
        </ul>            
    </nav>

</footer>
<script type="text/javascript">
    jQuery('.email-nascosta').each(function(){ jQuery(this).text(jQuery(this).text().replace('[chioccia]', '@').replace('[punto]','.')); });
</script>
<!--  /Main Footer -->
