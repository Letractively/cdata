<h2>User Groups</h2>


    <?php echo $this->form->generate_view();?>
    
    <p>
    <input type="button" onClick="location.href=('<?php print site_url('usergroup/edit/')."/$id";?>')" value="Edit" />
    <input type="button" onClick="checkDelete('<?php print site_url('usergroup/delete/')."/$id";?>')" value="Delete" />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="button" onClick="location.href=('<?php print site_url('usergroup/xgrid')."/$id";?>')" value="List" />
    </p>  
 