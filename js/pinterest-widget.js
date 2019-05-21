		var feedContainer = document.getElementById('pinterest_widget_feed');
		var allFeeds =  feedContainer.getElementsByClassName('feed_item');
		var pinFeedCount = parseInt(feedContainer.getAttribute('data-pin-count'));
		var feedArray = Array();
		
			if(pinFeedCount === 1){	
				var colWidth = 	'94%';
				var feedPerRow = 1;	
				allFeeds[0].style.margin = '3%';
				 
			} else if( pinFeedCount === 2 ){

				colWidth = 	'47%';
				var feedPerRow = 2;
				allFeeds[0].style.margin = '1%';
				allFeeds[1].style.margin = '1%';

			} else{
				colWidth = 	'30.5%';
				var feedPerRow = 3;
			}

		for(var i in allFeeds){
			if(i >= 0 ){
				var link = allFeeds[i].getElementsByTagName('a')[0].getAttribute('href');
				var image = allFeeds[i].getElementsByTagName('img')[0].getAttribute('src');
				var title = allFeeds[i].getAttribute('data-feed-title') ;
				allFeeds[i].innerHTML = '';
				allFeeds[i].style.width = colWidth;
				var feedLink = document.createElement('a');
					feedLink.setAttribute('class','feed_link');
					feedLink.setAttribute('href',link);
					feedLink.style.width = '100%';
					feedLink.setAttribute('target','_blank');
					feedLink.setAttribute('title',title);

				var img = document.createElement('img');
					img.setAttribute('class','feed_image');
					img.setAttribute('src',image);
					img.style.border = '1px dotted rgba(255,0,0,0.7)';
			
				feedLink.appendChild(img);	
				allFeeds[i].appendChild(feedLink);
				allFeeds[i].setAttribute('data-feed-width',colWidth);
				allFeeds[i].setAttribute("onmouseleave","this.style.zIndex='100';this.style.display='';this.style.width=this.getAttribute('data-feed-width');");
				allFeeds[i].setAttribute("onmouseover","this.style.width ='94%';this.style.zIndex='500';this.style.display='block';");
				allFeeds[i].style.display = 'inline-grid';
			}

			console.log(feedContainer.parentElement);
			feedContainer.parentElement.style.display = '';
		}
	var feedDiv = feedContainer.getElementsByClassName('feed_item')[0];;
	imagesLoaded( document.querySelector('#pinterest_widget_feed'), function( instance ) {
		var msnry = new Masonry( document.querySelector('#pinterest_widget_feed'), {
			// options
			itemSelector: '.feed_item',
			columnWidth: feedDiv.offsetWidth,
			gutter : (feedContainer.offsetWidth - ( feedDiv.offsetWidth * feedPerRow))/feedPerRow,
		  });
		  
	  });

				