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
            
        function render($homeURI,$startId,$endId) {
            
            if(empty($startId) || empty($endId)) {
                return '' ;
            }
            
            //convert to base36
            $startId = base_convert($startId,10,36) ;
            $endId = base_convert($endId,10,36) ;
             
            printf("<div class=\"pagination\">");
            printf("<span class=\"nextprev\"> <a href=\"%s\">Home</a> &nbsp;&nbsp;</span>",$homeURI);
            
            if($this->hasPrevious()){
               
                $params = Url::getQueryParams($_SERVER['REQUEST_URI']);
                $bparams = array('before' => $startId, 'pageNo' => $this->previousPage());
                
                $q = array_merge($params,$bparams);
                $ignore = array('after');
                
                $previousURI = Url::addQueryParameters($homeURI,$q,$ignore);
                printf("<span class=\"nextprev\"> <a href=\"%s\">&lt;&nbsp;Previous</a> </span>",$previousURI);
            }
            
            if($this->hasNext()){
                $params = Url::getQueryParams($_SERVER['REQUEST_URI']); 
                $nparams = array('after' => $endId, 'pageNo' => $this->nextPage()) ;
                $q = array_merge($params,$nparams);
                
                $ignore = array('before');
                $nextURI = Url::addQueryParameters($homeURI,$q,$ignore);
                printf("<span class=\"nextprev\"> <a href=\"%s\">&nbsp;Next&nbsp;&gt;</a> </span>",$nextURI);
            }
            
            printf("</div> <br>");
            
        }
        
        
    }

}
?>
