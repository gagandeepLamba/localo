<?php
namespace com\indigloo\news{

    
    class Router extends \com\indigloo\core\Router{
        
        function __construct() {
            
        }

        function __destruct() {
        
        }
        
        function initTable() {
             /* match alphanumeric + dashes
              * a pcre word (\w) does not contain dashes
              * our SEO title contains dashes, hence the matching pattern has to
              * include a dash [-\w]
              * 
              */
            $this->createRule('^/$', 'com\indigloo\news\controller\Home');
            $this->createRule('^page/(?P<page>\d+)$','com\indigloo\news\controller\Home');
            //short identifier match
            $this->createRule( '^(?P<shortid>[\w]{8})/(?P<token>[-\w]+)$','com\indigloo\news\controller\Post');
            $this->createRule( '^(?P<token>[\w]{8})$','com\indigloo\news\controller\TinyUrl');
            
        }
    }
}
?>
