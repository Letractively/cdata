<h2>Form</h2>
    
    <?php echo $this->form->generate_view();?>
    
    <p>
    <input type="button" onclick="document.location = '<?php print site_url("cdform/edit/".$id); ?>'" value="Edit"/> 
    <input type="button" onclick="document.location = '<?php print site_url("cdform/create_nv/".$id); ?>'" value="New Version"/>
    <input type="button" onclick="document.location = '<?php print site_url("cdform/duplicate/".$id); ?>'" value="Duplicate"/>
    <input type="button" onclick="document.location = '<?php print site_url("cdform/xgrid"); ?>'" value="Back to List"/>
    <input type="button" onclick="checkDelete('<?php print site_url("cdform/delete/".$id); ?>');" value="Delete"/>
    </p>  
    
<div id="model" style="border: 1px solid black; padding: 10px;">   
	<h2>Model</h2> 
	    <p>
	    <input type="button" onclick="ajaxSubmit.submit('<?php print site_url("cdform/generate/".$id); ?>')" value="Update Model"/>
	    [ update the model if you edit the fields ]
	    </p>
	    
	<div id="childTab" class="yui-navset">
	        <ul class="yui-nav">
				<li class="selected"><a href="#lisdiv"><em>List</em></a></li>
				<li class=""><a href="#formdiv"><em>Form</em></a></li>               
	        </ul>
	        <div class="yui-content">
	            <div id="listdiv">
				     <IFRAME vspace="0" id="fieldList" name="fieldList" hspace="0" frameborder="0" width="100%" height="700px"  
					  scrolling="auto" src="<?php print site_url("field/xgrid/$id");?>" title="List">            
					 </IFRAME>           
	            </div> 
	            <div id="formdiv">
					<IFRAME vspace="0" id="fieldForm" name="fieldForm" hspace="0" frameborder="0" width="100%" height="700px" 
					  scrolling="auto" src="<?php print site_url("field/create/$id");?>" title="Form">            
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
