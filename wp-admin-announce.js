this.adminAnnounce = function(message){
  jQuery(document).ready(function(){    
    jQuery('body').prepend(
      jQuery('<div>')
	.text(message)
	.addClass('admin-announce'));
  });
};
