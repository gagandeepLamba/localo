<?php

    if(isset($_GET['debug']) && ($_GET['debug'] == '1')){
        $error = $_GET['message'];
        $error = base64_decode($error);
    } else {
        $error = '' ; //donot show
    }
    
?>

<html>  
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
        <title>Error Page </title>
        
        <style type="text/css">
        
             body {
                text-align: center;
                color: white ;
            }
            
            .centered {
                position: fixed;
                top: 50%;
                left: 50%;
                margin-top: -175px;
                margin-left: -230px;
                font-family : courier,Arial, sans-serif ;
                font-size : 14px;
            }

            #mini_inner {
                background-color: black;
                width:360px ;
                padding: 50px;
                height:250px;
                -moz-border-radius: 4px;
                -webkit-border-radius: 4px;
                border-radius: 4px;
                -moz-box-shadow: 0 0 10px rgba(0,0,0,0.5);
                -webkit-box-shadow: 0 0 10px rgba(0,0,0,0.5);
                z-index:1;
            }
           
           #mini_inner a {
                color : white ;
           }
            .error{
                display :block ;
                color :yellow ;
            }


        </style>

    </head>
    <body>
        <div id="mini_inner" class="centered">
            <img src="/css/images/alert.png" alt="alert" class="alert">
            <h1> Error! We Apologize.</h1>
            <p>This page has encountered an error.
                <span class="error"> <?php echo $error ; ?></span>
                To know more you can examine the logs or contact your administrator.
                <br/>
                <br/>
                Go back to  <a href="/"> Home page</a>.</p>
        </div>



    </body>

</html>




