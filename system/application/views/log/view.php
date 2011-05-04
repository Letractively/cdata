<?php echo $this->form->generate_view();?>
<input type="button" value="Delete" onClick="parent.location.href = '<?php print site_url("$class/delete/$id");?>';"/>

