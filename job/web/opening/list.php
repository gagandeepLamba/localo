<?php
    include 'job-app.inc';
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    //check if user has customer admin role or not
    include($_SERVER['APP_WEB_DIR'] . '/inc/admin/role.inc');

    use webgloo\auth\FormAuthentication;
    use webgloo\job\html\Link;
    use webgloo\common\Url;
    use webgloo\job\html\UIData ;


    //This method will throw an error
    $adminVO = FormAuthentication::getLoggedInAdmin();
    $organizationId = $adminVO->organizationId;

    $gstatus = $gWeb->getRequestParam('g_status');
    if (empty($gstatus)) {
        $gstatus = '*';
    }

    $uifilters = UIData::getOpeningFilters();

    //input sanity check
    if (!in_array($gstatus, array_keys($uifilters))) {
        trigger_error('Unknown status filter on UI', E_USER_ERROR);
    }


    $flinks = array();
    foreach ($uifilters as $code => $name) {
        $link = Url::addQueryParameters($_SERVER['REQUEST_URI'], array('g_status' => $code));
        $flinks[$code] = $link;
    }


?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> <?php echo $adminVO->company; ?> Job Openings</title>


        <meta http-equiv="content-type" content="text/html;" />

        <link rel="stylesheet" type="text/css" href="/css/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/jquery/flick/jquery-ui-1.8.14.custom.css">
        <!-- app css here -->
        <link rel="stylesheet" type="text/css" href="/css/main.css">

        <script type="text/javascript" src="/js/jquery-1.6.2.min.js"></script>
        <!-- jquery UI and css -->
        <script type="text/javascript" src="/js/jquery-ui-1.8.14.custom.min.js"></script>
        <script type="text/javascript" src="/js/main.js"></script>


        <!-- include any javascript here -->
        <script type="text/javascript">

            var openingObject = {
                debug :  false ,
                actions : function(status){
                    var data = new Array();
                    switch (status){
                        case 'A' :
                            data["C"] = "close";
                            data["S"] = "suspend" ;
                            data["EX2W"] = "Extend for 2 weeks" ;
                            data["EX4W"] = "Extend for 4 weeks" ;
                            
                            break ;
                        case 'C' :
                            data["A"] = "activate";
                            break ;
                        case 'E' :
                            data["A"] = "activate";
                            break ;
                        default :
                            break ;
                    }

                    return data ;
                }
                

            };

            openingObject.closeToolbar = function(toolbarId) {
                if(openingObject.debug){
                    alert("removing toolbar div :: " + toolbarId);
                }
                $("div#"+toolbarId).remove();
            } ;

            openingObject.addEditLinks = function(openingId,status) {
                if(openingObject.debug){
                    alert("add edit links for opening " + openingId + " and status " + status);
                }
                
                //get associative array of status code and display names
                var actions = openingObject.actions(status);
                var toolbarId = "opening-toolbar-" + openingId ;
                openingObject.closeToolbar(toolbarId);
                
                //iterate thorugh array and print it
                var template = '<a href="/opening/post/quick-action.php?g_opening_id={gOpeningId}&action={gCode}">{name} </a> &nbsp;&nbsp;';
                var buffer = '' ;
                for (var key in actions) {
                    var params = {gOpeningId: openingId ,gCode: key, name:actions[key]};
                    if(openingObject.debug){
                        alert("Adding actions link :: code " + key + " name :: " + actions[key]);
                    }
                    
                    buffer = buffer + template.supplant(params);
                    
                }

                //add close toolbar link
                buffer = buffer + '<a href="#" id="' +toolbarId + '" class="opening-toolbar-close"> <img src="/css/images/cross.png" alt="x"> </a>&nbsp;' ;
                //wrap links in toolbar DIV
                buffer = '<div class="ajax-toolbar" id="' + toolbarId + '">' + buffer + '</div>';
                $("div#opening-"+openingId).append(buffer);
                
            };


            $(document).ready(function(){

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
                    openingObject.addEditLinks(openingId, 'A');
                    
                }) ;

                $("a.opening-toolbar-close").live("click", function(event){
                    event.preventDefault();
                    var toolbarId = $(this).attr("id");
                    openingObject.closeToolbar(toolbarId);

                }) ;

                //show all shy hide-me containers on document load!
                $(".hide-me").hide();


            });

            openingObject.debug = false ;


        </script>

    </head>


    <body>
    <?php include($_SERVER['APP_WEB_DIR'] . '/inc/toolbar.inc'); ?>

        <div id="body-wrapper">

            <div id="hd">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/banner.inc'); ?>
            </div>
            <div id="bd">
                <!-- grid DIV -->
                <div class="yui3-g">
                    <div class="yui3-u-5-24">
                    <?php include($_SERVER['APP_WEB_DIR'] . '/inc/left-panel.inc'); ?>

                    </div> <!-- left unit -->


                    <div class="yui3-u-19-24">
                        <div id="main-panel">
                            <div>
                                <p> <span class="header">  <?php echo $adminVO->company; ?> Job Openings </span> </p>
                                <div> <span>&nbsp;Filter&nbsp; </span>
                                    <?php
                                        foreach ($flinks as $code => $link) {
                                            //does the name match?
                                            if ($code == $gstatus) {
                                                echo "<b> $uifilters[$code] </b> ";
                                            } else {
                                                $msg = '&nbsp;<a href="{link}">{name}</a> &nbsp;';
                                                $name = $uifilters[$code];
                                                $msg = str_replace(array(0 => "{name}", 1 => "{link}"), array(0 => $name, 1 => $link), $msg);
                                                echo $msg;
                                            }
                                        }
                                    ?>
                                </div>
                                
                            </div>
                                <!-- include opening list -->
                                <?php
                                    $openingDao = new webgloo\job\dao\Opening();
                                    $rows = $openingDao->getRecordsOnOrgId($organizationId, array("status" => $gstatus));
                                    foreach ($rows as $row) {
                                        $html = webgloo\job\html\template\Opening::getOrganizationSummary($row);
                                        echo $html;
                                    }
                                ?>
                        </div>


                    </div> <!-- main unit -->
                </div> <!-- GRID -->


            </div> <!-- bd -->



        </div> <!-- body wrapper -->

        <div id="ft">
        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>

        </div>

        <!-- code for common UI dialog box -->
        <div id="gui-dialog" title="">
            <div id="gui-dialog-results"> </div>
        </div>

    </body>
</html>




