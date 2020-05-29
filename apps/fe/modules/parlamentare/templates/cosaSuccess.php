<?php use_helper('Date', 'Number');
slot('canonical_link');
echo "\n<link rel=\"canonical\" href=\"" . url_for('@parlamentare?' . $parlamentare->getUrlParams(), true) . "\" />";
end_slot();
$ramo = isset($ramo) ? $ramo : '';
?>
<div class="row" id="tabs-container">
    <ul class="float-container tools-container" id="content-tabs">
        <li class="current" style="height:70px;">
            <h2><?php echo($carica ? ($ramo == 'camera' ? 'On. ' : 'Sen. ') : '') ?><?php echo $parlamentare->getNome() ?>
                &nbsp;<?php echo $parlamentare->getCognome() ?></h2></li>
    </ul>
</div>

<div class="row">

    <div class="ninecol">
        <?php include_partial(
                'secondlevelmenu',
                array(
                    'current' => 'cosa',
                    'parlamentare_id' => $parlamentare->getId(),
                    'parlamentare_slug' => $parlamentare->getSlug()
                )
        ); ?>

        <?php if ($sf_flash->has('subscription_promotion')): ?>
            <div class="flash-messages">
                <?php echo $sf_flash->get('subscription_promotion') ?>
            </div>
        <?php endif; ?>

        <div class="W100_100">
            <div class="W25_100 float-right" style="width:23%">

                <?php /*echo link_to(
                    image_tag(
                        '/images/banner-patrimoni-small.png',
                        array('alt' => 'vai al sito Patrimoni Trasparenti')
                    ),
                    'http://patrimoni.openpolis.it/#/scheda/' .
                        $parlamentare->getCognome() . '-' .
                        $parlamentare->getNome() . '/' .
                        $parlamentare->getId()
                ) */?>

                <?php echo link_to(
                    'la sua pagina su ' .
                    image_tag(
                        '/images/op_logo_small.png',
                        array('alt' => 'vai al sito openpolis')
                    ),
                    'http://politici.openpolis.it/politico/' . $parlamentare->getId(),
                    array('class' => 'jump-to-camera')
                ) ?>

                <?php if ($carica) : ?>

                    <?php if ($ramo == 'camera') : ?>
                        <?php
                            $url = "http://www.camera.it/leg18/29?tipoAttivita=&tipoVisAtt=&tipoPersona=&shadow_deputato=" .
                                $carica->getParliamentId() . "&idLegislatura=18"
                        ?>
                        <?php echo link_to(
                            'la sua pagina su ' .
                            image_tag(
                                '/images/logo-camera-deputati.png',
                                array('alt' => 'vai al sito della camera dei deputati')
                            ),
                            $url,
                            array('class' => 'jump-to-camera')
                        ) ?>

                    <?php elseif ($ramo == 'senato') : ?>

                        <?php
                            $url = "http://www.senato.it/loc/link.asp?tipodoc=sattsen&leg=18&id=" .
                                $carica->getParliamentId()
                        ?>

                        <?php echo link_to(
                            'la sua pagina su ' .
                            image_tag('/images/logo-senato.png',
                                array('alt' => 'vai al sito del senato')),
                            $url,
                            array('class' => 'jump-to-camera')
                        ) ?>
                    <?php endif ?>

                <?php endif ?>

            </div>


            <div class="W73_100 float-left" style="width:75%">
                <div class="float-container">
                    <?php echo image_tag(OppPoliticoPeer::getPictureUrl($parlamentare->getId()),
                        array('class' => 'portrait-91x126 float-left',
                            'alt' => $parlamentare->getNome() . ' ' . $parlamentare->getCognome(),
                            'width' => '91', 'height' => '126'))
                    ?>

                    <div class="politician-more-info">
                        <?php if ($carica) : ?>
                            <p>
                                <label>
                                    <?php echo ($carica->getTipoCaricaId() != 5 ? "" : "come Senatore a vita: ") ?>in
                                    carica dal <?php echo $carica->getDataInizio('d/m/Y') ?>
                                </label>
                                <span style="font-weight:normal;">(in carriera parlamentare per <a
                                        href="http://politici.openpolis.it/politico/<?php echo $parlamentare->getId() ?>#carriera"
                                        style="font-size:12px;"><?php echo $durata ?></a>)
                                </span>
                            </p>

                            <p>
                                <label>gruppo:</label>

                                <?php
								
                                    echo link_to(
                                        $acronimo_gruppo_corrente . ' (' .
                                        ucfirst(strtolower($incarico)) . ')',
                                        '@parlamentari?ramo=' . $ramo . '&filter_group=' . $id_gruppo_corrente
                                    )
                                ?>

                                <?php if (count($gruppi) > 1): ?>(<?php endif ?>

                                <?php foreach ($gruppi as $gruppo): ?>
                                    <?php if ($gruppo['data_fine'] != NULL): ?>
                                        dal <?php echo format_date($gruppo['data_inizio'], 'dd/MM/yyyy') ?>
                                        al <?php echo format_date($gruppo['data_fine'], 'dd/MM/yyyy') ?>:
                                        <?php echo link_to(
                                            $gruppo['acronimo'],
                                            '@parlamentari?ramo=' . $ramo . '&filter_group=' . $gruppo['gruppo_id']
                                        ) ?>
                                    <?php endif ?>
                                <?php endforeach ?>

                                <?php if (count($gruppi) > 1): ?>)<?php endif ?>

                                <?php if ($circoscrizione == "") : ?>
                                    <label> - Senatore a vita</label>
                                <?php else : ?>
                                    <label>- circoscrizione:</label>
                                    <?php echo link_to(
                                        $circoscrizione,
                                        '@parlamentari?ramo=' . $ramo . '&filter_const=' . $circoscrizione
                                    ) ?>
                                <?php endif ?>
                            </p>

                            <!-- INCARICHI PARLAMENTARI -->
                            <?php include_component(
                                'parlamentare', 'incarichiParlamentare',
                                array('carica_id' => $carica->getId(), 'ramo' => $ramo)
                            ); ?>
                        <?php endif; ?>

                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="threecol last">

        <div id="monitor-n-vote" style="margin-bottom:10px;">
            <h6>monitora questo politico</h6>
            <p class="tools-container"><a class="ico-help" href="#">che significa monitorare</a></p>

            <div style="display: none;" class="help-box float-container">
                <div class="inner float-container">

                    <a class="ico-close" href="#">chiudi</a><h5>che significa monitorare ?</h5>
                    <p>Registrandoti e entrando nel sito puoi attivare il monitoraggio per atti, parlamentari e
                        argomenti. Da quel momento nella tua pagina personale e nella tua email riceverai tutti gli
                        aggiornamenti riferiti agli elementi che stai monitorando.<br/>
                    </p>
                </div>
            </div>

            <!-- partial per la gestione del monitoring di questo politico -->
            <?php include_component(
                'monitoring', 'manageItem',
                array('item' => $parlamentare, 'item_type' => 'politico')
            ); ?>

            <?php include_component(
                'parlamentare', 'monitoringalso',
                array('item' => $parlamentare)
            ); ?>

        </div>
    </div>

</div>

<?php if ($carica) : ?>
    <div class="row">

        <div class="sixcol">
            <?php if (
                $carica->getDataInizio('Y-m-d') > date("Y-m-d", strtotime('today -365 days')) ||
                in_array(
                    $carica->getPoliticoId(),
                    array_merge(
                        OppPoliticoPeer::getPresidentiCamereIds(),
                        OppPoliticoPeer::getMembriGovernoIds()
                    )
                )
                 || ! ($sf_user->isAuthenticated() && $sf_user->hasCredential('amministratore'))
            ): ?>
                <!-- il box non viene proprio visualizzato -->
            <?php else: ?>

                <!-- INDICE DI PRODUTTIVITA' -->
                <h5 class="subsection-alt" style="margin-top:0px;">
                    Indice di produttività parlamentare
                </h5>

                <p class="tools-container"><a class="ico-help" href="#">come viene calcolato</a></p>

                <div style="display: none;" class="help-box float-container">
                    <div class="inner float-container">
                        <a class="ico-close" href="#">chiudi</a>

                        <h5>Che cos'&egrave; l'indice di produttivit&agrave; ?</h5>
                        <p>&Egrave; il nuovo indice che prende in esame il numero, la tipologia, il consenso e
                            l'iter degli atti presentati dai parlamentari in modo da poterli confrontare tra di loro.<br/>
                            <strong>Per la descrizione dettagliata della metodologia di valutazione
                                <a href="http://indice.openpolis.it/info.html">vai qui</a>.</strong>
                        </p>
                    </div>
                </div>

                <div class="float-container" style="padding:5px 10px 10px 20px;">
                    <label style="color:#888888; font-weight:bold; font-size:16px;">indice di produttivit&agrave;:</label>
                    <span
                        style="text-align:left; color:#4E8480;  font-weight:bold; font-size:24px;"><?php echo number_format($carica->getIndice(), 1, ',', '.') ?></span>
                </div>

                <div class="float-container" style="padding:2px 10px 10px 20px;">
                    <label style="color:#888888; font-weight:bold; font-size:16px;">classifica:</label>
                    <span style="text-align:left; color:#4E8480;  font-weight:bold; font-size:20px;">
                            <?php echo $carica->getPosizione() . "&deg;" ?>
                        </span> su <?php echo($ramo == 'camera' ? '630 deputati' : '315 senatori') ?>

                    <?php if ($carica->getDataInizio() > "2018-03-05") : ?>
                        <span style="background-color: yellow; font-weight:bold;">
                                (N.B. subentrato dal <?php echo $carica->getDataInizio('d/m/Y') ?>.)
                            </span>
                    <?php endif; ?>

                    | <?php echo link_to('vai alla classifica completa',
                        'http://indice.openpolis.it') ?>

                    <span style="font-weight:normal; padding-top:7px; float:left; text-align:left;">L'indice di produttivit&agrave;
                        non prende in considerazione il lavoro,
                             anche rilevante, che alcuni parlamentari svolgono per gli incarichi necessari al funzionamento
                             della macchina politica e amministrativa del Parlamento
                             (Commissioni, Gruppi, Comitati, Giunte, Collegi e Uffici di Camera e Senato).
                             </span>
                </div>

            <?php endif; ?>

	<!-- BOX PRESENZE -->
    <?php if ($carica->getId()!='925552') : ?>
        <h5 class="subsection-alt" style="margin-top:10px;">Presenze in <?php echo $nvotazioni ?> votazioni elettroniche</h5>
        <p class="float-right">ultima votazione: <strong>
        <?php if ($ramo=='camera') : ?>
        <?php echo format_date(OppVotazionePeer::doSelectDataUltimaVotazione('','','18','C'), 'dd/MM/yyyy') ?>
        <?php elseif($ramo=='senato') : ?>
        <?php echo format_date(OppVotazionePeer::doSelectDataUltimaVotazione('','','18','S'), 'dd/MM/yyyy') ?>
        <?php endif; ?>   
        </strong></p> 
        <p class="tools-container"><a class="ico-help" href="#">come sono calcolate</a></p>
        <div style="display: none;" class="help-box float-container">
            <div class="inner float-container">        
                <a class="ico-close" href="#">chiudi</a><h5>come sono calcolate le presenze ?</h5>
                <p>I dati sulle presenze si riferiscono alle votazioni elettroniche che si svolgono nell'Assemblea di Camera e Senato dall'inizio della legislatura. Le presenze dunque non si riferiscono a tutte le possibili attivit&agrave; parlamentari (lavori preparatori nelle Commissioni) ma solo al totale delle presenze nelle votazioni elettroniche in Aula.</p>
            </div>
        </div>
    
    <!-- usare &nbsp; invece dello spazio, e' importante per il layout  !!  -->
        <div class="meter-bar float-container">
            <div class="meter-bar-container">
                <div class="meter-label"><strong class="green"><?php echo number_format($presenze_perc, 2) ?>%</strong>&nbsp;(<?php echo number_format($presenze, 0) ?>)</div>
                <label>presenze:</label>
                <div class="green-meter-bar">
                    <div style="left: <?php echo number_format($presenze_media_perc, 2) ?>%;" class="meter-average"><label>valore medio: <?php echo number_format($presenze_media_perc, 2) ?>%</label>&nbsp;</div>
                    <div style="width: <?php echo number_format($presenze_perc, 2) ?>%;" class="meter-value">&nbsp;</div>
                </div> 
            </div>
            <div class="meter-bar-container">
                <label>assenze:</label>
                <div class="meter-label"><strong class="red"><?php echo number_format($assenze_perc, 2) ?>%</strong>&nbsp;(<?php echo number_format($assenze, 0) ?>)</div>
                <div class="red-meter-bar">
                    <div style="left: <?php echo number_format($assenze_media_perc, 2) ?>%;" class="meter-average"><label>valore medio: <?php echo number_format($assenze_media_perc,2) ?>%</label>&nbsp;</div>                                
                 <div style="width: <?php echo number_format($assenze_perc, 2) ?>%;" class="meter-value">&nbsp;</div>
                </div>
                </div>
                <div class="meter-bar-container">    
                <label>missioni:</label>
                <div class="meter-label"><strong class="blue"><?php echo number_format($missioni_perc, 2) ?>%</strong>&nbsp;(<?php echo number_format($missioni, 0) ?>)</div>
                <div class="blue-meter-bar">
                    <div style="left: <?php echo number_format($missioni_media_perc, 2) ?>%;" class="meter-average"><label>valore medio: <?php echo number_format($missioni_media_perc, 2) ?>%</label>&nbsp;</div>
                    <div style="width: <?php echo $missioni_perc ?>%;" class="meter-value">&nbsp;</div>
                </div>
                </div>    
                <p class="float-right">
                <?php echo link_to('vai alla classifica', 
                                 '@parlamentari?ramo=' . $ramo .
                                  '&sort=presenze&type=desc') ?> 
                </p>
             <span style="font-weight:normal; padding-top:5px; float:left; text-align:left;">I regolamenti non prevedono la registrazione del motivo dell'assenza al voto del parlamentare. Non si può distinguere, pertanto, l'assenza ingiustificata da quella, ad esempio, per ragioni di salute.<br/>
             Il Senato, a differenza della Camera, contempla anche il caso del "presente non votante", ovvero dei senatori presenti che non partecipano alla votazione. In questo caso openpolis da agosto 2018 considera quindi il senatore presente.</span>
            </div>
    <?php else: ?>
        <h5 class="subsection-alt" style="margin-top:10px;">Presenze nelle votazioni elettroniche</h5>
         <p>La Camera dei Deputati - a differenza del Senato della Repubblica - non pubblica i dati sulla partecipazione alle votazioni del suo Presidente. Pertanto non possiamo calcolare gli indicatori di presenza e di assenza.</p>
     <?php endif; ?> 

		

            <?php include_component('parlamentare', 'attiPresentati', array('parlamentare' => $parlamentare)) ?>
            <?php include_component('parlamentare', 'sioccupadi', array('carica' => $carica)); ?>
            <?php // include_component('parlamentare', 'firmacon',array('carica' => $carica, 'acronimo' => $acronimo_gruppo_corrente)); ?>

        </div>


        <div class="sixcol last">

            <!-- BOX ATTI POLITICO_UTENTE FAVOREVOLE -->
            <?php if ($carica && $sf_user->isAuthenticated()) {

                echo include_component('monitoring', 'userVspolitician',
                    array('user' => $sf_user,
                        'num' => 10,
                        'ambient' => 'politico',
                        'parlamentare' => $parlamentare,
                        'legislatura' => 18));

            } ?>

            <!-- box Maggioranza sotto e salva -->

            
            <h5 class="subsection-alt" style="margin-top:0px;">Il comportamento nelle votazioni</h5>
            <br/>
            <?php include_component('parlamentare', 'widgetVoti', array('carica' => $carica, 'ribelli_perc' => $ribelli_perc, 'parlamentare' => $parlamentare)) ?>
            <!-- BOX PER I VOTI CHIAVE -->
            <?php echo include_component('parlamentare', 'keyvote', array('carica' => $carica, 'ramo' => $ramo)) ?>
            <!-- FINE VOTI CHIAVE -->

            <!-- DICHIARAZIONI PATRIMONIALI -->
            <?php //echo include_component('parlamentare', 'taxDeclaration', array('parlamentare' => $parlamentare)) ?>
            <!-- FINE DICHIARAZIONI PATRIMONIALI -->

            <?php //if ($nvoti_validi > 0): ?>
                <?php //echo include_component('parlamentare', 'votacome',
                          //array('carica' => $carica,
                            //     'parlamentare' => $parlamentare,
                              //   'acronimo' => $acronimo_gruppo_corrente));
                ?>
            <?php //endif ?>

            <?php echo include_partial('news/newsbox',
                array('title' => 'Le ultime attivit&agrave; del parlamentare',

                    'all_news_url' => '@news_parlamentare?id=' . $parlamentare->getId(),
                    'news' => oppNewsPeer::getNewsForItem('OppPolitico', $parlamentare->getId(), 3),
                    'context' => 2,
                    'rss_link' => '@feed_politico?id=' . $parlamentare->getId())); ?>
            <?php if ($nvoti_validi > 0): ?>
                <?php echo include_component('parlamentare', 'comparaQuesto',
                    array('parlamentare' => $parlamentare,
                        'select2' => '',
                        'ramo' => ($carica->getTipoCaricaId() == '1' ? '1' : '2'))); ?>
            <?php endif ?>

        </div>
    </div>
<?php endif; ?>


<?php slot('breadcrumbs') ?>
<?php echo link_to("home", "@homepage") ?> /
<?php if ($carica) : ?>
    <?php if ($ramo == 'senato'): ?>
        <?php echo link_to('senatori', '@parlamentari?ramo=senato') ?> /
        Sen.
    <?php else: ?>
        <?php echo link_to('deputati', '@parlamentari?ramo=camera') ?> /
        On.
    <?php endif; ?>
<?php endif; ?>
<?php echo $parlamentare->getNome() ?>&nbsp;<?php echo $parlamentare->getCognome() ?>
<?php end_slot() ?>
