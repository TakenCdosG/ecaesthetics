<form id="search" class="form-inline search-form" action="<?php home_url();?>" method="get" enctype="multipart/form-data">
    <label class="sr-only" for="appendedInputButton">Search</label>
    <input id="appendedInputButton" class="form-control" name="s" type="text" onblur="if(this.value=='') this.value='Search...'" onfocus="if(this.value=='Search...') this.value=''" value="Search..." size="16">
    <button class="btn btn-info search-btn" type="submit" value="" name="submit"><i class="fa fa-search"></i></button>
</form>
<div class="clear"></div>
