<h2>Patient</h2>
<?php print $view;?>
<p>
<input type="button" onClick="location.href=('<?php print site_url('patient/edit/')."/$id";?>')" value="Edit" />
<input type="button" onClick="checkDelete('<?php print site_url('patient/delete/')."/$id";?>', true)" value="Delete" />
<input type="button" value="Move" onClick="location.href = '<?php print site_url("admin/move/patient/$id");?>';"/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="Bookmark" onClick="bookmark.submit('<?php print site_url("bookmark/create/patient/$id");?>');"/>
</p> 
 
    
