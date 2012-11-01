/**
 * @fileOverview This file is required by the Omeka theme 'Forbes' in order to
 * provide the AJAX version of its items browse page. It provides for infinite
 * scrolling and a gallery with left and right justified thumbnails.
 * 
 * @author Benjamin Kalish
 * @version 0.1
 * @requires the jQuery Framework
 */

/** @namespace */
var Forbes = Forbes || {}

/**
 * @class The Gallery class
 * @param {Object} args All arguments to the constructor are passed as
 *        properties of this Object
 * @param {string} args.galleryDiv A selector returning the div (or other
 *        element) which where the gallery will be displayed. Note that this 
 *        element will be emptied before use!
 * @param {string} args.loadingIndicatorURI The URI of an image (normally an
          animated GIF) used to indicate a pending AJAX request.
 * @param {string} args.requestURI The request URI with _PAGE_ in place of the
 *        page number.
 * @param {string} args.scrollContainer A selector returning a scrollable
 *        element containing args.GalleryDiv. This may be 'window' or any other
 *        scrollable element.
 */
Forbes.Gallery = function (args) {
    // Params
    var galleryDiv = jQuery(args.galleryDiv);
    var loadingIndicatorURI = args.loadingIndicatorURI;
    var requestURI = args.requestURI;
    var scrollContainer = jQuery(args.scrollContainer);
    
    // Public Data
    this.allItems = [];          // holds json data on all the items shown
    this.complete = false;       // True if no more data to be loaded
    this.incompleteRow = [];
    this.queue = jQuery({});
    
    // Public Function Declarations (functions defined below)
	this.addRowToDOM = addRowToDOM;
	this.buildRows = buildRows;
	this.fetchMoreItems = fetchMoreItems;
	this.isWorking = isWorking;
	this.layoutItems = layoutItems;
	this.resize = resize;

    // Local Variables
    var self = this; // use self instead of this when we need to refer to this Gallery in closures
    var lastPage = 0;           // The number of the last results page loaded
    var targetHeight = 0;
    var margins = 6;            // six pixels between images
	var galleryWidth = galleryDiv.width();
	var galleryHeight = scrollContainer.height();
    var galleryRowStyle = jQuery('<style></style>').appendTo('head');
    			
	// Initialization
	galleryDiv.children().remove();    
    initProgressIndicator()
    jQuery(window).resize(resizeHandler);
    scrollContainer.scroll(scrollHandler);
    
    // Function Definitions
	function resizeHandler() {
		if (resizeHandler.timeout || self.isWorking()) { clearTimeout(resizeHandler.timeout); }
		resizeHandler.timeout = setTimeout(timeoutCallback, 200);
		
		function timeoutCallback() {
		    self.resize();
		}
	}    

	 function scrollHandler(event) {
		if (self.complete) return;
		    if (scrollContainer[0] === window) {
		        var innerHeight = jQuery(document).height();
		    } else {
		        var innerHeight = scrollContainer.prop('scrollHeight');
		    }
		if (innerHeight - scrollContainer.scrollTop() <= scrollContainer.height() + 100) {
			clearTimeout(scrollHandler.timeout);
			scrollHandler.timeout = setTimeout(timeoutCallback, 200);
		}
		
		function timeoutCallback() {
		    if (self.isWorking()) {
		        clearTimeout(scrollHandler.timeout);
		        scrollHandler.timeout = setTimeout(timeoutCallback, 200);
		        return;
		    }
		    if (!self.complete) {
		        self.layoutItems();
		    }
		}
	}

    function initProgressIndicator() {
		var progressImg = jQuery('<img/>');
		progressImg.attr({
		    'src':    loadingIndicatorURI,
		    'width':  '66',
	        'height': '66'
	        });
		progressImg.css({
		    'vertical-align': 'middle',
		    'margin':         '1em'
		    });

		var progressIndicator = jQuery('<div></div>');
		progressIndicator.attr('id', 'progressIndicator');
		progressIndicator.append('loading');
		progressIndicator.append(progressImg);
		progressIndicator.insertAfter(galleryDiv);
		progressIndicator.css({
		    'text-align': 'center',
		    'width':      '100%',
		    'height': '100%'
		    });
		progressIndicator.hide();
		
		progressIndicator.ajaxStart(showIndicator);
		
		progressIndicator.ajaxStop(hideIndicator);
		
		function showIndicator() {
			progressIndicator.show();
			// reset src attr to force animation
			progressIndicator.attr('src', loadingIndicatorURI);
		}
		
		function hideIndicator() {
		    progressIndicator.hide();
		}
    }
    
	function layoutItems() {
	    self.queue.queue(queueCallback);
	    
	    function queueCallback() {
    		targetHeight = galleryDiv.height() + galleryHeight;
	    	self.fetchMoreItems();
	    	self.queue.dequeue();
	    }
	}
	
	function isWorking() {
	    return (self.queue.queue().length > 0);
	}
	
	function resize() {
    	self.queue.queue(queueCallback);
    	
    	function queueCallback() {
			galleryWidth = galleryDiv.width();
			galleryHeight = scrollContainer.height();
			targetHeight = galleryDiv.height() + galleryHeight;
			self.incompleteRow = [];
			galleryDiv.children().remove();
			var itemsQueue = self.allItems.slice(0); // clone array
			self.buildRows(itemsQueue);
			self.queue.dequeue();
		}
	}

	function fetchMoreItems() {
		if (targetHeight < galleryDiv.height()) { return; }
		lastPage = lastPage + 1; // increment page count
		var request = requestURI.replace('_PAGE_', lastPage);
		self.queue.queue(queueCallback);
		
		function queueCallback() {
			jQuery.getJSON(request)
			    .success(getJSONSuccessCallback)
			// dequeue in getJSONCallback
		}
		
		function getJSONSuccessCallback(items) {
			if (!items) {
				if (self.incompleteRow) self.addRowToDOM(self.incompleteRow);
				self.incompleteRow = null;
				self.complete = true;
			} else {
				self.allItems = self.allItems.concat(items);
				self.buildRows(items);
			}
			self.queue.dequeue();
		}
	}
	
	// note that items are removed from items[]!
	function buildRows(items) {
		while (items.length > 0) {
			buildRow(items);
		}
		if (self.complete) {
	        addRowToDOM(self.incompleteRow);
	    } else {
    		self.fetchMoreItems();
    	}
	}
	
	// note that items are removed from items[]!
	function buildRow(items) {
		var row = self.incompleteRow || [];
		var rawLength = 0;
		var delta = 0;
		
		for (var i = 0; i < row.length; i++) {
			rawLength += row[i].width + margins;
		}
		
		while (items.length > 0 && rawLength < galleryWidth) {
			var item = items.shift();
			row.push(item);
			rawLength += item.width + margins;
		}
		
		// calculate how far we have gone over the width
		delta = rawLength - galleryWidth;
		
		if (delta > 0) {
			// distribute delta
			var averageDelta = Math.floor(delta / row.length);
			for (var i = 0; i < row.length; i++) {
				row[i].trimBy = averageDelta;
				delta = delta - averageDelta;
			}
			for (var i = 0; i < row.length; i++) {
				if (delta==0) break;
				row[i].trimBy += 1;
				delta -= 1;
			}
			addRowToDOM(row);
			self.incompleteRow = [];
		} else {
			self.incompleteRow = row;
		}
	}
	
	function addRowToDOM(row) {
		var container = jQuery('<div></div>');
        container.css({
             'clear': 'both',
		     'width': galleryWidth + 'px',
		     'min-width': galleryWidth + 'px',
		     'max-width': galleryWidth + 'px',
		     'overflow': 'hidden'
		     });
    
		container.addClass('gallery-row');
		for (var i = 0; i < row.length; i++) {
			var imgDiv = jQuery('<div></div>');
			imgDiv.css({
			    'margin': margins / 2 + 'px',
			    'width': (row[i].width - row[i].trimBy) + 'px',
			    'height': row[i].height + 'px',
			    'overflow': 'hidden',
			    'display': 'inline-block',
    		    'background-color': 'LightGrey'
			    });
				
			var link = jQuery('<a></a>');
			link.attr('href', row[i].itemUrl);
				
			var img = jQuery('<img/>');
			img.attr({
			   'src': row[i].thumbUrl,
			   'title': row[i].title
			   });
			img.css('width', row[i].width + 'px');
			img.css('height', row[i].height + 'px');
			img.css('margin-left', - Math.floor(row[i].trimBy / 2) + 'px');
	
			link.append(img)
			imgDiv.append(link);
			container.append(imgDiv);
		}
		galleryDiv.append(container);
	}
}

Forbes.Gallery.prototype.toString = function () {
    return '[object Forbes.Gallery]';
}
