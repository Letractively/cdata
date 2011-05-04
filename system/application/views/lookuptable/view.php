<h2>Lookup Table</h2>
    <?php echo $this->form->generate_view();?>
<input type="button" value="Edit" onClick="location.href = '<?php print site_url("lookuptable/edit/$id");?>';"/>
<input type="button" value="Delete" onClick="checkDelete('<?php print site_url("lookuptable/delete/$id");?>');"/>
 <input type="button" value="List" onClick="location.href = '<?php print site_url("lookuptable/xgrid");?>';"/>
 <br/>
 
<div id="model" style="border: 1px solid black; padding: 10px;">   
	<h2>Lookup Codes</h2> 
	<div id="childTab" class="yui-navset">
	        <ul class="yui-nav">
				<li class="selected"><a href="#listdiv"><em>List</em></a></li>
				<li class=""><a href="#formdiv"><em>Form</em></a></li>               
	        </ul>
	        <div class="yui-content">
	            <div id="listdiv">
				     <IFRAME vspace="0" id="list" name="list" hspace="0" frameborder="0" width="100%" height="500px"  
					  scrolling="auto"  src="<?php print site_url("lookupcode/xgrid/$id");?>" title="List">            
					 </IFRAME>          
	            </div> 
	            <div id="formdiv">
					<IFRAME vspace="0" id="form" name="form" hspace="0" width="650px" frameborder="0" height="500px" 
					  scrolling="no" width="100%"    src="<?php print site_url("lookupcode/create/$id");?>" title="Form">            
					</IFRAME>               
	            </div>                          
	        </div>
	</div>
</div>
<script>
(function() {
        var childTab = new YAHOO.widget.TabView('childTab');
    })();
</script>


