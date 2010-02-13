var fHeight = parseInt(window.oc_frame_height); 
if (window.navigator.userAgent.indexOf("MSIE")) {
	fHeight = fHeight + 7;
}
document.write('<iframe name="oc_bill_status_frame" width="250" height="' + fHeight + '" scrolling="auto" frameborder="0" style="border-style: solid; border-width: 1px; border-color: #' + window.bordercolor + '" allowtransparency="true" hspace="0" vspace="0" marginheight="0" marginwidth="0" src="' + window.oc_host_url + 'widget_atto?bill_id=' + window.oc_bill_id + '&bg_color=' + window.oc_bgcolor + '&textcolor=' + window.oc_textcolor + '&pos=' +window.oc_pos + '"></iframe>');
                                                                                                                                                                                                                                                                                                                                                                  