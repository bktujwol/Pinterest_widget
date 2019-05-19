'user strict';

class pinterestWidget{

	constructor(){
		
		this.removeWhiteSpaces(this.setUpFeeds());
	}
	
	
	setUpFeeds(){
		
		var allFeeds =  document.getElementById('pinterest_widget_feed').getElementsByClassName('feed_item');
		var pinFeedCount = document.getElementById('pinterest_widget_feed').getAttribute('data-pin-count');
		var feedArray = Array();
	
		switch(pinFeedCount){
			case "1":
					var colWidth = 	'98%';
					break;
			case "2":	
					var colWidth = 	'49%';
					break;	
		  case "3":
					var colWidth = 	'32.3%';
			default:
					var colWidth = 	'32.3%';					
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
					img.style.width = '100%';
					img.style.border = '1px solid rgba(255,0,0,0.7)';

				 feedLink.appendChild(img);	
				allFeeds[i].appendChild(feedLink);
				allFeeds[i].style.display = 'inline-grid';

				feedArray.push(allFeeds[i]);
			}
			
		}

		return feedArray;
	}

	 removeWhiteSpaces(feedArray){

		
	 }
	}

	new  pinterestWidget();