//original source of supplant method
//http://javascript.crockford.com/remedial.html

String.prototype.supplant = function (o) {
    return this.replace(/{([^{}]*)}/g,
        function (a, b) {
            var r = o[b];
            return typeof r === 'string' || typeof r === 'number' ? r : a;
        });
};
//Add document handler functionality
var webgloo = {}
webgloo.gMedia = {
    debug :false
}

webgloo.gMedia.table = {
    rows : [],
    load : function () {
        //initialize the gMedia table rows variable

        //load using document property
        frm = document.forms["web-form1"];
        var strRows = frm.document_array_json.value ;
        
        if(strRows.length > 0 ) {
            if(webgloo.gMedia.debug) {
                alert( "existing doc array json is ::  " + strRows);
            }
            //objectify
            var rows = JSON.parse(strRows);
            for(i = 0 ;i < rows.length ; i++) {
                //process ith row
                webgloo.gMedia.table.addRow(rows[i].id, rows[i].name);
            }
        }

    },
    flush : function() {
        //override persistent store with our rows value

        try{
            var data = JSON.stringify(webgloo.gMedia.table.rows);
             frm = document.forms["web-form1"];
             frm.document_array_json.value = data ;
             if(webgloo.gMedia.debug) {
                alert("saving doc json :: " +  data);
             }
        } catch(ex) {
            alert(ex.toString());
        }
       

    },
    removeRow : function(documentId){
        //go through rows array and delete the one matching this id
        for(i = 0 ; i < webgloo.gMedia.table.rows.length ; i++ ) {
            var row = webgloo.gMedia.table.rows[i];
            if(row.id == documentId) {
                //remove this row
                if(webgloo.gMedia.debug) {
                    alert("removing doc at index :: " + i + " doc id :: " + documentId);
                }
                webgloo.gMedia.table.rows.splice(i,1);
                break;
            }

        }
        //write to form element
        webgloo.gMedia.table.flush();
        //remove this row on UI
        tableRowId = "div#preview table tr#" + documentId ;
        $(tableRowId).remove();
       

    },
    addRow : function(documentId,documentName) {
        if(webgloo.gMedia.debug) {
            alert( "Adding doc :: id:: " + documentId + " name :: " + documentName);
        }

        var row = {
            id: documentId ,
            name: documentName
        };
        webgloo.gMedia.table.rows.push(row);
        webgloo.gMedia.table.flush();
        //UI update should be the last step!
        buffer = this.rowHtml.supplant(row);
        //Add this html to table in preview DIV
        $("div#preview table").append(buffer);
        


    },
    rowHtml : '<tr class="item" id="{id}"> <td> {name} </td>  <td> &nbsp;&nbsp;&nbsp; <a href="#" id="{id}" class="removeMedia">Delete </a> </td> </tr>'

}


webgloo.gui = {
    debug : false
}

webgloo.gui.Dialog = {

    loadOpeningDetail : function(openingId){
       var loadURI = "/ajax/opening/detail.php?g_opening_id=" + openingId ;
       if(webgloo.gui.debug){
            alert(" load opening detail :: id :: " + openingId);
       }
       this.showDialogBox('Opening details', loadURI);
    },
    loadApplicationDetail : function(applicationId){
       var loadURI = "/ajax/application/detail.php?g_application_id=" + applicationId ;
       if(webgloo.gui.debug){
            alert(" load application detail :: id :: " + applicationId);
       }
       this.showDialogBox('Application details', loadURI);
    },
    showDialogBox : function(title,dataURI) {
        //load dialog box with content of data URI
        $("#gui-dialog").load(dataURI);
        $('#gui-dialog').dialog('option', 'title', title);
        $('#gui-dialog').dialog('option', 'width', 510);
        $('#gui-dialog').dialog('option', 'position', 'center');
        $('#gui-dialog').dialog('option', 'modal', true);
        //Buttons for this dialog box
        $('#gui-dialog').dialog('option', 'buttons',
        {

            "Close": function() {
                $(this).dialog("close");
                $(this).html("");
            }

        });

        $("#gui-dialog").dialog("open");

    }

}

/* + js for application object */

var applicationObject = {
    debug : false
};


//insert message DIV
applicationObject.insertMessage = function(applicationId){
    //remove existing message DIV
    $("div#message-"+applicationId).remove();
    //insert after application DIV
    var buffer = '<div class="ajax-toolbar" id="message-' + applicationId +  '"></div>' ;
    $("div#application-"+applicationId).append(buffer);

};

applicationObject.postApprovalData = function (postURI,applicationId,code) {
    
    try{
        //insert message DIV
        applicationObject.insertMessage(applicationId);
        //show spinner
        $("#message-"+applicationId).html('<img src="/css/images/ajax_loader.gif" alt="spinner" />');
        var dataObj = new Object();
        dataObj.applicationId = applicationId;
        dataObj.code = code ;
        
        //ajax call start
        $.ajax({
            url: postURI ,
            type: 'POST',
            dataType: 'html',
            data : dataObj,
            timeout: 9000,

            error: function(XMLHttpRequest, textStatus){
                $("#message-"+applicationId).html(textStatus);
            },
            success: function(html){
                $("#message-"+applicationId).html(html);
                //disable approval link after success?
                
            }
        }); //ajax call end
    } catch(ex) {
        $("#message-"+applicationId).html(ex.toString());
    }
};

applicationObject.attachEvents = function() {
    
    // live event is required to attach event to future DOM elements
    $("a.opening-more-link").live("click", function(event){
        event.preventDefault();
        var openingId = $(this).attr("id");
        //show details
        $("#opening-"+openingId).slideDown("slow");
    
    
    }) ;
    
    $("a.opening-less-link").live("click", function(event){
        event.preventDefault();
        var openingId = $(this).attr("id");
        $("#opening-"+openingId).slideUp("slow");
    
    
    }) ;
    
    
    $("a.application-more-link").live("click", function(event){
        event.preventDefault();
        var applicationId = $(this).attr("id");
        //hide summary
        $("#application-summary-"+applicationId).hide();
        //show application details
        $("#application-detail-"+applicationId).slideDown("slow");
    
    
    }) ;
    
    $("a.application-less-link").live("click", function(event){
        event.preventDefault();
        var applicationId = $(this).attr("id");
        //hide details
        $("#application-detail-"+applicationId).slideUp("slow");
        //show application summary
        $("#application-summary-"+applicationId).show();
    }) ;
    
    $("a.application-approve-link").live("click", function(event){
        event.preventDefault();
        var applicationId = $(this).attr("id");
        applicationObject.postApprovalData('/ajax/application/approval.php', applicationId,'YES');
    
    }) ;
    
    $("a.application-reject-link").live("click", function(event){
        event.preventDefault();
        var applicationId = $(this).attr("id");
        applicationObject.postApprovalData('/ajax/application/approval.php', applicationId,'NO');
    
    }) ;
    
            
};


/* js for application object */


/* + js for Opening object  */

var openingObject = {
    debug :  false ,
    actions : function(status){
        var data = new Array();
        switch (status){
            case 'A' :
                data["C"] = "close";
                data["S"] = "suspend" ;
                data["EX2W"] = "extend for 2 weeks" ;
                data["EX4W"] = "extend for 4 weeks" ;
                
                break ;
            case 'C' :
                data["A"] = "make active";
                break ;
            case 'E' :
                data["A"] = "make active";
                break ;
            default :
                break ;
        }

        return data ;
    }
    

};

openingObject.addDebug = function(message) {
    $("#js-debug").append(message);
    $("#js-debug").append("<br>");
    
};

openingObject.closeToolbar = function(toolbarId) {
    if(openingObject.debug){
        openingObject.addDebug("removing toolbar div :: " + toolbarId);
    }
    
    $("div#"+toolbarId).remove();
} ;

openingObject.addEditLinks = function(openingId,status) {
    if(openingObject.debug){
        openingObject.addDebug("<br> add edit links for opening " + openingId + " and status " + status);
    }
    
    //get associative array of status code and display names
    var actions = openingObject.actions(status);
    var toolbarId = "opening-toolbar-" + openingId ;
    openingObject.closeToolbar(toolbarId);
    
    //iterate thorugh array and print it
    var template = '<a href="/opening/post/quick-action.php?g_opening_id={gOpeningId}&action={gCode}&g_status={gstatus}">{name} </a> &nbsp;&nbsp;';
    var buffer = '' ;
    for (var key in actions) {
        var params = {gOpeningId: openingId ,gCode: key, name:actions[key], gstatus :status};
        if(openingObject.debug){
            openingObject.addDebug("Adding actions link :: code " + key + " name :: " + actions[key]);
        }
        
        buffer = buffer + template.supplant(params);
        
    }

    //add close toolbar link
    buffer = buffer + '<a href="#" id="' +toolbarId + '" class="opening-toolbar-close"> <img src="/css/images/cross.png" alt="x"> </a>&nbsp;' ;
    //wrap links in toolbar DIV
    buffer = '<div class="ajax-toolbar" id="' + toolbarId + '">' + buffer + '</div>';
    $("div#opening-"+openingId).append(buffer);
    
    if(openingObject.debug){
        openingObject.addDebug("Added toolbar div :: " + toolbarId);
    }
    
    
};

openingObject.attachEvents = function() {
    
    //Attach a live event to removeLink
    // live event is required to attach event to future DOM elements
    $("a.more-link").live("click", function(event){
        event.preventDefault();
        var paragraphId = $(this).attr("id");
        //hide summary
        $("#summary-"+paragraphId).hide();
        //show description
        $("#description-"+paragraphId).slideDown("slow");
        

    }) ;

    $("a.less-link").live("click", function(event){
        event.preventDefault();
        var paragraphId = $(this).attr("id");
        //hide description
        $("#description-"+paragraphId).slideUp("slow");
        //show summary
        $("#summary-"+paragraphId).show();
    }) ;

    $("a.opening-action-link").live("click", function(event){
        event.preventDefault();
        var openingId = $(this).attr("id");
        var status = $(this).attr("status");
        openingObject.addEditLinks(openingId,status);
        
        
    }) ;

    $("a.opening-toolbar-close").live("click", function(event){
        event.preventDefault();
        var toolbarId = $(this).attr("id");
        openingObject.closeToolbar(toolbarId);

    }) ;

};

/* js for Opening object  */




