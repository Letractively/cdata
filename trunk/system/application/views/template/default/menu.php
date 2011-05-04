<?php 
$access = $this->cdata_user->permission("app", "access"); 
$admin = $this->cdata_user->permission("app", "admin"); 
$user = $this->cdata_user->permission("app", "user"); 
$role = $this->cdata_user->get_role();
?>
<div id="mainmenu" class="yuimenubar yuimenubarnav">
    <div class="bd">

        <ul class="first-of-type">
            <li class="yuimenubaritem first-of-type"><a class="yuimenubaritemlabel" href="<?php echo site_url('');?>">Home</a>
                <?php if($role > 0){ ?>                    
                <div id="home" class="yuimenu">
                    <div class="bd">
                        <ul>
                           <li class="yuimenuitem"><a class="yuimenuitemlabel" href="<?php echo site_url('root/xview');?>">Start</a></li>                                    </ul>
                    </div>
                </div>      
                <?php } ?>
            </li>                      
            <?php if($admin == true OR $user == true){ ?>
            <li class="yuimenubaritem first-of-type"><a class="yuimenubaritemlabel" href="#">Admin</a>

                <div id="admin" class="yuimenu">
                    <div class="bd">
                        <ul>
                        	<?php if($admin == true){ ?>
                        	<li class="yuimenuitem"><a class="yuimenuitemlabel" href="#">System</a>                            
                                <div id="systemadm_blk" class="yuimenu">
                                    <div class="bd">
                                        <ul class="first-of-type">   
                                        
                                        	<li class="yuimenuitem"><a class="yuimenuitemlabel" href="#">Statistics</a>                            
				                                <div id="statsadm" class="yuimenu">
				                                    <div class="bd">
				                                        <ul class="first-of-type">
				                                            <li class="yuimenuitem"><a class="yuimenuitemlabel" 
																href="<?php echo site_url('stat/sys');?>">Application</a></li>
                                                            <li class="yuimenuitem"><a class="yuimenuitemlabel" 
                                                                href="<?php echo site_url('stat/db');?>">Database</a></li>
				                                        </ul>            
				                                    </div>
				                                </div>                                                
				                            </li> 
                                            <li class="yuimenuitem"><a class="yuimenuitemlabel" 
                                                                href="<?php echo site_url('admin/main');?>">Administration</a>
                                            </li> 
                                        
                           	 			</ul>            
                                    </div>
                                </div>                                                
                            </li>        
                            <?php }?>	
                            <?php if($admin == true OR $user == true){ ?>                    
                        	<li class="yuimenuitem"><a class="yuimenuitemlabel" href="#">User</a>                            
                                <div id="useradm_blk" class="yuimenu">
                                    <div class="bd">
                                        <ul class="first-of-type">                                        	                                        				                            
                                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="#">User</a>                            
				                                <div id="useradm" class="yuimenu">
				                                    <div class="bd">
				                                        <ul class="first-of-type">
				                                            <li class="yuimenuitem"><a class="yuimenuitemlabel" 
																	href="<?php echo site_url('user/xgrid');?>">List</a></li>
				                                            <li class="yuimenuitem"><a class="yuimenuitemlabel" 
																	href="<?php echo site_url('user/create');?>">Add</a></li>
				                                        </ul>            
				                                    </div>
				                                </div>                                                
				                            </li>
				                            
				                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="#">Group</a>                            
				                                <div id="groupadm" class="yuimenu">
				                                    <div class="bd">
				                                        <ul class="first-of-type">
				                                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="<?php echo site_url('usergroup/xgrid');?>">List</a></li>
				                                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="<?php echo site_url('usergroup/create');?>">Add</a></li>
				                                        </ul>            
				                                    </div>
				                                </div>                                                
				                            </li>
				                            
				                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="#">Role</a>                            
				                                <div id="roleadm" class="yuimenu">
				                                    <div class="bd">
				                                        <ul class="first-of-type">
				                                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="<?php echo site_url('role/xgrid');?>">List</a></li>
				                                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="<?php echo site_url('role/create');?>">Add</a></li>
				                                        </ul>            
				                                    </div>
				                                </div>                                                
				                            </li>
				                            <?php if($admin == true){ ?> 
				                             <li class="yuimenuitem"><a class="yuimenuitemlabel" href="#">Permission</a>                            
				                                <div id="permissionadm" class="yuimenu">
				                                    <div class="bd">
				                                        <ul class="first-of-type">
				                                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="<?php echo site_url('permission/setting');?>">Setting</a></li>				                                           
				                                        </ul>            
				                                    </div>
				                                </div>                                                
				                            </li>
				                            <?php }?>
				                            
				                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="#">Centre</a>                            
				                                <div id="centreadm" class="yuimenu">
				                                    <div class="bd">
				                                        <ul class="first-of-type">
				                                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="<?php echo site_url('centre/xgrid');?>">List</a></li>
				                                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="<?php echo site_url('centre/create');?>">Add</a></li>
				                                        </ul>            
				                                    </div>
				                                </div>                                                
				                            </li>
				                            
                                        </ul>            
                                    </div>
                                </div>                                                
                            </li>     
                            <?php }?>                      
                            
                            <?php if($admin == true){ ?>
                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="#">Modules</a>                            
                                <div id="moduleadm_blk" class="yuimenu">
                                    <div class="bd">
                                        <ul class="first-of-type">
                                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="#">Form</a>                            
				                                <div id="formadm" class="yuimenu">
				                                    <div class="bd">
				                                        <ul class="first-of-type">
				                                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="<?php echo site_url('cdform/xgrid');?>">List</a></li>				                                            
				                                        </ul>            
				                                    </div>
				                                </div>                                                
				                            </li> 
				                            
				                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="#">Lookup</a>                          
				                                <div id="lookuptableadm" class="yuimenu">
				                                    <div class="bd">
				                                        <ul class="first-of-type">
				                                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="<?php echo site_url('lookuptable/xgrid');?>">List</a></li>				                                            
				                                        </ul>            
				                                    </div>
				                                </div>                                                
				                            </li>
				                            
				                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="#">Page</a>                            
				                                <div id="pageadm" class="yuimenu">
				                                    <div class="bd">
				                                        <ul class="first-of-type">
				                                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="<?php echo site_url('page/xgrid');?>">List</a></li>
				                                        </ul>            
				                                    </div>
				                                </div>                                                
				                            </li> 
				                            
				                             <li class="yuimenuitem"><a class="yuimenuitemlabel" href="#">Link</a>                           
				                                <div id="linkadm" class="yuimenu">
				                                    <div class="bd">
				                                        <ul class="first-of-type">
				                                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="<?php echo site_url('link/xgrid');?>">List</a></li>                                         
				                                        </ul>            
				                                    </div>
				                                </div>                                                
				                            </li> 
				                            
				                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="#">File</a>                            
				                                <div id="fileadm" class="yuimenu">
				                                    <div class="bd">
				                                        <ul class="first-of-type">
				                                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="<?php echo site_url('file/xgrid');?>">List</a></li>				                                           
				                                        </ul>            
				                                    </div>
				                                </div>                                                
				                            </li> 
                            				
				                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="#">Folder</a>                          
				                                <div id="folderadm" class="yuimenu">
				                                    <div class="bd">
				                                        <ul class="first-of-type">
				                                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="<?php echo site_url('folder/xgrid');?>">List</a></li>				                                           
				                                        </ul>            
				                                    </div>
				                                </div>                                                
				                            </li>
                            
                            				<li class="yuimenuitem"><a class="yuimenuitemlabel" href="#">Project</a>                         
				                                <div id="projectadm" class="yuimenu">
				                                    <div class="bd">
				                                        <ul class="first-of-type">
				                                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="<?php echo site_url('project/xgrid');?>">List</a></li>				                                            
				                                        </ul>            
				                                    </div>
				                                </div>                                                
				                            </li>    
                            				
				                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="#">ToDo</a>                            
				                                <div id="todoadm" class="yuimenu">
				                                    <div class="bd">
				                                        <ul class="first-of-type">
				                                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="<?php echo site_url('todo/xgrid');?>">List</a></li>
				                                         </ul>            
				                                    </div>
				                                </div>                                                
				                            </li>  
				                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="#">Event</a>                            
				                                <div id="eventadm" class="yuimenu">
				                                    <div class="bd">
				                                        <ul class="first-of-type">
				                                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="<?php echo site_url('event/xgrid');?>">List</a></li>                                   
				                                        </ul>            
				                                    </div>
				                                </div>                                                
				                            </li>      
				                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="#">Database</a>                            
				                                <div id="dbadm" class="yuimenu">
				                                    <div class="bd">
				                                        <ul class="first-of-type">
				                                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="<?php echo site_url('db/xgrid');?>">List</a></li>                                            
				                                        </ul>            
				                                    </div>
				                                </div>                                                
				                            </li> 
				                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="#">Patient</a>                            
				                                <div id="patientadm" class="yuimenu">
				                                    <div class="bd">
				                                        <ul class="first-of-type">
				                                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="<?php echo site_url('patient/xgrid');?>">List</a></li>
				                                        </ul>            
				                                    </div>
				                                </div>                                                
				                            </li>   
				                          
                            
                                        </ul>            
                                    </div>
                                </div>                                                
                            </li>    
                            <?php }?>                                                         
                                              
                        </ul>
                    </div>
                </div>      
            
            </li>               
            <?php } ?>            
            <li class="yuimenubaritem"><a class="yuimenubaritemlabel" href="#">User</a>
                <div id="user" class="yuimenu">
                    <div class="bd">                    
                        <ul>
                        <?php if($role > 0){ ?>
                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="<?php echo site_url('user/home');?>">My Home</a></li>
                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="<?php echo site_url('user/logout');?>">Logout</a></li>   
                        <?php } else {?>
                            <li class="yuimenuitem"><a class="yuimenuitemlabel" href="<?php echo site_url('user/login');?>">Login</a></li>                          
                        <?php } ?>                                                   
                        </ul>
                    </div>
                </div>                                
            </li>                                    
        </ul>    
                
    </div>
</div>
