<title><?php !isset($title)? print $this->config->item("cdata_website_name") : print $this->config->item("cdata_website_name")."::".$title;?></title>

<link rel="stylesheet" type="text/css" href="<?php print  $this->config->item("yui"); ?>yui.css" />
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
