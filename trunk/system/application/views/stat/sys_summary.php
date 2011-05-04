<h2>System summary</h2>

<table class="cdata_view_table">
<tr>
<th>Module</th><th>#Records</th>
</tr>
<?php foreach($stat as $key=>$prop){
	print "<tr>";	
	print "<td class=\"cdata_view_table_label\">".$prop["name"]."</td><td class=\"cdata_view_table_value\">".$prop["tot"]."</td>";	
	print "</tr>";	
}
?>
</table>