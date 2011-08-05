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
        $('#gui-dialog').dialog('option', 'width', 640);
        $('#gui-dialog').dialog('option', 'height', 510);
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
