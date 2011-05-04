<script type="text/javascript"  language="JavaScript">
   
function myedit(id){
    frame = parent.document.getElementById('fieldForm');
    frame.src = '<?php print site_url("field/edit/");?>' + '/' + id;
    }
function mydelete(id){
    var url = '<?php print site_url("field/delete/");?>' + '/' + id;
    ajaxSubmit.submit(url);
    document.location = document.location.href;
    }
 
</script>
<?php echo $grid;?>
