<form action="" method="get" class="" autocomplete="off" novalidate="">
    <div class="row clearfix">
        <?php
        $ageurl     =   $this->session->userdata("arr".$pageurl);
        $keyw       =   (is_array($ageurl) && array_key_exists("keywords", $ageurl))?$ageurl["keywords"]:"";
        ?>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
            <select class="form-control form-control-sm limitvalue select2" name="limitvalue" onchange="searchFilter('','<?php echo $urlvalue;?>')">
                <?php $climit    =   $this->config->item("limit_values");
                foreach($climit as $ce){
                ?>
                <option value="<?php echo $ce;?>"><?php echo $ce;?></option>
                <?php
                }
                ?> 
            </select>  
        </div> 
        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
            <div class="form-group">
                <input type="text" id="FilterTextBox" value="<?php echo $keyw;?>" class="form-control" placeholder="Search" >
                <input type="hidden" id="orderby" name="orderby" value="<?php echo isset($orderby)?$orderby:'';?>">
                <input type="hidden" id="tipoOrderby" name="tipoOrderby" value="<?php echo isset($tipoOrderby)?$tipoOrderby:'';?>">
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
            <div class="form-group">
                <button type="button" class="btn btn-sm btn-primary" onclick="loadpage()"> <i class="mdi mdi-search-web"></i> Search </button>
                <button type="button" class="btn btn-sm btn-warning" onclick="clearfilter('<?php echo $pageurl;?>')"> <i class="mdi mdi-search-web"></i> Clear Filter </button>
              	<?php if(isset($rview)) { ?>
              	<button type="submit" class="btn btn-sm btn-success" title="Excel Report" name="search" value="Excel">
                    <i class="fas fa-file-excel"></i> &nbsp;Excel
                </button>
              	<?php } ?>
            </div>
        </div>
    </div>
    <div class="row">
        <input type="hidden" id="urlvalue" name="urlvalue" value="<?php echo $urlvalue;?>"> 
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php $this->load->view("loader");?>  
            <div class="postList"></div>
        </div>
    </div>
</form>