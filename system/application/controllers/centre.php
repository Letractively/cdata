<?php
/*
 * Created on 20-8-2007
 *
 */


class Centre extends Controller {
	
	
	// user object model vars
	var $search_model = array();
	var $data_model = array();	
	var $form_model = array();		
	var $view_model = array();
	var $list_model = array();
	var $object = "centre";	
	var $permission_object = "app";
		
	
	
	function Centre()
	{	
		parent::Controller();
		$this->load->library("form");
		$this->load->library("cdata_user");
		$this->load->library("layout");
		
		// data model
		$this->data_model = array(
		'fields' => array(
    		"name" => array(
    			"type" => "text"
    			),
    		"note" => array(
    			"type" => "text"
    			)
    		),
    	'table' => array(
    		'name' => 'centre',
    		'id' => 'centre_id')
		);
		
		// view model
		$this->view_model = array(
		"fields" => array(
    		"name" => array(
    			"type" => "text",
    			"label" => "Centre",    		
    			),
    		"note" => array(
    			"type" => "html",
    			"label" => "Note",    		
    			),	
    		),
    	"view" => array(
    	)
		);
		
		// form model
        $this->form_model = array(
		"fields" => array(
    		"name" => array(
    			"type" => "text",
    			"label" => "Name",
    			"length" => "50",
    			"required" => "true"
    			),
    		"note" => array(
    			"type" => "textarea",
    			"editor" => "true",
    			"label" => "Note",
    			"rows" => "10",
    			"cols" => "50"
    			),
    		
    		),
    	"form" => array(
    		"name" => "centre",
    		"method" => "post",
    		"action" => ""
    		)
		);
		
		
		
		// search form model
        $this->search_model = array(
		);
		
		// 
		$this->list_model = array(
		"fields" => array(
    		"name" => array(
    			"header" => "Centre",
    			"lenght" => "30em",
    			"type" => "text"
    			)
    		),
    	"grid" => array(
    		"op" => array(
    			"add" => array(
    				"link" => "centre/create"
    			),
    			"edit" => array(
    				"link" => site_url("centre/edit/centre_id")
    			),
    			"view" => array(
    				"link" => site_url("centre/view/centre_id")
    			),
    			"id" => "centre_id"
    		),
    		"filter" => array(    			
    			"maxrows" => "20",
    			"default_sort" => "ORDER BY centre_id ASC"
    		),
    		"table" => "centre",
    		"base_url" => site_url("centre/xgrid")
    	)
		);
		
		// create Form class models
		$this->form->list_model = $this->list_model;
		$this->form->search_model = $this->search_model;
		$this->form->data_model = $this->data_model;
		$this->form->form_model = $this->form_model;
		$this->form->view_model = $this->view_model;
		
	}
	
	// default page
	function index()
	{			
		redirect ($this->object."/xgrid");
	}
	
	
	function xgrid($page = 1){
		
		$this->cdata_user->check_permission($this->permission_object, "admin");
		$data['search'] = "";
		$data['grid'] = $this->form->generate_grid($page);
		$this->layout->main = $this->load->view($this->object."/xgrid",$data,true);		
		$this->layout->render_page();
		
	}
	
	
	function create(){
        		
		$this->cdata_user->check_permission($this->permission_object, "admin");
		if ($this->form->create()){
			redirect($this->object."/xgrid");
		}
		
		$this->layout->main = $this->load->view($this->object."/create",null,true);		
		$this->layout->render_page();
	}
	
	
	function edit($id){
		
		$this->cdata_user->check_permission($this->permission_object, "admin");
		if ($this->form->edit($id)){
			redirect($this->object."/xgrid");
		}
		$data["id"] = $id;
		$this->layout->main = $this->load->view($this->object."/edit",$data,true);		
		$this->layout->render_page();
	}
	

	
	function view($id){
		
        $this->cdata_user->check_permission($this->permission_object, "access");				
		$this->form->read_data($id);
		$data["id"] = $id;
		$this->layout->main = $this->load->view($this->object."/view",$data,true);		
		$this->layout->render_page();
	}
	
	
	function delete($id){
		
		$this->cdata_user->check_permission($this->permission_object, "admin");
		$this->form->delete_data($id);
		redirect($this->object."/xgrid");
	}
	
}


?>