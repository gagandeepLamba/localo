//original source of supplant method
//http://javascript.crockford.com/remedial.html

String.prototype.supplant = function (o) {
    return this.replace(/{([^{}]*)}/g,
        function (a, b) {
            var r = o[b];
            return typeof r === 'string' || typeof r === 'number' ? r : a;
        });
};

var questionJsObject = {} ;
questionJsObject.attachEvents = function() {
  
    $("a#open-link").live("click", function(event){
        event.preventDefault();
        $("#link-container").slideDown("slow");
    }) ;
    
    $("#add-link").live("click", function(event){
        event.preventDefault();
        questionJsObject.addLink();
    }) ;
    
     $("a#open-image").live("click", function(event){
        event.preventDefault();
        $("#image-container").slideDown("slow");
    }) ;
    
    $("#add-image").live("click", function(event){
        event.preventDefault();
        questionJsObject.addImage();
    }) ;
    
};


questionJsObject.addLink= function() {
  var linkData = $("#link-box").val();
  $("#link-data").append(linkData);
  $("#link-container").slideUp("slow");

} ;

questionJsObject.imagePreviewDIV =
    '<div id="{id}" class="previewImage"> <img src="/{bucket}/{storeName}" class="resize" alt="{originalName}" width="{width}" height="{height}"/> '
    + '<div> <a href="/post/delete-media.php?g_id={id}&g_post_id={postId}"> Delete </a> </div> <div> {originalName} </div> </div>' ;
    
questionJsObject.addImage= function(mediaVO) {
    addDebug("Adding image :: " + mediaVO.originalName + " path :: " + mediaVO.storeName);
    buffer = questionJsObject.imagePreviewDIV.supplant(mediaVO);
    $("div#media-data").append(buffer);
    //$("#image-container").slideUp("slow");

} ;



addDebug = function(message) {
    $("#js-debug").append(message);
    $("#js-debug").append("<br>");
  
};

clearDebug = function(message) {
    $("#js-debug").html("");
};


            