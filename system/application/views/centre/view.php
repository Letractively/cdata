
  <div>

    <h2>Centre</h2>


    <?php echo $this->form->generate_view();?>
    
    <p>
    <input type="button" value="Edit" onClick="location.href = '<?php print site_url("centre/edit/$id");?>';"/>
    <input type="button" value="Delete" onClick="checkDelete('<?php print site_url("centre/delete/$id");?>', true);"/>
    </p>  
  </div>
