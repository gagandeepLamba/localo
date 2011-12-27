<?php

namespace com\indigloo\ui {

    Use \com\indigloo\Url as Url ;
    
    class Pagination {
        
        private $pageNo ;
        
        function __construct($pageNo) {
            
            $this->pageNo = $pageNo ;
            
            if(empty($this->pageNo)) {
                $this->pageNo = 1 ;
            }
            
            if($pageNo <= 0) {
                $this->pageNo = 1 ;
            }
        }
        
        function hasNext() {
            if($this->pageNo <= 20 ) {
                return true ;
            } else {
                return false ;
            }
        }
    
        function nextPage() {
            return $this->pageNo + 1 ;
        }
        
        function hasPrevious() {
            if($this->pageNo > 1 ) {
                return true ;
            }else {
                return false ;
            }
    
        }
    
        function previousPage() {
            return $this->pageNo - 1 ;
        }
            
        function render($pageURI,$start,$end) {
            
            if(empty($start) || empty($end)) {
                return '' ;
            }
            
            printf("<div class=\"pagination\">");
            printf("<span class=\"nextprev\"> <a href=\"/\">Home</a> &nbsp;&nbsp;</span>");
            
            if($this->hasPrevious()){
                //convert to base36
                $start = base_convert($start,10,36) ;
                $bparams = array('before' => $start, 'pageNo' => $this->previousPage());
                $previousURI = Url::addQueryParameters($pageURI,$bparams);
                printf("<span class=\"nextprev\"> <a href=\"%s\">&lt;&nbsp;Previous</a> </span>",$previousURI);
            }
            
            if($this->hasNext()){
                $end = base_convert($end,10,36) ;
                $nparams = array('after' => $end, 'pageNo' => $this->nextPage()) ;
                $nextURI = Url::addQueryParameters($pageURI,$nparams);
                printf("<span class=\"nextprev\"> <a href=\"%s\">&nbsp;Next&nbsp;&gt;</a> </span>",$nextURI);
            }
            
            printf("</div> <br>");
            
        }
        
        
    }

}
?>
