(function($) {

$(document).ready(function(){
													 
		
	// range di date
	if($.datepicker) {
		function customRange(input) { 
			return {minDate: (input.id == "endDate" ? $("#startDate").datepicker("getDate") : null), 
					maxDate: (input.id == "startDate" ? $("#endDate").datepicker("getDate") : null)}; 
		} 
		
		
		$("#startDate, #endDate").datepicker($.extend({},$.datepicker.regional["it"], { 
			beforeShow: customRange,																								
			showStatus: true, 
			showOn: "both", 
			buttonImage: "imgs/ico-calendar.png", 
			buttonImageOnly: true 
		})); 
	}

	// Ricerca disegni di legge
	$('#search-ddl-fbox').hover(
		function(){ $('#search-ddl-type').css({width: ($('#search-ddl-field').width() - 10) + 'px'}).show(); },
		function(){ $('#search-ddl-type').hide(); }		
	);
	
	$('#search-ddl-field').focus(
		function(){ var $this = $(this).removeClass('blur'); if($this.val() == $this.data('defaultLabel')) $this.val(''); }
	).blur(
		function(){	var $this = $(this).addClass('blur'); if($this.val() == '') $this.val($this.data('defaultLabel')); }
	).data('defaultLabel','cerca ' + $('#search-ddl-type').children('label.focus').text()
	).val('cerca ' + $('#search-ddl-type').children('label.focus').text());
	
	$('#search-ddl-type').children('input').click(
		function(){
			var label = $(this).siblings('label')
			.removeClass('focus')
			.attr('checked','')
			.end()
			.next()
			.addClass('focus')
			.attr('checked','checked')
			.get(0).innerHTML;
			var sf = $('#search-ddl-field');
			if(sf.data('defaultLabel') == sf.val()) {
				sf.val('cerca '+ label);
			}
			sf.data('defaultLabel','cerca '+ label);
		}
	);			

	// Visualizza/nascondi help box
	$('.ico-help').click( function(){ $(this).parent().next().toggle('fast'); return false; } );
	$('.ico-close').click( function(){ $(this).parent().parent().hide('fast'); return false; } );

	// Visualizza/nascondi liste
	$('.btn-open').click(
		function(){
			$(this).hide().next().show().click(
				function(){
					$(this).unbind().hide().prev().show();
					$(this).parent().next().hide('fast');
					return false;
				}
			);
			$(this).parent().next().show('fast').find('.btn-close').click(
				function(){
					$(this).unbind();
					$(this).parent().parent().hide('fast').parent().find('.btn-open').show().next().hide();
					return false;
					
				}
			);
			return false; 
		}
	);
	
	$('.topics-list li').click(
		function(){
			var child = $(this).find('ul');
			if(child.length) {
				$(this).toggleClass('opened');
				child.toggle();
			}
			return false;
		}
	);
	


	// mostra tasto applica al cambio filtri
	$('#disegni-decreti-filter select').change( function() { $('#disegni-decreti-filter-apply').show(); } );
	
	
	$('#disegni-decreti-order a').click(
		function(){
			var $this = $(this)
			  , isCurrent =	$this.hasClass('current');
			
			$('#disegni-decreti-order a').removeClass('ascending descending current');
			
			if( isCurrent ) {
				$this.toggleClass('ascending').toggleClass('descending');
			} else {
				$this.addClass('current ascending');
			}
		}
	);
	if($.browser.mozilla || $.browser.msie) {
		$('#disegni-decreti-filter select').combobox(
			{
				comboboxContainerClass: "comboboxContainer",
				comboboxValueContentContainerClass: "comboboxValueContainer",
				comboboxValueContentClass: "comboboxValueContent",
				comboboxDropDownClass: "comboboxDropDownContainer",
				comboboxDropDownButtonClass: "comboboxDropDownButton",
				comboboxDropDownItemClass: "comboboxItem",
				comboboxDropDownItemHoverClass: "comboboxItemHover",
				comboboxDropDownGroupItemHeaderClass: "comboboxGroupItemHeader",
				comboboxDropDownGroupItemContainerClass: "comboboxGroupItemContainer"
			},
			{
				width: 130
			},
			function() { $('#disegni-decreti-filter-apply').show(); }
		);
	}
			
	$('#identity').pngFix();
	$('.coo-mind').pngFix();	

})



})(jQuery)
