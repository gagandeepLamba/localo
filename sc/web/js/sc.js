
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

webgloo.sc.question = {} ;
webgloo.sc.question.attachEvents = function() {
  
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
    
    $("#add-image").live("click", function(event){
        event.preventDefault();
        webgloo.sc.question.addImage();
    }) ;
    
    $('#web-form1').submit(function() {
        webgloo.sc.question.populateHidden();
        return true;
    });
    
    
};


webgloo.sc.question.imagePreviewDIV =
    '<div id="{id}" class="previewImage"> <img src="/{bucket}/{storeName}" class="resize" alt="{originalName}" width="{width}" height="{height}"/> '
    + '<div> <a href="/post/delete-media.php?g_id={id}&g_post_id={postId}"> Delete </a> </div> <div> {originalName} </div> </div>' ;
    

webgloo.sc.question.linkPreviewDIV =
    '<div class="previewLink"> {link} &nbsp; <a class="remove-link" href="{link}"> Remove</a> </div> ' ;
    

webgloo.sc.question.populateHidden = function () {
    //find all a href inside div id link-data
    $("div#link-data").find('a').each(function(index) {
         alert(index + ': ' + $(this).attr("href"));
    });
} ;


webgloo.sc.question.addLink= function(linkData) {
  var buffer = webgloo.sc.question.linkPreviewDIV.supplant({"link" : linkData});
  $("#link-data").append(buffer);
  
} ;




webgloo.sc.question.removeLink= function(linkObj) {
  $(linkObj).parent().remove();
} ;

webgloo.sc.question.addImage= function(mediaVO) {
    webgloo.addDebug("Adding image :: " + mediaVO.originalName + " path :: " + mediaVO.storeName);
    var buffer = webgloo.sc.question.imagePreviewDIV.supplant(mediaVO);
    $("div#media-data").append(buffer);
    
} ;


webgloo.sc.question.uploadSuccess = function(file, serverData) {
    // The php script may return an error message etc. but the handler event for swfupload
    // client is still uploadSuccess. we have to parse data returned from server to find known/script
    // error case.
    try {
        var progress = new FileProgress(file, this.customSettings.progressTarget);
        var dataObj ;
        
        try{
			dataObj = JSON.parse(serverData);
            if(dataObj.code == 0){
                //no error object or error is not yes!
                //process document object received from server
                webgloo.sc.question.addImage(dataObj.mediaVO);
                progress.setComplete();
                progress.setStatus(dataObj.message);
                progress.toggleCancel(false);
            }else {
                //known error
                progress.setStatus("Error :: " + dataObj.message);
            }
            
            
        } catch(ex) {
            //we need to gaurd against JSON parsing errors as well
            progress.setStatus("Error: " + ex.toString());
        }
        
        
    } catch (ex) {
        this.debug(ex);
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


            