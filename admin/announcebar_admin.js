/*-- Admin Script
------------------------------------------*/
jQuery(document).ready(function(){
	jQuery('#announcebar_admin .handlediv,.hndle').click(function(){
		jQuery(this).parent().find('.inside').slideToggle("fast");
	});
	
	if (jQuery("#announcebar_admin").length){
		jQuery('.announcebar_colorScheme').farbtastic('#announcebar_colorScheme');
		jQuery('.announcebar_linkbg').farbtastic('#announcebar_linkbg');
		jQuery('.announcebar_txtclr').farbtastic('#announcebar_txtclr');
		jQuery('.announcebar_linktxtclr').farbtastic('#announcebar_linktxtclr');
	}
	jQuery('html').click(function() {jQuery("#announcebar_admin .farbtastic").fadeOut('fast');});
	
	jQuery('#announcebar_admin .announcebar_colsel').click(function(event){
		jQuery("#announcebar_admin .farbtastic").hide();
		jQuery(this).find(".farbtastic").fadeIn('fast');event.stopPropagation();
	});
	
	jQuery('.nbarlite-wrapper #mce-EMAIL').focus(function(){
		jQuery(this).css({'border-color':'#777','color':'#000','background':'transparent'});
	});
	
});

function nbar_wp_jsvalid(){
	var reg= /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	var a  = document.getElementById('mce-EMAIL').value;
	if( a == ""){
		jQuery('#mce-EMAIL').css({'border-color':'red','color':'red'});
		return false;
	}else{
		if(reg.test(a)==false){
			jQuery('#mce-EMAIL').css({'border-color':'red','color':'red','background':'#F7DAD9'});
			return false;
		}	
	}		
	return true;
}
	
	
