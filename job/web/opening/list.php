<?php
include 'job-app.inc';
include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
//check if user has customer admin role or not
include($_SERVER['APP_WEB_DIR'] . '/inc/admin/role.inc');

use webgloo\auth\FormAuthentication;
use webgloo\job\html\Link;
use webgloo\common\Url;

//This method will throw an error
$adminVO = FormAuthentication::getLoggedInAdmin();
$organizationId = $adminVO->organizationId;

$gstatus = $gWeb->getRequestParam('g_status');
if (empty($gstatus)) {
    $gstatus = '*';
}

//all ui status filters
$uifilters = array('*' => 'All', 'A' => 'Active', 'E' => 'Expired', 'S' => 'Suspended', 'C' => 'Closed');

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

            $(document).ready(function(){

                //create dialog box
                $("#gui-dialog").dialog({
                    autoOpen: false,
                    modal: true,
                    draggable: true,
                    position: 'center',
                    width: '310px'}) ;

            });

            //show on demand


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
                                <span class="header">  <?php echo $adminVO->company; ?> Job Openings </span>
                                <span>&nbsp;<b>Filter:</b> </span>
                                    <?php
                                        foreach ($flinks as $code => $link) {
                                            //does the name match?
                                            if ($code == $gstatus) {
                                                echo $uifilters[$code];
                                            } else {
                                                $msg = '&nbsp;<a href="{link}">{name}</a> &nbsp;';
                                                $name = $uifilters[$code];
                                                $msg = str_replace(array(0 => "{name}", 1 => "{link}"), array(0 => $name, 1 => $link), $msg);
                                                echo $msg;
                                            }
                                        }
                                    ?>

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




