    <?php if ($atto->getTipoAttoId()==1): ?>
	    <?php echo link_to("disegni di legge", "@attiDisegni") ?>
    <?php endif; ?> 
    	
    <?php if ($atto->getTipoAttoId()==12): ?>
	    <?php echo link_to("decreti legge", "atto/decretoList") ?>
    <?php endif; ?> 
    
    <?php if ($atto->getTipoAttoId()==15 || $atto->getTipoAttoId()==16 || $atto->getTipoAttoId()==17): ?>
	    <?php echo link_to("decreti legislativi", "@attiDecretiLegge") ?>
    <?php endif; ?> 
    
    <?php if (($atto->getTipoAttoId()<12 && $atto->getTipoAttoId()!=1) || $atto->getTipoAttoId()==14): ?>
	    <?php echo link_to("atti non legislativi", "@attiNonLegislativi") ?>
    <?php endif; ?> 
