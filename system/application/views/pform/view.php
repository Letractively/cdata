<h2>Form</h2>
    <?php print $view;?>
<p>
<input type="button" value="Edit" onClick="location.href = '<?php print site_url("pform/edit/$id");?>';"/>
<input type="button" value="Delete" onClick="checkDelete('<?php print site_url("pform/delete/$id");?>', true);"/>
<input type="button" value="Move" onClick="location.href = '<?php print site_url("admin/move/pform/$id");?>';"/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="Bookmark" onClick="bookmark.submit('<?php print site_url("bookmark/create/pform/$id");?>');"/>
</p> 