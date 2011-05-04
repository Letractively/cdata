<h3>Add Code</h3>
<?php echo $this->form->generate_form();?>
       
<script type="text/javascript" language="Javascript">
var formSubmit = {
   
   updateList: function(e){
        var mylist = window.parent.document.getElementById("list");
        mylist.src = mylist.src;
   },
    
};
YAHOO.util.Event.addListener(window, 'load', formSubmit.updateList);
</script>