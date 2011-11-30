<!-- include media slider -->
<div id="slider-code">
    <a href="#" class="buttons prev">&nbsp;</a>
    <div class="viewport">
        <ul class="overview">
            <?php
                $strItem = ' <li><img src="/{bucket}/{storedName}"></li> ';
                
                foreach($mediaDBRows as $mediaDBRow) {
                    $item = str_replace(array(0 => "{bucket}", 1 => "{storedName}"),
                                        array(0 => $mediaDBRow['bucket'], 1 => $mediaDBRow['stored_name']),
                                        $strItem);
                    echo $item;
                    
                }
            
            ?>
            
        </ul>
    </div>
    <a href="#" class="buttons next">&nbsp;</a>
    <ul class="pager">
        <?php
            for($i = 0 ; $i < sizeof($mediaDBRows) ; $i++) {
                echo '<li><a rel="'.$i.'" class="pagenum" href="#">'.($i+1).'</a></li>' ;
            }
        
        ?>
        
    </ul>
</div> <!-- slider -->
                            