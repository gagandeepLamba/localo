<?php

namespace com\indigloo\ui {

    Use \com\indigloo\Url as Url ;
    
    class Pagination {
        
        private $pageNo ;
        private $totalPages ;
        
        function __construct($pageNo,$totalPages) {
            
            if(empty($pageNo) || ($pageNo <= 0) || ($pageNo > $totalPages)) {
                $this->pageNo = 1 ;
            } else {
                $this->pageNo = $pageNo ;
            }
            
            $this->totalPages = $totalPages;
            
        }
        
        function hasNext() {
            if(($this->pageNo < $this->totalPages) && ($this->pageNo <= 20)) {
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
            
            //convert to base36
            $start = base_convert($start,10,36) ;
            $end = base_convert($end,10,36) ;
             
            printf("<div class=\"pagination\">");
            printf("<span class=\"nextprev\"> <a href=\"/\">Home</a> &nbsp;&nbsp;</span>");
            
            if($this->hasPrevious()){
               
                $bparams = array('before' => $start, 'pageNo' => $this->previousPage());
                $previousURI = Url::addQueryParameters($pageURI,$bparams);
                printf("<span class=\"nextprev\"> <a href=\"%s\">&lt;&nbsp;Previous</a> </span>",$previousURI);
            }
            
            if($this->hasNext()){
               
                $nparams = array('after' => $end, 'pageNo' => $this->nextPage()) ;
                $nextURI = Url::addQueryParameters($pageURI,$nparams);
                printf("<span class=\"nextprev\"> <a href=\"%s\">&nbsp;Next&nbsp;&gt;</a> </span>",$nextURI);
            }
            
            printf("</div> <br>");
            
        }
        
        
    }

}
?>
