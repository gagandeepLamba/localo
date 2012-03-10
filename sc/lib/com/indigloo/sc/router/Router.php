<?php
namespace com\indigloo\sc\router{

    
    class Router extends \com\indigloo\core\Router{
        
        function __construct() {
            
        }

        function __destruct() {
        
        }
        
        function initTable() {
            $this->createRule('^/$', 'com\indigloo\sc\controller\Home');
            //show item_id
            $this->createRule( '^item/(?P<item_id>\d+)$','com\indigloo\sc\controller\Post');
            $this->createRule( '^search/site$','com\indigloo\sc\controller\Search');
            $this->createRule( '^search/group$','com\indigloo\sc\controller\GroupSearch');
            
        }
    }
}
?>
