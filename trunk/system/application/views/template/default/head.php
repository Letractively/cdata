<title><?php !isset($title)? print $this->config->item("cdata_website_name") : print $this->config->item("cdata_website_name")."::".$title;?></title>
<link rel="stylesheet" type="text/css" href="<?php print  $this->config->item("yui"); ?>build/reset-fonts-grids/reset-fonts-grids.css"/>
<link rel="stylesheet" type="text/css" href="<?php print  $this->config->item("yui"); ?>build/datatable/assets/skins/sam/datatable-skin.css" />
<link rel="stylesheet" type="text/css" href="<?php print  $this->config->item("yui"); ?>build/tabview/assets/skins/sam/tabview.css">
<link rel="stylesheet" type="text/css" href="<?php print  $this->config->item("yui"); ?>build/menu/assets/skins/sam/menu.css"/>
<link rel="stylesheet" type="text/css" href="<?php print  $this->config->item("yui"); ?>build/calendar/assets/skins/sam/calendar.css"/> 
<link rel="stylesheet" type="text/css" href="<?php print  $this->config->item("yui"); ?>build/container/assets/skins/sam/container.css" />
<link rel="stylesheet" type="text/css" href="<?php print  $this->config->item("yui"); ?>yui.css" />
<script type="text/javascript" src="<?php print  $this->config->item("yui"); ?>build/yahoo-dom-event/yahoo-dom-event.js"></script>
<script type="text/javascript" src="<?php print  $this->config->item("yui"); ?>build/animation/animation-min.js"></script> 
<script type="text/javascript" src="<?php print  $this->config->item("yui"); ?>build/container/container-min.js"></script> 
<script type="text/javascript" src="<?php print  $this->config->item("yui"); ?>build/dragdrop/dragdrop-min.js"></script> 
<script type="text/javascript" src="<?php print  $this->config->item("yui"); ?>build/connection/connection-min.js"></script>
<script type="text/javascript" src="<?php print  $this->config->item("yui"); ?>build/element/element-beta-min.js"></script>
<script type="text/javascript" src="<?php print  $this->config->item("yui"); ?>build/datasource/datasource-beta-min.js"></script>
<script type="text/javascript" src="<?php print  $this->config->item("yui"); ?>build/datatable/datatable-beta-min.js"></script>
<script type="text/javascript" src="<?php print  $this->config->item("yui"); ?>build/menu/menu-min.js"></script>
<script type="text/javascript" src="<?php print  $this->config->item("yui"); ?>build/calendar/calendar-min.js"></script>
<script type="text/javascript" src="<?php print  $this->config->item("yui"); ?>build/tabview/tabview-min.js"></script>
<script type="text/javascript" src="<?php print  $this->config->item("yui"); ?>build/json/json-min.js"></script>
<script type="text/javascript" src="<?php print  $this->config->item("yui"); ?>build/charts/charts-experimental-min.js"></script>


<script type="text/javascript" src="<?php print  $this->config->item("yui"); ?>yui.js"></script>
<link href="<?php print  $this->config->item('css');?>cdata.css" rel="stylesheet" type="text/css" />
<script src="<?php print  $this->config->item('js');?>tinymce/jscripts/tiny_mce/tiny_mce.js" type="text/javascript"></script>

<script> 
 
 //shared reset search form function
 function resetForm(myform){
            f = document.forms[myform];
            for (var i=0, j=f.elements.length; i<j; i++) {
                el = f.elements[i];
                if (el.type == 'text'){
                    el.value = '';} 
                if (el.type == 'select-one'){
                    el.selectedIndex = null;
                }       
            }
            f.mysubmit.click(); 
            return false;
 }

</script> 

<script type="text/javascript">

            // Initialize and render the menu bar when it is available in the DOM

            YAHOO.util.Event.onContentReady("mainmenu", function () {

                // Instantiate and render the menu bar

                var oMenuBar = new YAHOO.widget.MenuBar("mainmenu", { autosubmenudisplay: true, hidedelay: 750, lazyload: true });

                /*
                     Call the "render" method with no arguments since the markup for 
                     this menu already exists in the DOM.
                */

                oMenuBar.render();

            });
</script>
<script type="text/javascript">
<!--

var bookmark = {
    
   init: function() {
   },
   
   submit: function(url) {
    var cObj = YAHOO.util.Connect.asyncRequest('GET', url, bookmark.ajax_callback_add);
   },
   
   ajax_callback_add:{   
       //response
       success: function(o) {                                                                                                                                       
           alert( o.responseText);           
       },
       
       failure: function(o) { 
        //alert('An error has occurred');
      }
    }
    
};

var ajaxSubmit = {
    
   init: function() {
   },
   
   submit: function(url) {
    var cObj = YAHOO.util.Connect.asyncRequest('GET', url, ajaxSubmit.ajax_callback_add);
   },
   
   ajax_callback_add:{   
       //response
       success: function(o) {                                                                                                                                       
           alert( o.responseText);           
       },
       
       failure: function(o) { 
        //alert('An error has occurred');
      }
    }
    
};


//-->
</script>
