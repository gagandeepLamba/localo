

/* supplant source - http://javascript.crockford.com/remedial.html */

String.prototype.supplant = function (o) {
    return this.replace(/{([^{}]*)}/g,
        function (a, b) {
            var r = o[b];
            return typeof r === 'string' || typeof r === 'number' ? r : a;
        });
};


/* +namepsaces */
webgloo = window.webgloo || {};
webgloo.news = webgloo.news || {};


webgloo.addDebug = function(message) {
    $("#js-debug").append(message);
    $("#js-debug").append("<br>");
    console.log(message);
  
};

webgloo.clearDebug = function(message) {
    $("#js-debug").html("");
};


/* +  webgloo news admin object */

webgloo.news.admin = {
    states : {},
    init : function() {
        strStates = $("#states_json").val();
        webgloo.addDebug(" states => " + strStates);
        var mStates = JSON.parse(strStates);
        
        for(var id in mStates) {
            console.log("id =" + id + " state => " + mStates[id]);
            webgloo.news.admin.setState(id,mStates[id]);
        }
        
    },
    getStateText : function(code) {
        text = 'Not Decided Yet!' ;
        
        switch(code) {
            case 'A' :
                text = '<img src="/css/images/plus-icon.png"/>&nbsp;Accepted' ;
                break ;
            case 'T' :
                text = '<img src="/css/images/minus-icon.png"/>&nbsp;Trash' ;
                break ;
            default :
                break ;
                
        }
        
        return text ;
    },
    attachEvents : function() {
        $(".fbox").fancybox({
            'title'             : 'press esc to close',
            'width'				: '75%',
            'height'			: '75%',
            'autoScale'     	: false,
            'transitionIn'		: 'none',
            'transitionOut'		: 'none',
            'type'				: 'iframe'
        });
        
        $(".accept-link").live("click", function(event){
            event.preventDefault();
            var id = $(this).attr("id");
            webgloo.news.admin.setState(id,'A');
            
        }) ;
        
        $(".trash-link").live("click", function(event){
            event.preventDefault();
            var id = $(this).attr("id");
            webgloo.news.admin.setState(id,'T');
        }) ;
        

    },
    setState : function(id,code) {
        webgloo.news.admin.states[id] = code ;
        var text = webgloo.news.admin.getStateText(code);
        $("#link-"+id+ " #state").html(text);
        //store back in document
        var strStates = JSON.stringify(webgloo.news.admin.states);
        console.log("states stringified => " +strStates);
        $("#states_json").val(strStates);
    }
    
    
}
/* + webgloo news post object */

webgloo.news.post = {
    images : {} ,
    init : function () {
        webgloo.news.post.images = {} ;
        
        //read from document
        frm = document.forms["web-form1"];
        
        var strImagesJson = frm.images_json.value ;
        var images = JSON.parse(strImagesJson);
        for(i = 0 ;i < images.length ; i++) {
            webgloo.news.post.addImage(images[i]);
        }
        
        var strLinksJson = frm.links_json.value ;
        var links = JSON.parse(strLinksJson);
        for(i = 0 ;i < links.length ; i++) {
            webgloo.news.post.addLink(links[i]);
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
            $("#link-container").slideUp("slow");
            $("#image-container").slideDown("slow");
            $(window).scrollTop($("#image-container").position().top) ;
        }) ;
        
        $("#add-link").live("click", function(event){
            event.preventDefault();
            var linkData = $("#link-box").val();
            webgloo.news.post.addLink(linkData);
        }) ;
        
        $("a.remove-link").live("click", function(event){
            event.preventDefault(); 
            webgloo.news.post.removeLink($(this));
        }) ;
        
         $("a.remove-image").live("click", function(event){
            event.preventDefault(); 
            webgloo.news.post.removeImage($(this));
        }) ;
         
        $("#add-image").live("click", function(event){
            event.preventDefault();
            webgloo.news.post.addImage();
        }) ;
        
        $('#web-form1').submit(function() {
            webgloo.news.post.populateHidden();
            return true;
        });
        
        
    },
    imagePreviewDIV : '<div class="previewImage"> <img src="/{bucket}/{storeName}" class="resize" alt="{originalName}" width="{width}" height="{height}"/> '
        + ' <div> {originalName} </div> <a id="{id}" class="remove-image" href=""> Remove </a> </div>',
    
    linkPreviewDIV : '<div class="previewLink"> {link} &nbsp; <a class="remove-link" href="{link}"> Remove</a> </div> ' ,
    
    populateHidden : function () {
    
        var links = new Array() ;
        var images = new Array() ;
        
        $("div#link-data").find('a').each(function(index) {
            links.push($(this).attr("href"));
        });
        
        $("div#media-data").find('a').each(function(index) {
             var imageId = $(this).attr("id");
             images.push(webgloo.news.post.images[imageId]);
        });
        
        frm = document.forms["web-form1"];
        
        var strLinks = JSON.stringify(links);
        frm.links_json.value = strLinks ;
        
        var strImages =  JSON.stringify(images);
        frm.images_json.value = strImages ;
        
    },
    addLink : function(linkData) {
        var buffer = webgloo.news.post.linkPreviewDIV.supplant({"link" : linkData});
        $("#link-data").append(buffer);
    },
    removeLink : function(linkObj) {
        $(linkObj).parent().remove();
    },

    removeImage : function(linkObj) {
       $(linkObj).parent().remove();
       
    },
    addImage : function(mediaVO) {
        webgloo.addDebug(" image :: bucket:: " + mediaVO.bucket + " name :: " + mediaVO.storeName);
        webgloo.news.post.images[mediaVO.id] = mediaVO ;
        var buffer = webgloo.news.post.imagePreviewDIV.supplant(mediaVO);
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
                    
                    webgloo.news.post.addImage(dataObj.mediaVO);
                    progress.setComplete();
                    progress.setStatus(dataObj.message);
                    progress.toggleCancel(false);
                }else {
                    //known error
                    progress.setStatus("Error :: " + dataObj.message);
                }
                
                
            } catch(ex) {
                //catch JSON parsing errors
                progress.setStatus("Error: " + ex.toString());
            }
            
            
        } catch (ex) {
            this.debug(ex);
        }
    }
    
}
