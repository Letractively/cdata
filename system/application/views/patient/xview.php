<?php print $breadcrumb;?>
<h2>Patient</h2>
<?php print $view;?>
<p>
<input type="button" onClick="location.href=('<?php print site_url('patient/edit/')."/$id";?>')" value="Edit" />
<input type="button" value="Admin" onClick="location.href = '<?php print site_url("patient/admin/$id");?>';"/>
<input type="button" value="Report" onClick="location.href = '<?php print site_url("patient/report/$id");?>';"/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="Bookmark" onClick="bookmark.submit('<?php print site_url("bookmark/create/patient/$id");?>');"/>
<input type="button" value="Subscribe" onClick="location.href = '<?php print site_url("subscription/create/patient/$id");?>';"/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="Print" onClick="location.href = '<?php print site_url("patient/xprint/$id");?>';"/>  
</p> 
<?php print $childInterface;?>