<?php  if($this->session->flashdata("err") != ""){?>
<div role="alert" class="alert alert-danger alert-dismissible">
    <button type="button" data-dismiss="alert" aria-label="Close" class="close">
       <span aria-hidden="true">×</span>
    </button>
    <?php 
        echo $this->session->flashdata("err");
        echo $this->session->unset_flashdata("err");
    ?>
</div>
<?php  } if($this->session->flashdata("info") != ""){?>
<div role="alert" class="alert alert-info alert-dismissible">
    <button type="button" data-dismiss="alert" aria-label="Close" class="close">
       <span aria-hidden="true">×</span>
    </button>
    <?php 
        echo $this->session->flashdata("info");
        echo $this->session->unset_flashdata("info");
    ?>
</div>
<?php } if($this->session->flashdata("suc") != ""){?>
<div role="alert" class="alert alert-success alert-dismissible">
    <button type="button" data-dismiss="alert" aria-label="Close" class="close">
       <span aria-hidden="true">×</span>
    </button>
    <?php 
        echo $this->session->flashdata("suc");
        echo $this->session->unset_flashdata("suc");
    ?>
</div>
<?php } if($this->session->flashdata("war") != ""){?>
<div role="alert" class="alert alert-warning alert-dismissible fade in">
    <button type="button" data-dismiss="alert" aria-label="Close" class="close">
       <span aria-hidden="true">×</span>
    </button>
    <?php 
        echo $this->session->flashdata("war");
        echo $this->session->unset_flashdata("war");
    ?>
</div>
<?php } ?>