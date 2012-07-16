jQuery(document).ready(function(e) {
	
	Shadowbox.init();
	
	if(jQuery('.checkavet_rating_stars').length)
	{
		var $this, form, img;
		
		jQuery('.star').click(function(e)
		{	
			
			var rating = $this.index()+1;
			var table = form.find('input[name="table"]').val();
			var id = form.find('input[name="item_id"]').val();
			
			//alert($this.index()+1);
			//form.find('input[name="user_rating"]').val($this.index()+1);
			//form.submit();
			Shadowbox.open({
		        content: 'index.php?option=com_checkavet&view=rate&user_rating='+rating+'&item_id='+id+'&table='+table,
		        player: 'iframe',
		        width: 520,
		        height: 440,
		        options:	{
		        	modal: true
		        }
		    });
			
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
	}

});