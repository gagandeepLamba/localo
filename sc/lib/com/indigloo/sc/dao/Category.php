<?php

namespace com\indigloo\sc\dao {

    
    use \com\indigloo\Util as Util ;
    use \com\indigloo\sc\mysql as mysql;
    use \com\indigloo\seo\StringUtil as SeoStringUtil ;
    
    class Category {

		function getAll() {
			$rows = array();
			$rows["Baby"] = "baby.jpeg" ;
			$rows["Cars"] = "cars.jpeg" ;
			$rows["Camera"] = "camera.jpeg" ;
			$rows["Clothes"] = "Clothes.jpeg" ;
			$rows["Mobile"] = "mobile.jpeg" ;
			
			$rows["Computer"] = "computer.jpeg" ;
			$rows["Home"] = "home.jpeg" ;
			$rows["Other"] = "other.jpeg" ;
			
			return $rows ;
		}
		
        
    }

}
?>
