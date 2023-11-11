
            <option value="">Select Category</option> 
            <?php foreach($category as $m){ ?>
            <?php if($m['categoryid']==$sel){ ?>
            <option value="<?php echo $m['categoryid'];?>" selected><?php echo $m['category_name'];?></option>
            <?php }else{ ?>
            <option value="<?php echo $m['categoryid'];?>"><?php echo $m['category_name'];?></option>
            <?php } }?>
