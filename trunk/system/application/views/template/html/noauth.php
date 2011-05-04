<h1>You don't have the permission to access the page</h1>

<?php if($this->cdata_user->is_logged()):?>

  You are logged as: <?php echo $this->cdata_user->get_user_data("user_name");?>, user-id: <?php echo $this->cdata_user->get_user_id();?>
  
  <?php if($this->cdata_user->check_role(2)):?> 
    (administrator) 
  <?php endif;?> | 
  
  <?php echo anchor("user/logout","Log Out");?> 
  
<?php else:?>

  You are not logged in, <?php echo anchor("user/login","Log in");?>

<?php endif;?> 