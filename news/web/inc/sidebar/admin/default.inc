
<div id="sidebar">
    <div class="block">
        <p>
            Please click the button below to save the changes on page.
        </p>
        
        <form id="web-form1" class="web-form" name="web-form1" action="/admin/form/dashboard.php" enctype="multipart/form-data"  method="POST">
            <input id="states_json" name="states_json" type="hidden" value ='<?php echo $json; ?>' />
            <input name="back_uri" type="hidden" value ="<?php echo $_SERVER['REQUEST_URI']; ?>" />
            
            <div>
                <button class="submit blue-button" type="submit" name="save" value="Save" onclick="this.setAttribute('value','Save');" ><span>Click to Save the changes</span></button>    
            </div>
            
        </form>
         
    </div>
</div>



