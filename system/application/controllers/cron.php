<?php
/*
 * Created on 20-8-2007
 *
 */


class Cron extends Controller {
		
	
	
	function Cron()
	{	
		parent::Controller();
		$this->load->library("form");
		$this->load->library("cdata_user");
		$this->load->library("layout");
		
		
		
	}
	
	// default page
	function index()
	{			
		
		$this->alert();
		
		
	}
	
	
	function alert(){
		
		//$todo = "SELECT * FROM todo WHERE notified <> 1 AND DATEDIFF(start, CURDATE()) >= 1";
        $todo = "SELECT * FROM todo WHERE (notify > '')  AND ((notified IS NULL) OR (notified <> '1')) AND (DATEDIFF(start, CURDATE()) = 1)";
		$res = mysql_query($todo);
		while($r = mysql_fetch_assoc($res)){
			print $r["title"]."<br>"; 
		}
		
		
	}
	
	
	
	
}


?>