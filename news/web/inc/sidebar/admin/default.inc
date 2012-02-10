
<div id="sidebar">
    <div class="block">
        <p>
            Please click the button below after making the changes...
        </p>
        
        <form id="web-form1" class="web-form" name="web-form1" action="/admin/form/dashboard.php" enctype="multipart/form-data"  method="POST">
            <input id="states_json" name="states_json" type="hidden" value ='<?php echo $json; ?>' />
            <div>
                <button class="submit blue-button" type="submit" name="save" value="Save" onclick="this.setAttribute('value','Save');" ><span>Click to Save the changes!</span></button>    
            </div>
            
        </form>
         
    </div>
</div>



