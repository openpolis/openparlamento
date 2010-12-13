jQuery(document).ready(function(){
  var popupStatus = 0;

  //loading popup with jQuery magic!
  function loadPopup(page_url){
    //loads popup only if it is disabled
    if(popupStatus==0){
      jQuery("#backgroundPopup").css({
        "opacity": "0.7"
      });
      jQuery("#backgroundPopup").fadeIn("slow");
      jQuery("#popupContent").fadeIn("slow");
      jQuery("#contentArea").attr("src", page_url);
      popupStatus = 1;
    }
  }

  //disabling popup with jQuery magic!
  function disablePopup(){
    //disables popup only if it is enabled
    if(popupStatus==1){
      jQuery("#backgroundPopup").fadeOut("slow");
      jQuery("#popupContent").fadeOut("slow");
      popupStatus = 0;
    }
  }    

  //centering popup
  function centerPopup(){
    //request data for centering
    var windowWidth = document.documentElement.clientWidth;
    var windowHeight = document.documentElement.clientHeight;
    var popupHeight = jQuery("#popupContent").height();
    var popupWidth = jQuery("#popupContent").width();
    //centering
    jQuery("#popupContent").css({
      "position": "fixed",
      "top": windowHeight/2-popupHeight/2,
      "left": windowWidth/2-popupWidth/2
    });
    //only need force for IE6

    jQuery("#backgroundPopup").css({
      "height": windowHeight
    });

  }

  jQuery('a.external-url-container').click(function(){
		var page_url = jQuery(this).attr('href');
	  centerPopup();
		loadPopup(page_url);
		return false;
  });

  //Click out event!  
  jQuery("#backgroundPopup").click(function(){  
    disablePopup();  
  });  

  jQuery("#popupContentClose").click(function(){
    disablePopup();
    return false;
  });

  jQuery(".clickable").click(function(){
    if(jQuery(this).css('background-color') != 'rgb(255, 238, 238)')
    {
      jQuery(this).css({
        "background-color": "#ffeeee"
      });        
    } else {
      if(jQuery(this).attr('class') == 'clickable even')
        jQuery(this).css('background-color', '#ffffff');
      else
        jQuery(this).css('background-color', '#fafafa');
    }
  });

  //Press Escape event!  
  jQuery(document).keypress(function(e){  
    if(e.keyCode==27 && popupStatus==1){  
      disablePopup();  
    }
  });


  // behavior per gestire richieste ajax al click su link
  function bind_voting_behavior(scope){
    jQuery('a', scope).click(function(e){
      e.preventDefault();

      var table_row = jQuery(this).parents('tr');
      var user_stats_col = table_row.find('.user-stats-column');
      var user_vote_col = table_row.find('.user-vote-column');
      var token = user_stats_col.find('div').attr('id');

      // send request
      jQuery.get(jQuery(this).attr('href'), function(data) {
        user_vote_col.html(data);
        bind_voting_behavior(user_vote_col);
        user_stats_col.load("/deppVoting/votingDetails?type=small&token="+token);
      });

    });
  };

  // associazine del behavior ai link della colonna dei voti
  bind_voting_behavior(jQuery('.user-vote-column'));

  // Setup the ajax indicator
  jQuery('body').append('<div id="ajaxBusy"><p><img src="/images/loading.gif"></p></div>');

  jQuery('#ajaxBusy').css({
    display:"none",
    margin:"0px",
    paddingLeft:"0px",
    paddingRight:"0px",
    paddingTop:"0px",
    paddingBottom:"0px",
    position:"fixed",
    left:"50%",
    top:"50%",
     width:"auto"
  });

  // Ajax activity indicator bound to ajax start/stop document events
  jQuery(document).ajaxStart(function(){ 
    jQuery('#ajaxBusy').show(); 
  }).ajaxStop(function(){ 
    jQuery('#ajaxBusy').hide();
  });

});

