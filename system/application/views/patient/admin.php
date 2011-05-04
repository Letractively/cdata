<h1>Patient <?php print $name?> administration</h1>

<p>
Export data in XML format Excel (2003 or newer) 
<input type="button" value="Export" onClick="location.href = '<?php print site_url("admin/exportXml/patient/$id");?>';"/><br/>
Move the patient <input type="button" value="Move" onClick="location.href = '<?php print site_url("admin/move/patient/$id");?>';"/><br/>
</p>
<p>
<!--
Delete all the data <b>*Attention: data and files will be deleted and cannot be recovered*</b> <input type="button" value="Delete" onClick="checkDelete('<?php print site_url("patient/delete/$id");?>', true);"/><br/>
--></p>   
<p>
<a href="<?php print site_url("patient/xview/$id");?>">Back</a>
</p>  




