<?php
namespace com\indigloo\news{

    
    class Router extends \com\indigloo\core\Router{
        
        function __construct() {
            
        }

        function __destruct() {
        
        }
        
        function initTable() {
            //match alphanumeric + dashes
            //a pcre word (\w) does not contain dashes
            $this->createRule('/', 'com\indigloo\news\controller\Home');
            $this->createRule( '^(?P<token>[-\w]+)$','com\indigloo\news\controller\Post');
            $this->createRule('^page/(?P<page>\d+)$','com\indigloo\news\controller\Home');
            $this->createRule('^(?P<token>\w+)/page/(?P<page>\d+)$','com\indigloo\news\controller\Post');
            $this->createRule('^category/(?P<name>\w+)$','com\indigloo\news\controller\Category');
            $this->createRule('^category/(?P<name>\w+)/page/(?P<page>\d+)$','com\indigloo\news\controller\Category');

        }
    }
}
?>
