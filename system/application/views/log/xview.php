<?php print $breadcrumb;?>
<div id="mainView">
<IFRAME vspace="0" hspace="0" frameborder="0" width="930px" height="300px" onLoad="iframeResize(this);" 
       src="<?php print site_url('todo/view/')."/$id";?>" title="View">            
</IFRAME>
</div>
<?php print $childInterface;?>