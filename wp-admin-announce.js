this.adminAnnounce = function(message){
  jQuery(document).ready(function(){    
    console.log('admin announcing:', message);
    jQuery('body').prepend(
      jQuery('<div>')
	.text(message)
	.addClass('admin-announce'));
  });
};
