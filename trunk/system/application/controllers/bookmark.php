<?php
/*
 * Created on 20-8-2007
 *
 */


class Bookmark extends Controller {
	
	var $object = "bookmark";	
	var $permission_object = "module";
		
	
	
	function Bookmark()
	{	
		parent::Controller();
		$this->load->library("form");
		$this->load->library("cdata_user");
		$this->load->library("layout");
		$this->load->library("relation");
		$this->load->model("bookmarkmodel");
		
	}
	
	// default page
	function index()
	{			
		redirect ($this->object."/xgrid");
	}
	
	
	function create($pclass, $pid){
		
		$this->cdata_user->check_permission($this->permission_object, "add");
		$this->relation->bookmark($pclass, $pid);
		
	}
	
	
	function delete($id){
		
		$this->cdata_user->check_permission($this->permission_object, "delete");
		$this->bookmarkmodel->delete($id);
		
	}
	
}


?>