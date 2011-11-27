//original source of supplant method
//http://javascript.crockford.com/remedial.html

String.prototype.supplant = function (o) {
    return this.replace(/{([^{}]*)}/g,
        function (a, b) {
            var r = o[b];
            return typeof r === 'string' || typeof r === 'number' ? r : a;
        });
};

var webgloo = {} ;
webgloo.media = {
    debug :false,
    column : 1 ,
    addImage : function(mediaVO) {
        
        webgloo.media.addDebug("Adding image :: " + mediaVO.originalName + " path :: " + mediaVO.storeName);
        buffer = this.imageDiv.supplant(mediaVO);
        
        var previewDivId = "div#preview" + this.column;
        $(previewDivId).append(buffer);
        
        this.column = (this.column == 1 ) ? 2 : 1 ;

    },
    imageDiv : '<div id="{id}"> <img src="/{bucket}/{storeName}" class="resize" alt="{originalName}" width="{width}" height="{height}"/> '
    + '<div> <a href="#"> Delete </a> </div> <div> {originalName} </div> </div>'
}


webgloo.media.addDebug = function(message) {
    if(webgloo.media.debug) {
        $("#js-debug").append(message);
        $("#js-debug").append("<br>");
    }
    
    
};

webgloo.media.clearDebug = function(message) {
    $("#js-debug").html("");
};


