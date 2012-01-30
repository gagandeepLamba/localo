
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


/* + webgloo sc question object */

webgloo.sc.question = {
    images : {} ,
    init : function () {
        webgloo.news.post.images = {} ;
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
            webgloo.sc.question.addLink(linkData);
        }) ;
        
        $("a.remove-link").live("click", function(event){
            event.preventDefault(); 
            //webgloo.sc.question.removeLink.apply(this);
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
    imagePreviewDIV : '<div class="previewImage"> <img src="/{bucket}/{storeName}" class="resize" alt="{originalName}" width="{width}" height="{height}"/> '
        + ' <div> {originalName} </div>  <a id="{id}" class="remove-image" href="" > Remove </a> </div>',
    
    linkPreviewDIV : '<div class="previewLink"> {link} &nbsp; <a class="remove-link" href="{link}"> Remove</a> </div> ' ,
    
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
       $(linkObj).parent().remove();
    },
    addImage : function(mediaVO) {
        webgloo.addDebug(" image :: bucket:: " + mediaVO.bucket + " name :: " + mediaVO.storeName);
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


webgloo.addDebug = function(message) {
    $("#js-debug").append(message);
    $("#js-debug").append("<br>");
    console.log(message);
  
};

webgloo.clearDebug = function(message) {
    $("#js-debug").html("");
};


            