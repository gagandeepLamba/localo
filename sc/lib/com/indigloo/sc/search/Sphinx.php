<?php

namespace com\indigloo\sc\search {

    use \com\indigloo\Util as Util ;
    use \com\indigloo\Logger as Logger ;
    use \com\indigloo\Configuration as Config ;
    
    class Sphinx {

		private $cl ;

		function __construct() {
			$this->cl = new \SphinxClient();
			$this->cl->SetServer('127.0.0.1', 9312);

			//offset,limit
			$this->cl->SetLimits(0,10);
			$this->cl->SetMaxQueryTime(3000);
			$this->cl->SetMatchMode(SPH_MATCH_PHRASE);
			$this->cl->SetSortMode(SPH_SORT_RELEVANCE);
		}


		function query($token) {
			$data = array("total" => 0 ,"ids" => array());
			
			$result = $this->cl->Query($token, 'posts' );	
			if ( $result === false ) {
				Logger::getInstance()->error($this->cl->GetLastError()) ;
				return $data ;
			} else {
				if ( $this->cl->GetLastWarning() ) {
					Logger::getInstance()->error($this->cl->GetLastWarning()) ;
					return $data ;
				}

				if ( ! empty($result["matches"]) ) {
					$data["total"]  = $result["total"] ;
					
					foreach ( $result["matches"] as $docId => $docinfo ) {
						$data["ids"][] = $docId ;
					}
				}
			}

			return $data ;
		} //query

    }

}
?>
