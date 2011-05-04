<?php
/*
 * Created on 20-8-2007
 *
 */


class Role extends Controller {
	
	
	// user object model vars
	var $search_model = array();
	var $data_model = array();	
	var $form_model = array();		
	var $view_model = array();
	var $list_model = array();
	var $object = "role";
	var $permission_object = "app";
		
	
	
	function Role()
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
    			)	
    		),
    	'table' => array(
    		'name' => 'security_role',
    		'id' => 'role_id')
		);
		
		// view model
		$this->view_model = array(
		"fields" => array(
    		"name" => array(
    			"type" => "text",
    			"label" => "Role",    		
    			)
    		),
    	"view" => array(
    	)
		);
		
		// form model
        $this->form_model = array(
		"fields" => array(
    		"name" => array(
    			"type" => "text",
    			"label" => "Role",
    			"lenght" => "30",
    			"required" => "true"
    			)
    		),
    	"form" => array(
    		"name" => "role",
    		"method" => "post",
    		"action" => "")
		);
		
		
		
		// search form model
        $this->user_search_model = array(
		);
		
		// 
		$this->list_model = array(
		"fields" => array(
    		"name" => array(
    			"header" => "Role",
    			"lenght" => "10em",
    			"type" => "text"
    			)
    		),
    	"grid" => array(
    		"op" => array(
    			"add" => array(
    				"link" => "role/create"
    			),
    			"edit" => array(
    				"link" => site_url("role/edit/role_id")
    			),
    			"view" => array(
    				"link" => site_url("role/view/role_id")
    			),
    			"id" => "role_id"
    		),
    		"filter" => array(    			
    			"maxrows" => "20",
    			"default_sort" => "ORDER BY role_id ASC"
    		),
    		"table" => "security_role",
    		"base_url" => site_url("role/xgrid")
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
		redirect ("role/xgrid");
	}
	
	
	function xgrid($page = 1){
		
		$this->cdata_user->check_permission($this->permission_object, "user");
		$data['search'] = "";
		$data['grid'] = $this->form->generate_grid($page);
		$this->layout->main = $this->load->view("role/xgrid",$data,true);		
		$this->layout->render_page();
		
	}
	
	
	function create(){
        
		$this->cdata_user->check_permission($this->permission_object, "user");
		if ($this->form->create()){
			redirect("role/xgrid");
		}
		
		$this->layout->main = $this->load->view("role/create",null,true);		
		$this->layout->render_page();
	}
	
	
	function edit($id){
		
		$this->cdata_user->check_permission($this->permission_object, "user");
		if ($this->form->edit($id)){
			redirect("role/xgrid");
		}
		$this->layout->main = $this->load->view("role/edit",null,true);		
		$this->layout->render_page();
	}
	
	
	
	
	function view($id){

		$this->cdata_user->check_permission($this->permission_object, "access");
		$this->form->read_data($id);
		$data["id"] = $id;
		$this->layout->main = $this->load->view("role/view",$data,true);		
		$this->layout->render_page();
	}
	
	
	function delete($id){
		
		$this->cdata_user->check_permission($this->permission_object, "user");
		$this->form->delete_data($id);
		redirect("role/xgrid");
	}
	
}


?>