    <?php if ($atto->getTipoAttoId()==1): ?>
	    <?php echo link_to("disegni di legge", "atto/disegnoList") ?>
    <?php endif; ?> 
    	
    <?php if ($atto->getTipoAttoId()==12): ?>
	    <?php echo link_to("decreti legge", "atto/decretoList") ?>
    <?php endif; ?> 
    
    <?php if ($atto->getTipoAttoId()==15 || $atto->getTipoAttoId()==16 || $atto->getTipoAttoId()==17): ?>
	    <?php echo link_to("decreti legislativi", "atto/decretoLegislativoList") ?>
    <?php endif; ?> 
    
    <?php if (($atto->getTipoAttoId()<12 && $atto->getTipoAttoId()!=1) || $atto->getTipoAttoId()==14): ?>
	    <?php echo link_to("atti non legislativi", "atto/attoNonLegislativoList") ?>
    <?php endif; ?> 
