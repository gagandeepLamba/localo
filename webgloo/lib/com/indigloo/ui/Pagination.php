<?php

namespace com\indigloo\ui {

    Use com\indigloo\Url as Url ;
    
    class Pagination {
        
        
        private $total ;
        private $page ;
        private $totalPages ;
        private $pageSize ;
    
        function __construct($page,$total,$pageSize) {
            if(empty($page)) {
                $page = 1 ;
            }
    
            $this->total = $total ;
            $this->page = $page ;
            $this->pageSize = $pageSize ;
    
            $this->totalPages = ceil($this->total / $pageSize);
            //deal with smart ppl who have nothing better to do
            if($page > $this->totalPages) {
                $this->page = 1 ;
            }
        }
    
    
    
        function hasNext() {
            if($this->page < $this->totalPages ) {
                return true ;
            }else {
                return false ;
            }
    
        }
    
        function nextPage() {
            return $this->page + 1 ;
    
        }
    
        function isCurrent($counter) {
            if($counter == $this->page ) {
                return true ;
            } else {
                return false ;
            }
        }
    
        function hasPrevious() {
            if($this->page > 1 ) {
                return true ;
            }else {
                return false ;
            }
    
        }
    
        function previousPage() {
            return $this->page - 1 ;
    
        }
    
        private function getPaginationURI($pageURI,$index,$isSEO=false) {
            if($isSEO) {
                $suffix = ($index > 1) ? '/page/'.$index : '' ;
                return $pageURI.$suffix ;
    
            } else {
                $pageURI = Url::addQueryParameters($pageURI,array('page' => $index)) ;
                return $pageURI ;
            }
    
        }
    
        private function getPaginationView($pageURI,$isSEO) {
    
            $view = new \stdClass;
    
            $view->totalPages =  $this->totalPages ;
            $view->baseURI = $pageURI ;
            $view->total = $this->total ;
    
            $view->previousURI = $this->getPaginationURI($pageURI,$this->previousPage(), $isSEO);
            $view->hasPrevious = $this->hasPrevious();
    
            $view->nextURI = $this->getPaginationURI($pageURI,$this->nextPage(), $isSEO);
            $view->hasNext = $this->hasNext();
    
            $view->nextEllipsis = false ;
            $view->previousEllipsis = false ;
    
            //Determine the start/end numbers for pagination
    
            $start = 1 ;
            $end = $this->totalPages ;
            $span = $this->pageSize ;
            //delta should always be an integer
            $delta = round($span/2) ;
    
            if($this->totalPages > $span ) {
                if($this->page - $delta <= 0  ) {
                    $start = 1 ;
                    $end = $span ;
    
                } else {
                    $end = ($this->page + $delta ) > $this->totalPages ? $this->totalPages : $this->page + $delta ;
                    $start = $end - $span + 1 ;
                }
    
            }
    
            if($end < $this->totalPages) {
                $view->nextEllipsis = true ;
            }
            if($start > 1 ) {
                $view->previousEllipsis = true ;
            }
    
            $records = array();
            
            for($index = $start; $index <= $end ; $index++) {
                $record = array();
                $record['number'] = $index ;
                $record['href'] = $this->getPaginationURI($pageURI, $index, $isSEO);
                $record['is_number'] = ($index == $this->page) ? 1 : 0 ;
                $records[] = $record;
    
            }
            
            $view->records = $records ;
    
            //render view
            $html = '' ;
            
            printf("<div class=\"pagination\">");
            printf("<span class=\"nextprev\"> <a href=\"/\">Home</a> &nbsp;&nbsp;</span>");
            
            if($view->hasPrevious){
                printf("<span class=\"nextprev\"> <a href=\"%s\"> &nbsp; &#171; previous&nbsp;</a> </span>",$view->previousURI);
            }
            
            foreach($view->records as $record) {
                if($record['is_number'] == 1)
                    echo $record['number'];
                else
                    printf("<a href=\"%s\"> %s </a> &nbsp;",$record['href'],$record['number']);
            }
            
            if($view->hasNext){
                printf("<span class=\"nextprev\"> <a href=\"%s\">&nbsp;next&#187;&nbsp;</a> </span>",$view->nextURI);
            }
            
            printf("&nbsp;Total: %s",$view->total);
            printf("</div> <br>");
            
            
        }
        
        /**
         * @param baseURI - Seo URI without the page - like /post-title or /category/post-title
         * @param $isSeo - flag to render SEO style (/page/2) links
         *
         */
         
        function renderSeo($baseURI) {
            $html = $this->getPaginationView($baseURI,true);
            return $html ;
        }

        /**
         * @param pageURI - is full REQUEST_URI
         * 
         */
        
        function render($pageURI) {
            $html = $this->getPaginationView($pageURI,false);
            return $html ;
        }
        
        
    }

}
?>
