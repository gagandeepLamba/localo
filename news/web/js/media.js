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
    addImage : function(mediaId,bucket,imageName,diskName,width,height) {
        if(webgloo.media.debug) {
            webgloo.media.addDebug("Adding image :: " + imageName + " path :: " + diskName);
        }
        var row = {
            id : mediaId,
            bucket : bucket,
            name: imageName ,
            diskName: diskName,
            width : width ,
            height : height
        };
        
        buffer = this.imageDiv.supplant(row);
        //Add this html to table in preview DIV
        $("div#preview").append(buffer);

    },
    imageDiv : '<div id="{id}"> <img src="/{bucket}/{diskName}" alt="{name}" width="{width}" height="{height}"/> <div> {name} </div> </div>'
}


webgloo.media.addDebug = function(message) {
    $("#js-debug").append(message);
    $("#js-debug").append("<br>");
    
};

webgloo.media.clearDebug = function(message) {
    $("#js-debug").html("");
};


