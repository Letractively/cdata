<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php print $head;?>
<style> 
#custom-doc {
    margin:auto;text-align:left; /* leave unchanged */
    width:46.15em;/* non-IE */
    *width:45.04em;/* IE */
    min-width:600px;/* optional but recommended */
}
</style>
</head>
<body class="yui-skin-sam" id="cdata" style="background-color: transparent;">
<div id="custom-doc">                 
    <div id="bd">
        <div class="content"  style="background-color: transparent;">
            <?php print $contents;?>  
        </div>      
    </div>
</div>
</body>
<?php print $js_footer;?>
<script type="text/javascript" src="<?php print  $this->config->item("js"); ?>cdata.js"></script>
</html>    
