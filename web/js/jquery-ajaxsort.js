function ajax_call( klass, callback )
{
	jQuery("." + klass).click(function(e) {
		e.preventDefault();
		$.get( jQuery(this).attr('href'), callback );
		
	});
}


ajax_call( 'remove-vote', function(result) {
	// rimuove la riga del voto in caso di successo	
});

ajax_call( 'moveup-vote', function(result) {
	// sostituisce la riga con quella sopra	
});

ajax_call( 'movedown-vote', function(result) {
	// sostituisce la riga con quella sotto
});