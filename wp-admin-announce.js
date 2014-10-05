this.adminAnnounce = function(config){
  jQuery(document).ready(function(){
    jQuery('body').prepend(
      jQuery('<div>')
	.text(config.message)
	.addClass('admin-announce')
	.css({
	  'background-color' : config.colors.background,
	  'border-color' : config.colors.border,
	  'color' : config.colors.text
	}));
  });
};
