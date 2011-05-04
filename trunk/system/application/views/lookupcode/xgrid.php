<script type="text/javascript"  language="JavaScript">
   
function myedit(id){
    frame = parent.document.getElementById('form');
    frame.src = '<?php print site_url("lookupcode/edit/");?>' + '/' + id;
    }
function mydelete(id){
    var url = '<?php print site_url("lookupcode/delete/");?>' + '/' + id;
    ajaxSubmit.submit(url);
    document.location = document.location.href;
    }
 
</script>
<?php echo $grid;?>
