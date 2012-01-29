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

            .centered {
                position: fixed;
                top: 50%;
                left: 50%;
                margin-top: -175px;
                margin-left: -230px;
                font-family:Arial,sans-serif;
                font-size:13px;
            }

            #mini_inner {
                background-color:#fff;
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
            body {
                
                text-align: center;
                color: #444444;
                background: #bcbcbc;
            }
            .error{
                display :block ;
                color :red ;
            }


        </style>

    </head>
    <body>
        <div id="mini_inner" class="centered">
            <img src="/css/images/alert.png" alt="alert" class="alert">
            <h1> Urggh. We encountered an error on page.</h1>
            <p> Apologies.
                <span class="error"> <?php echo $error ; ?></span>
                To know more you can examine the logs or contact your administrator.
                Go back to  <a href="/"> Home page</a>.</p>
        </div>



    </body>

</html>




