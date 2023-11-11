<html>
    <body>
                <?php
        if(is_array($images) && count($images) >0 ){
            echo '<i class="icon ion-close"  onclick="window.close();></i><a onclick="window.close();">Click Here to Close</a>';
            foreach($images as $i){
                ?>
                <img src="<?php echo $i->image;?>"/>
                <?php
            }
        }else{
            echo 'No Reports Available<br><br>';
            echo '<a onclick="window.close();">Click Here to Close</a>';
        }
        ?>
    </body>
</html>
