<h2>My Account</h2>
<p>
    <?php print $userView;?>
</p>
<p>
<input type="button" onClick="location.href=('<?php print site_url('user/editown');?>')" value="Edit" />
</p>
<div id="childTab" class="yui-navset">
        <ul class="yui-nav">
            <li  class="selected" ><a href="#bookmark"><em>My Bookmarks</em></a></li>
            <li><a href="#subscription"><em>My Subscriptions</em></a></li> 
            <li><a href="#todo"><em>My Todos</em></a></li>  
            <li><a href="#calendar"><em>Events</em></a></li>    
            <li><a href="#log"><em>Activity</em></a></li> 
            <li><a href="#users"><em>Users</em></a></li>                  
        </ul>
        <div class="yui-content">
            <div id="bookmark">				
				<?php print $bookmarkList?>                
            </div>
            <div id="subscription">				
				<?php print $subscriptionList?>                
            </div>
            <div id="todo">               
                <?php print $todoList?>               
             </div> 
            <div id="event">               
                <?php print $eventList?>               
             </div>      
             <div id="log">               
                <?php print $logList?>                 
             </div> 
             <div id="users">               
                <?php print $usersList?>                 
             </div>                      
        </div>
</div>
<script>
(function() {
        var childTab = new YAHOO.widget.TabView('childTab');
    })();
</script> 
<script type="text/javascript">
<!--
var ajax = {
    
   init: function() {
   },
   
   open: function(oclass, oid) {
   		window.location.href = '<?php print site_url();?>' + '/' + oclass + '/xview/' + oid;	
   },
   
   del: function(oclass, oid) {
    var cObj = YAHOO.util.Connect.asyncRequest('GET', "<?php print site_url();?>" + "/" + oclass + "/" + "delete" + "/" + oid, ajax.ajax_callback);
   },
   
   ajax_callback:{   
       //response
       success: function(o) {                                                                                                                                       
           window.location.reload();           
       },
       
       failure: function(o) { // In this example, we shouldn't ever go down this path.
        alert('An error has occurred');
      }
    }
    
};
//-->
</script>