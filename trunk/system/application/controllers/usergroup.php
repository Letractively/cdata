<?php
/*
 * Created on 20-8-2007
 *
 */


class Usergroup extends Controller {
	
	
	// user object model vars
	var $search_model = array();
	var $data_model = array();	
	var $form_model = array();		
	var $view_model = array();
	var $list_model = array();
	var $object = "usergroup";
	var $permission_object = "app";
		
	
	
	function Usergroup()
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
    		'name' => 'usergroup',
    		'id' => 'usergroup_id')
		);
		
		// view model
		$this->view_model = array(
		"fields" => array(
    		"name" => array(
    			"type" => "text",
    			"label" => "Group",    		
    			),
    		"note" => array(
    			"type" => "text",
    			"label" => "Note",    		
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
    			"label" => "Group",
    			"lenght" => "30",
    			"required" => "true"
    			),
    		"note" => array(
    			"type" => "textarea",
    			"label" => "Note",
    			"required" => "false"
    			)
    		),
    	"form" => array(
    		"name" => "usergroup",
    		"method" => "post",
    		"action" => ""
    		)
		);			
		
		// search form model
        $this->user_search_model = array(
		);
		
		// 
		$this->list_model = array(
		"fields" => array(
    		"name" => array(
    			"header" => "Group",
    			"lenght" => "10em",
    			"type" => "text"
    			),
    		"note" => array(
    			"header" => "Note",
    			"lenght" => "20em",
    			"type" => "text"
    			)
    		),
    	"grid" => array(
    		"op" => array(
    			"view" => array(
    				"link" => site_url("usergroup/view/usergroup_id")
    			),
    			"id" => "usergroup_id"
    		),
    		"filter" => array(    			
    			"maxrows" => "20",
    			"default_sort" => "ORDER BY name ASC"
    		),
    		"table" => "usergroup",
    		"base_url" => site_url("usergroup/xgrid")
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
		redirect ("usergroup/xgrid");
	}
	
	
	function xgrid($page = 1){
		
		$this->cdata_user->check_permission($this->permission_object, "admin");
		$data['search'] = "";
		$data['grid'] = $this->form->generate_grid($page);
		$this->layout->main = $this->load->view("usergroup/xgrid",$data,true);		
		$this->layout->render_page();
		
	}
	
	
	function create(){
        
		$this->cdata_user->check_permission($this->permission_object, "admin");
		if ($id = $this->form->create()){
			redirect("usergroup/xgrid");
		}
		
		$this->layout->main = $this->load->view("usergroup/create",null,true);		
		$this->layout->render_page();
	}
	
	
	function edit($id){
		
		$this->cdata_user->check_permission($this->permission_object, "admin");
		if ($this->form->edit($id)){
			redirect("usergroup/view/$id");
		}
		$this->layout->main = $this->load->view("usergroup/edit",null,true);		
		$this->layout->render_page();
	}
	
	
	
	
	function view($id){

		$this->cdata_user->check_permission($this->permission_object, "access");
		$this->form->read_data($id);
		$data["id"] = $id;
		$this->layout->main = $this->load->view("usergroup/view",$data,true);		
		$this->layout->render_page();
	}
	
	
	function delete($id){
		
		$this->cdata_user->check_permission($this->permission_object, "admin");
		$this->form->delete_data($id);
		redirect("usergroup/xgrid");
	}
	
}


?>