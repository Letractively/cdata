<?php print $breadcrumb;?>
<h2>Database</h2>
<?php print $view;?>
<p>
<input type="button" value="Edit" onClick="location.href = '<?php print site_url("$class/edit/$id");?>';"/>
<input type="button" value="Report" onClick="location.href = '<?php print site_url("db/report/$id");?>';"/>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="Bookmark" onClick="bookmark.submit('<?php print site_url("bookmark/create/$class/$id");?>');"/>
<input type="button" value="Subscribe" onClick="location.href = '<?php print site_url("subscription/create/$class/$id");?>';"/>
<input type="button" value="Admin" onClick="location.href = '<?php print site_url("db/admin/$id");?>';"/>
</p> 
<?php print $childInterface;?>
