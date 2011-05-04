<h1>Home</h1>

  <div>

<h2>Cdata</h2>
Clinical Database Application

<h2>User Status</h2>
<?php if($this->cdata_user->is_logged()):?>

  you are logged as: <?php echo $this->cdata_user->get_user_data("user_name");?> [ <?php echo anchor("user/logout","Log Out");?> ] 
  <h2>Application</h2>
  <p>
  <input type="button" onclick="document.location = '<?php print site_url("root/xview");?>';" value = "Start"/>
  </p>
  
<?php else:?>

  you are not logged in, <?php echo anchor("user/login","Log in");?>

<?php endif;?> 