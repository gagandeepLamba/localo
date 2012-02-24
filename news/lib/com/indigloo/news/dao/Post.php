<?php

namespace com\indigloo\news\dao {

    
    use \com\indigloo\Util as Util ;
    use \com\indigloo\news\mysql as mysql;
    use \com\indigloo\seo\StringUtil as SeoStringUtil ;
     use \com\indigloo\Configuration as Config ;
     
    class Post {

        function create($title,$summary,$description,
                        $linksJson,$imagesJson,$userId,$userName) {
            
            $seoTitle = SeoStringUtil::convertNameToSeoKey($title);
            $data = mysql\Post::create($title,$seoTitle,$summary,$description,
                                       $linksJson,$imagesJson,$userId,$userName);
            return $data ;
        }
        
        function createLink($author,$link,$description) {
            $data = mysql\Post::createLink($author,$link,$description);
            return $data ;
        }
        
        function update($postId,$title,$summary,$description,$linksJson,$imagesJson) {
            Util::isEmpty('post_id',$postId);
            $seoTitle = SeoStringUtil::convertNameToSeoKey($title);
            $data = mysql\Post::update($postId,$title,$seoTitle,$summary,$description,$linksJson,$imagesJson);
            return $data ;
        }
        
        function updateLinkState($linkIds,$state) {
            if(empty($linkIds)) {
                return ;
            }
            
            $code = mysql\Post::updateLinkState($linkIds,$state);
            return $code ;
            
        }
        
        function getRecordOnId($postId) {
            $row = mysql\Post::getRecordOnId($postId);
            return $row ;
        }
        
        function getRecordOnShortId($shortId) {
            $row = mysql\Post::getRecordOnShortId($shortId);
            return $row ;
        }
        
        function getLatestRecords($count) {
            
            $rows = mysql\Post::getLatestRecords($count);
            return $rows ;

        }
        
        function getLatestLinks() {
            $pageSize = Config::getInstance()->get_value("admin.dashboard.records");
            $rows = mysql\Post::getLatestLinks($pageSize);
            return $rows ;

        }
        
        function getRecords($paginator) {
			$params = $paginator->getDBParams();
			$count = $paginator->getPageSize();

			if($paginator->isHome()){
				return $this->getLatestRecords($count);

			}else {
				//convert back to base10
				$start = $params['start'];
				$direction = $params['direction'];

				if(empty($start) || empty($direction)){
					trigger_error('No start or direction DB params in paginator', E_USER_ERROR);
				}

				$start = base_convert($start,36,10);
				$rows = mysql\Post::getRecords($start,$direction,$count);

				return $rows ;
			}
        }
        
        function getLinks($start,$direction) {
            $pageSize = Config::getInstance()->get_value("admin.dashboard.records");
            $rows = mysql\Post::getLinks($start,$direction,$pageSize);
            return $rows ;

        }
        
        function getRecordsCount() {
            $row = mysql\Post::getRecordsCount();
            return $row['count'] ;
        }
        
        function getLinksCount() {
            $row = mysql\Post::getLinksCount();
            return $row['count'] ;
        }
        
    }

}
?>
