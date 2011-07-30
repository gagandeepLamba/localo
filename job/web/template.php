<?php
include 'job-app.inc';


//$grid = new test\ui\Grid();
//$cols = $grid->getGridName($grid::GA);
//echo " cols = $cols <br>";
?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> {pagetitle} </title>
         <style type="text/css">
            body {
                margin: auto; /* center in viewport */
                width: 960px;
            }

        </style>

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.3.0/build/cssgrids/grids-min.css">
        <!-- app css here -->
        <!-- include any javascript here -->


    </head>


    <body>



        <div id="top-toolbar">
            <div>
                <span style="float:right">  Hello, &nbsp;user@gmail.com &nbsp; <a href="http://www.test2.com/ca/logout.php?domain=www.test2.com"> logout </a></span>
            </div>

        </div> <!-- top toolbar -->

        <div id="body-wrapper">

                <div id="hd">
                   Header text
                </div>
                <div id="bd">
                    
                    <div class="yui3-g">
                        <div class="yui3-u-5-24">
                            Left panel
                        </div> <!-- left unit -->
                        
                        <div class="yui3-u-19-24">
                        




                        </div> <!-- main unit -->
                    </div> <!-- GRID -->


                </div> <!-- bd -->



        </div> <!-- body wrapper -->

        <div id="ft">

            <div id="site-footer">

                <br> <br>
                <p class="copyright">

                    &copy; All Rights Reserved
                    &nbsp;website developed using....

                </p>

            </div>


        </div>

    </body>
</html>
