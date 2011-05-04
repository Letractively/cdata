<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Pragma" content="no-cache">
<?php print $head;?>
</head>
<body class="yui-skin-sam" id="cdata">
<?php print $js;?>

<div id="doc2">                 
    <div id="hd">
        <div id="header">
        <?php print $this->config->item("cdata_website_name");?> 
        </div>
        <div class="menu">
        <?php print $menu;?>
        </div>
    </div>
    <div id="bd">
        <div class="content">
            <?php print $contents;?>  
        </div>      
    </div>
    <div id="ft" class="footer">
        <?php print $footer;?> <br/><i>Page created in {elapsed_time} sec</i>        
    </div>    
</div>
</body>
<?php print $js_footer;?>
<script type="text/javascript" src="<?php print  $this->config->item("js"); ?>cdata.js"></script>
</html>    
