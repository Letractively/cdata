<?php print $breadcrumb;?>
<h2>File</h2>
<?php print $view;?>
<p>
<input type="button" value="Edit" onClick="location.href = '<?php print site_url("$class/edit/$id");?>';"/> 
<input type="button" value="Delete" onClick="checkDelete('<?php print site_url("$class/delete/$id");?>', true);"/>
<input type="button" value="Move" onClick="location.href = '<?php print site_url("admin/move/$class/$id");?>';"/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="Bookmark" onClick="bookmark.submit('<?php print site_url("bookmark/create/$class/$id");?>');"/>
<input type="button" value="Subscribe" onClick="location.href = '<?php print site_url("subscription/create/$class/$id");?>';"/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="Print" onClick="location.href = '<?php print site_url("file/xprint/$id");?>';"/>
</p>
<?php print $childInterface;?>