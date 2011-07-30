<?php
include 'job-app.inc';


//$grid = new test\ui\Grid();
//$cols = $grid->getGridName($grid::GA);
//echo " cols = $cols <br>";
?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> JOB site </title>
         <style type="text/css">
            body {
                margin: auto; /* center in viewport */
                width: 960px;
            }

        </style>
        
        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.3.0/build/cssgrids/grids-min.css">
        <!-- app css here -->
        <script type="text/javascript" src="/js/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="/js/jquery.validate.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function(){
                //form validator
                $("#web-form1").validate({
                    errorLabelContainer: $("#web-form1 div.error")
                });

            });

        </script>


    </head>


    <body>



        <div id="top-toolbar">
            <div>
                <span style="float:right">  Hello, &nbsp;sanjeevnjha@gmail.com &nbsp; <a href="http://www.test2.com/ca/logout.php?domain=www.test2.com"> logout </a></span>
            </div>

        </div> <!-- top toolbar -->




        <div id="custom-doc">
          
                <div id="hd">
                   Header
                </div>
                <div id="bd">
                    <div class="yui3-g">
                        <div class="yui3-u-5-24">
                            Left panel
                        </div>
                        <div class="yui3-u-19-24">
                          
                                    <h2> Add Photo </h2>


                                    <p class="help-text">
                                        Please click on browse button to select a photo from your computer.
                                        The maximum allowed size is <b> 2MB.</b> Optimize bigger files for web with a photo editor software like
                                        <a href="http://www.irfanview.com/" TARGET="_blank"> Irfan View </a>

                                    </p>



                                    <div id="form-wrapper">
                                        <form id="web-form1" class="web-form" name="web-form1"
                                              action="http://www.test2.com/ca/widget/image/frm/add.php"
                                              enctype="multipart/form-data"  method="POST">

                                            <div class="error">    </div>

                                            <table class="form-Group">
                                                <tr>
                                                    <td class="field"> Title<span class="red-label">*</span></td>
                                                    <td>
                                                        <input type="text" name="title" maxlength="100" class="required" title="&gt;&nbsp;Title is a required field" value=""/>
                                                    </td>
                                                </tr>
                                                
                                            </table>

                                            <br>
                                            <span class="red-label"> Short Summary </span>
                                            <div class="text-container">
                                                <textarea  name="note_content" id="editor" cols="50" rows="5" ></textarea>
                                            </div>

                                            <span> Description </span>
                                            <div class="text-container">
                                                <textarea  name="note_content" id="editor" cols="50" rows="10" ></textarea>
                                            </div>

                                              <table class="form-Group">
                                                <tr>
                                                    <td class="field"> Category<span class="red-label">*</span></td>
                                                    <td>
                                                        <select name="category">
                                                            <option value="1"> Business </option>
                                                            <option value="1"> Art </option>
                                                            <option value="1"> Entertainment </option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="field"> Address<span class="red-label">*</span></td>
                                                    <td>
                                                        <input type="text" name="title" maxlength="100" class="required" title="&gt;&nbsp;Title is a required field" value=""/>
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td class="field"> Tags<span class="red-label">*</span></td>
                                                    <td>
                                                        <input type="text" name="title" maxlength="100" class="required" title="&gt;&nbsp;Title is a required field" value=""/>
                                                    </td>
                                                </tr>

                                            </table>

                                            <div class="button-container">

                                                <div class="submit">
                                                    <div>
                                                        <button type="submit" name="save" value="Save" onclick="this.setAttribute('value','Save');" ><span>Save</span></button>
                                                    </div>
                                                </div>

                                                <div class="button">
                                                    <div>
                                                        <button type="button" name="cancel" onClick="javascript:go_back('http://www.test2.com');"><span>Cancel</span></button>
                                                    </div>
                                                </div>

                                            </div>


                                            <!-- hidden fields -->
                                            <input type="hidden" name="widget_type" value="IMAGE" />

                                            <div style="clear: both;"></div>

                                        </form>
                                    </div> <!-- form -->


                                   

                        </div> <!-- UNIT 2 -->
                    </div> <!-- GRID -->


                </div> <!-- bd -->

          

        </div> <!-- custom-doc -->

        <div id="ft">

            <div id="site-footer">

                <br> <br>
                <p class="copyright">

                    &copy; All Rights Reserved
                    &nbsp;website developed using <a href="http://www.indigloo.com"> Bhindi website builder</a>

                </p>

            </div>

         
        </div>

    </body>
</html>




