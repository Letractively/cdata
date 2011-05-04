<?php
/*
 * Created on 20-8-2007
 *
 */


class Subscription extends Controller {
	
	var $object = "subscription";	
	var $permission_object = "app";
		
	
	
	function Subscription()
	{	
		parent::Controller();
		$this->load->library("form");
		$this->load->library("cdata_user");
		$this->load->library("layout");
		$this->load->library("relation");
		$this->load->model("subscriptionmodel");
		
	}
	
	// default page
	function index()
	{			
		redirect ($this->object."/create");
	}
	
	
	function create($pclass, $pid){
		
		$this->cdata_user->check_permission($this->permission_object, "access");
		if (!$this->cdata_user->get_role()>0){$this->cdata_user->noAuth();}
		$this->layout->main = "<h3>Subscription</h3>".$this->subscriptionmodel->create($pclass, $pid);
		$this->layout->render_page();
			
	}
	
	
	function delete($id){
		
		$this->cdata_user->check_permission($this->permission_object, "delete");
		$this->subscriptionmodel->delete($id);
		
	}
	
}


?>