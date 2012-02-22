
/* + useful methods */

/* @see http://javascript.crockford.com/remedial.html for supplant */

String.prototype.supplant = function (o) {
    return this.replace(/{([^{}]*)}/g,
        function (a, b) {
            var r = o[b];
            return typeof r === 'string' || typeof r === 'number' ? r : a;
        });
};

/* + namepsaces */
webgloo = window.webgloo || {};
webgloo.sc = webgloo.sc || {};

/* + webgloo media object */

webgloo.media = {
    images : {} ,
	debug : false,
	mode : ["image", "link"],
    init : function (mode) {

		//make a copy of mode array
		webgloo.media.mode = mode.slice(0) ;
        frm = document.forms["web-form1"];

		if(jQuery.inArray("image",webgloo.media.mode) != -1) {
			var strImagesJson = frm.images_json.value ;
			var images = JSON.parse(strImagesJson);
			for(i = 0 ;i < images.length ; i++) {
				webgloo.media.addImage(images[i]);
			}
		}

		if(jQuery.inArray("link",webgloo.media.mode) != -1) {
			var strLinksJson = frm.links_json.value ;
			var links = JSON.parse(strLinksJson);
			for(i = 0 ;i < links.length ; i++) {
				webgloo.media.addLink(links[i]);
			}
		}

    },
    attachEvents : function() {

        $("#add-link").live("click", function(event){
            event.preventDefault();
            var link = jQuery.trim($("#link-box").val());
			if( link == '' ) {return ; }
		 	
			$("#link-preview").html('<img src="/css/images/ajax_loader.gif" alt="spinner" />');	
 			var dataObj = new Object();
        	dataObj.q = link;
			//issue an ajax request
			$.ajax({
				url: '/ajax/url/extract.php' ,
				type: 'POST',
				dataType: 'json',
				data : dataObj,
				timeout: 9000,

				error: function(XMLHttpRequest, response){
					console.log(response);
					$("#link-preview").html(response);
				},
				success: function(response){
               		console.log("link preview fetched from server"); 
					webgloo.media.showLinkData(response);
				}
			}); //ajax call end

        }) ;
        
        $("a.remove-link").live("click", function(event){
            event.preventDefault(); 
            webgloo.media.removeLink($(this));
        }) ;

		$("a.remove-image").live("click", function(event){
            event.preventDefault(); 
            webgloo.media.removeImage($(this));
        }) ;
        
        $('#web-form1').submit(function() {
            webgloo.media.populateHidden();
            return true;
        });
        
    },
    imagePreviewDIV : '<div class="stackImage" id="image-{id}"><img src="/{bucket}/{storeName}" class="thumbnail-1" alt="{originalName}" width="{width}" height="{height}"/> '
        + '<div> <a class="remove-image" id="{id}" href="">Remove</a> </div> </div>',
    
    linkPreviewDIV : '<div class="previewLink"> {link} &nbsp; <a class="remove-link" href="{link}"> Remove</a> </div> ' ,
    
    populateHidden : function () {
    
        frm = document.forms["web-form1"];
        
		if(jQuery.inArray("image",webgloo.media.mode) != -1) {
			var images = new Array() ;

			$("div#image-data").find('a').each(function(index) {
				 var imageId = $(this).attr("id");
				 images.push(webgloo.media.images[imageId]);
			});

			var strImages =  JSON.stringify(images);
			frm.images_json.value = strImages ;
		}

		if(jQuery.inArray("link",webgloo.media.mode) != -1) {
			var links = new Array() ;

			$("div#link-data").find('a').each(function(index) {
				links.push($(this).attr("href"));
			});

			var strLinks = JSON.stringify(links);
			frm.links_json.value = strLinks ;
		}
        
    },
    addLink : function(linkData) {
        var buffer = webgloo.media.linkPreviewDIV.supplant({"link" : linkData});
        $("#link-data").append(buffer);
    },
    removeLink : function(linkObj) {
		$(linkObj).parent().remove();
    },

    removeImage : function(linkObj) {
		var id = $(linkObj).attr("id");
		var imageId = "#image-" +id ;
		$("#image-"+id).remove();
    },
    addImage : function(mediaVO) {
		
        webgloo.media.images[mediaVO.id] = mediaVO ;
        var buffer = webgloo.media.imagePreviewDIV.supplant(mediaVO);
        $("div#image-data").append(buffer);
    
    },
	showLinkData : function(response) {
		
		//issue :- relative URL vs. full URL
		//error - when images array is empty
		var code = response.code ;
		if(code != 1 ) {
			console.log("server error happened");
		}

		var dataObj = response.data ;
		var images = dataObj.images ;
		console.log(dataObj);

		$("#link-preview").html('');
		$("#link-preview").append(dataObj.title);
		$("#link-preview").append('<img src="' +  images[0] + '" />');

	}
}


webgloo.addDebug = function(message) {
    $("#js-debug").append(message);
    $("#js-debug").append("<br>");
    console.log(message);
  
};

webgloo.clearDebug = function(message) {
    $("#js-debug").html("");
};

