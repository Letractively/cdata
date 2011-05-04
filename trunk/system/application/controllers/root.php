<?php
/*
 * Created on 20-8-2007
 *
 */


class Root extends Controller {
	
	
	// user object model vars
	var $search_model = array();
	var $data_model = array();	
	var $form_model = array();		
	var $view_model = array();
	var $list_model = array();
	var $object = "root";	
		
	
	
	function Root()
	{	
		parent::Controller();
		$this->load->library("form");
		$this->load->library("cdata_user");
		$this->load->library("layout");
		$this->load->library("Relation");
		
	}
	
	// default page
	function index()
	{			
		redirect ($this->object."/view");
	}
	
	function xview($id = 0){
		
		$this->cdata_user->check_permission("app", "access");
		$data = array();
		$data["page"] = "Default Application root";
		$data = array_merge($data, $this->relation->getViewData("root", "0"));
		$this->layout->main = $this->load->view("cdata/home", $data, true);
		$this->layout->render_page();
	}
	
	

}


?>