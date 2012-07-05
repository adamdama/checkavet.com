jQuery(document).ready(function(e) {
	
	var $this, form, img;
	
	jQuery('.star').click(function(e)
	{		
		//alert($this.index()+1);
		form.find('input[name="user_rating"]').val($this.index()+1);
		form.submit();
	})
	.mouseover(function(e)
	{
		$this = jQuery(this);
		form = jQuery(this).parents('form');
		img = $this.prevAll().children(':first-child').add($this.children(':first-child'));
		img.attr('src', img.attr('src').replace('blank_', ''));
	})
	.mouseout(function(e)
	{
		var src, str = '';
		src = img.attr('src').split('/');
		
		while(src.length > 1)
			str +=	src.shift() + '/';
						
		str += 'blank_' + src.shift();
		img.attr('src', str);
	});

});