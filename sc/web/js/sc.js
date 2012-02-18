
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

/* +webgloo sc answer object */

webgloo.sc.answer = {
	debug : false,
	 linkPreviewDIV : '<div class="previewLink"> {link} &nbsp; '
		+ ' <a class="remove-link" href="{link}"> Remove</a> </div> ' ,
	 
	init : function() {
		frm = document.forms["web-form1"];
		
		var strLinksJson = frm.links_json.value ;
        var links = JSON.parse(strLinksJson);
        for(i = 0 ;i < links.length ; i++) {
            webgloo.sc.answer.addLink(links[i]);
        }
	},
	attachEvents : function() {
		$("a#open-link").live("click", function(event){
            event.preventDefault();
            $("#link-container").slideDown("slow");
        }) ;
		
		$("#add-link").live("click", function(event){
            event.preventDefault();
            var linkData = jQuery.trim($("#link-box").val());
			
			if( linkData == '' ) {
				return ;
			} else {
				webgloo.sc.answer.addLink(linkData);
			}
			
        }) ;
        
        $("a.remove-link").live("click", function(event){
            event.preventDefault(); 
            webgloo.sc.answer.removeLink($(this));
        }) ;
		
		$('#web-form1').submit(function() {
            webgloo.sc.answer.populateHidden();
            return true;
        });
		 
	},
	
    populateHidden : function () {
    
        var links = new Array() ;
        
        $("div#link-data").find('a').each(function(index) {
            links.push($(this).attr("href"));
        });
        
        frm = document.forms["web-form1"];
        
        var strLinks = JSON.stringify(links);
        frm.links_json.value = strLinks ;
        
    },
    addLink : function(linkData) {
		//issue an ajax request
		// get html back
		// append this html
		
        var buffer = webgloo.sc.answer.linkPreviewDIV.supplant({"link" : linkData});
        $("#link-data").append(buffer);
    },
    removeLink : function(linkObj) {
        $(linkObj).parent().remove();
    }
	
}

/* + webgloo sc question object */

webgloo.sc.question = {
    images : {} ,
	debug : false,
	numSelected : 0 ,
	flashLoaded : false,
	uploadError : false ,
    init : function () {
        webgloo.sc.question.images = {} ;
        webgloo.sc.question.flashLoaded = false ;
        //read from document
		//@todo - right now we assume that both form elements
		// are on page
        frm = document.forms["web-form1"];
        var strImagesJson = frm.images_json.value ;
        
        
        var images = JSON.parse(strImagesJson);
        for(i = 0 ;i < images.length ; i++) {
            webgloo.sc.question.addImage(images[i]);
        }

		var strLinksJson = frm.links_json.value ;
        var links = JSON.parse(strLinksJson);
        for(i = 0 ;i < links.length ; i++) {
            webgloo.sc.question.addLink(links[i]);
        }
    },
    attachEvents : function() {
  
        $("a#open-link").live("click", function(event){
            event.preventDefault();
            //make the container visible before scrolling to it
            $("#image-container").slideUp("slow");
            $("#link-container").slideDown("slow");
            $(window).scrollTop($("#link-container").position().top) ;
        }) ;
        
        $("a#open-image").live("click", function(event){
            event.preventDefault();
			webgloo.sc.question.openImageContainer();
        }) ;
        
		$("a#close-image").live("click", function(event){
            event.preventDefault();
            $("#image-container").slideUp("slow");
        }) ;
		
		$("a#close-link").live("click", function(event){
            event.preventDefault();
            $("#link-container").slideUp("slow");
        }) ;
		
        $("#add-link").live("click", function(event){
            event.preventDefault();
            var linkData = jQuery.trim($("#link-box").val());
			
			if( linkData == '' ) {
				return ;
			} else {
				webgloo.sc.question.addLink(linkData);
			}
            $("#link-container").slideUp("slow");
        }) ;
        
        $("a.remove-link").live("click", function(event){
            event.preventDefault(); 
            webgloo.sc.question.removeLink($(this));
        }) ;
        
         $("a.remove-image").live("click", function(event){
            event.preventDefault(); 
            webgloo.sc.question.removeImage($(this));
        }) ;
         
        $("#add-image").live("click", function(event){
            event.preventDefault();
            webgloo.sc.question.addImage();
        }) ;
        
        $('#web-form1').submit(function() {
            webgloo.sc.question.populateHidden();
            return true;
        });
        
        
    },
    imagePreviewDIV : '<div class="previewImage" id="image-{id}"><img src="/{bucket}/{storeName}" class="resize" alt="{originalName}" width="{width}" height="{height}"/> '
        + '<div class="previewImageAction"> <a id="{id}" class="remove-image" href="" > Remove </a> </div> </div>',
    
    linkPreviewDIV : '<div class="previewLink"> {link} &nbsp; <a class="remove-link" href="{link}"> Remove</a> </div> ' ,
    
	openImageContainer: function() {
		if(!webgloo.sc.question.flashLoaded) {
			$("#ajax-message").html("loading...");
			console.log("flash load status =>" + webgloo.sc.question.flashLoaded);
			setTimeout(webgloo.sc.question.openImageContainer,500);
		}
		
		$("#ajax-message").html("");
		$("#link-container").slideUp("slow");
		$("#image-container").slideDown("slow");
		$(window).scrollTop($("#image-container").position().top) ;
	},
	
    populateHidden : function () {
    
        var links = new Array() ;
        var images = new Array() ;
        
        $("div#link-data").find('a').each(function(index) {
            links.push($(this).attr("href"));
        });
        
        $("div#media-data").find('a').each(function(index) {
             var imageId = $(this).attr("id");
             images.push(webgloo.sc.question.images[imageId]);
        });
        
        frm = document.forms["web-form1"];
        
        var strLinks = JSON.stringify(links);
        frm.links_json.value = strLinks ;
        
        var strImages =  JSON.stringify(images);
        frm.images_json.value = strImages ;
        
    },
    addLink : function(linkData) {
        var buffer = webgloo.sc.question.linkPreviewDIV.supplant({"link" : linkData});
        $("#link-data").append(buffer);
    },
    removeLink : function(linkObj) {
		$(linkObj).parent().remove();
    },

    removeImage : function(linkObj) {
		var id = $(linkObj).attr("id");
		var imageId = "#image-" +id ;
		console.log("removing image :: " + imageId);
		$("#image-"+id).remove();
    },
    addImage : function(mediaVO) {
		if(webgloo.sc.question.debug){
			webgloo.addDebug(" image :: bucket:: " + mediaVO.bucket + " name :: " + mediaVO.storeName);
		}
		
        webgloo.sc.question.images[mediaVO.id] = mediaVO ;
        var buffer = webgloo.sc.question.imagePreviewDIV.supplant(mediaVO);
        $("div#media-data").append(buffer);
    
    },
    uploadSuccess : function(file, serverData) {
        // The php script may return an error message etc. but the handler event for swfupload
        // client is still uploadSuccess. we have to parse data returned from server to find known/script
        // error case.
        try {
            var progress = new FileProgress(file, this.customSettings.progressTarget);
            var dataObj ;
            
            try{
                dataObj = JSON.parse(serverData);
                if(dataObj.code == 0){
                    
                    webgloo.sc.question.addImage(dataObj.mediaVO);
                    progress.setComplete();
                    progress.setStatus(dataObj.message);
                    progress.toggleCancel(false);
                }else {
                    //known error
					webgloo.sc.question.uploadError = true ;
                    progress.setStatus("Error :: " + dataObj.message);
                }
                
                
            } catch(ex) {
                //catch JSON parsing errors
				webgloo.sc.question.uploadError = true ;
                progress.setStatus("Error: " + ex.toString());
            }
            
            
        } catch (ex) {
            this.debug(ex);
        }
    },
	fileDialogComplete : function(numFilesSelected, numFilesQueued) {
		try {
			if (numFilesSelected > 0) {
				document.getElementById(this.customSettings.cancelButtonId).disabled = false;
			}
			webgloo.sc.question.uploadError = false ;
			webgloo.sc.question.numSelected = numFilesSelected ;
			
			/* I want auto start the upload and I can do that here */
			this.startUpload();
			
		} catch (ex)  {
			this.debug(ex);
		}
	},
	queueComplete: function (numFilesUploaded) {
		console.log(" files uploaded :: " + numFilesUploaded);
		console.log(" files selected :: " + webgloo.sc.question.numSelected);
		if((numFilesUploaded == webgloo.sc.question.numSelected) && !webgloo.sc.question.uploadError) {
			$("#image-container").slideUp();
		}
	},
	swfLoadComplete : function() {
		//flash is loaded now
		webgloo.sc.question.flashLoaded = true ;
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


            