<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Pragma" content="no-cache">
<title><?php print $title;?></title>                                                    
</head>
<body>
<style>
        #header {margin-bottom: 20px; font-weight: bold;}
        .label {font-weight: bold; padding-right: 15px;}
        .footer {}
        
        a {text-decoration: none;}
        
</style>
<div id="doc2">                 
    <div id="hd">
        <div id="header">
        <?php print $this->config->item("cdata_website_name");?> 
        </div>
    </div>
    <div id="bd">
        <div class="content">
            <?php print $contents;?>  
        </div>      
    </div>
    <div id="ft" class="footer">
      
    </div>    
</div>
</body>

</html>    
