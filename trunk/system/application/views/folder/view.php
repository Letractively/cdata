<?php echo $this->form->generate_view();?>
<p>
<input type="button" onClick="location.href=('<?php print site_url('folder/edit/')."/$id";?>')" value="Edit" />
<input type="button" onClick="checkDelete('<?php print site_url('folder/delete/')."/$id";?>', true)" value="Delete" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="Bookmark" onClick="bookmark.submit('<?php print site_url("bookmark/create/folder/$id");?>');"/>
</p> 
