<h2>User</h2>

<?php echo $this->form->generate_view();?>
    
<p>
<input type="button" onClick="location.href=('<?php print site_url("user/edit/$id");?>')" value="Edit" />
<input type="button" value="Delete" onClick="checkDelete('<?php print site_url("user/delete/$id");?>', true);"/>
<input type="button" onClick="location.href=('<?php print site_url("user/xgrid");?>')" value="List" />
</p>  
