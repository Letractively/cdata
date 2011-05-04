<?php echo $this->form->generate_view();?>
<p>
<input type="button" value="Edit" onClick="location.href = '<?php print site_url("$class/edit/$id");?>';"/> 
<input type="button" value="Delete" onClick="checkDelete('<?php print site_url("$class/delete/$id");?>', true);"/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="Bookmark" onClick="bookmark.submit('<?php print site_url("bookmark/create/pform/$id");?>');"/>
<input type="button" value="Subscribe" onClick="location.href = '<?php print site_url("subscription/create/$class/$id");?>';"/>
</p>

