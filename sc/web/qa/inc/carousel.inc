<!-- include bootstrap carousel -->
<div id="myCarousel" class="carousel">
  <!-- Carousel items -->
  <div class="carousel-inner">
            <?php
                $strItem = '<div class="item {active}"> <img src="/{bucket}/{storedName}"></div>';
				$count = 0 ;
				
                foreach($images as $image) {
					$active = ($count == 0) ? 'active' : '' ;
                    $item = str_replace(array(0 => "{bucket}", 1 => "{storedName}", 2=>"{active}"),
                                        array(0 => $image->bucket, 1 => $image->storeName, 2=> $active),
                                        $strItem);
                    echo $item;
					$count++ ;
                    
                }
            
            ?>
  </div>
  <!-- Carousel nav -->
  <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
  <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
</div> <!-- carousel -->
