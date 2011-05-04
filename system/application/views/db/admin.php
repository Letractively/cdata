<h1>Database <?php print $dbname?> administration</h1>

<p>
<input type="button" value="Export" onClick="location.href = '<?php print site_url("admin/exportXml/db/$id");?>';"/> Export data in XML format Excel (2003 or newer) <br/>
<input type="button" value="Move" onClick="location.href = '<?php print site_url("admin/move/$class/$id");?>';"/> Move the database <br/>
</p>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<p>
<!--
<input type="button" value="Delete" onClick="checkDelete('<?php print site_url("$class/delete/$id");?>', true);"/> Delete all the data <b>*Attention: deleted data cannot be recovered*</b><br/>
</p>
--> 
<p>
<a href="<?php print site_url("db/xview/$id");?>">Back</a>
</p>  




