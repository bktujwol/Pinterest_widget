
					
					jQuery('li.feed_item p:last-child').remove();
					
					
					
					jQuery('ol.pinterest_feeds li.feed_item ').each( function(){
						var pinFeedCount = jQuery('ol.pinterest_feeds').attr('pinCount');

						//alert(pinFeedCount);
						
						var link = 'http://pinterest.com'+jQuery('a',this).attr('href');
						var image = jQuery('img',this).attr('src');
						var title = jQuery('span',this).html();
						
						//var title = feedTitle;
						//alert(feedTitle);
						jQuery(this).empty().append('<a id="feed_link" class="tooltip"  href="'+link+'" target="_blank"  title="'+title+'" ><img class="feed_image_'+pinFeedCount+'" src="'+image+'"/></a>');
					
					    });	//end of function each
					 
					 