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
        var strRows = frm.document_rows.value ;


        if(strRows.lenght > 0 ) {
            if(webgloo.gMedia.debug) {
                alert( "existing docs :: length => " + strRows.length);
            }
            //objectify
            var rows = JSON.parse(strRows);
            for(i = 0 ;i < rows.length ; i++) {
                //process ith row
                webgloo.gMedia.table.addRow(row[i].id, rows[i].name);
            }
        }

    },
    flush : function() {
        //override persistent store with our rows value
        try{
            var data = JSON.stringify(webgloo.gMedia.table.rows);
        } catch(ex) {
            alert(ex.toString());
        }
        frm = document.forms["web-form1"];
        frm.document_rows.value = data ;
        if(webgloo.gMedia.debug) {
            alert("saving doc json :: " +  data);
        }

    },
    removeRow : function(documentId){
        //remove this row
        tableRowId = "div#preview table tr#" + documentId ;
        $(tableRowId).remove();
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
        webgloo.gMedia.table.flush();

    },
    addRow : function(documentId,documentName) {
        if(webgloo.gMedia.debug) {
            alert( "Adding doc :: name :: " + documentName);
        }

        var row = {
            id: documentId ,
            name: documentName
        };
        buffer = this.rowHtml.supplant(row);
        //Add this html to table in preview DIV
        $("div#preview table").append(buffer);
        webgloo.gMedia.table.rows.push(row);
        webgloo.gMedia.table.flush();


    },
    rowHtml : '<tr class="item" id="{id}"> <td> {name} </td>  <td> &nbsp;&nbsp;&nbsp; <a href="#" id="{id}" class="removeMedia">Delete </a> </td> </tr>'

}


