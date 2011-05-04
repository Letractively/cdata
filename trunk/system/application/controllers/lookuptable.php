<?php
/*
 * Created on 20-8-2007
 *
 */


class LookupTable extends Controller {
	
	
	// user object model vars
	var $search_model = array();
	var $data_model = array();	
	var $form_model = array();		
	var $view_model = array();
	var $list_model = array();
	var $object = "lookuptable";	
	var $permission_object = "db";
	
	
	function LookupTable()
	{	
		parent::Controller();
		$this->load->library("form");
		$this->load->library("cdata_user");
		$this->load->library("layout");
		$this->load->library("relation");
		
		// data model
		$this->data_model = array(
		'fields' => array(
    			"name" => array(
        			"type" => "text"
        			),
        		"description" => array(
        			"type" => "text"
        			),
        		"scope" => array(
        			"type" => "text",
        			"serialized" => "true"
        		),
        		"database_list" => array(
        			"type" => "text",
        			"serialized" => "true"
        		)
    		),    		
        	'table' => array(
    		'name' => "{$this->object}",
    		'id' => $this->object.'_id',
    		"serialized_column" => "data")
		);
		
		// view model
		$this->view_model = array(
		"fields" => array(
    		"name" => array(
    			"type" => "text",
    			"label" => "Name"
    			),
    		"description" => array(
    			"type" => "text",
    			"label" => "Description"
    			),
    		"scope" => array(
    			"type" => "select",
    			"label" => "Scope"
    			),
    		"database_list" => array(
    			"type" => "select",
    			"label" => "Select DB"
    			)
    		),
    		    	
    	"view" => array(
    		"theme" => "default"    	
    		)
		);
		
		// form model
        $this->form_model = array(
		"fields" => array(	
			"name" => array(
    			"type" => "text",
    			"label" => "Name",
    			"required" => "true"
    			),
    		"description" => array(
    			"type" => "text",
    			"label" => "Description"
    			),
    		"scope" => array(
    			"type" => "select",
    			"label" => "Scope",
    			"required" => "true",
    			"select" => array(
    				"multiple" => "false",
    				"interface" => "list",
    				"source" => array(
    					"type" => "array",
    					"options" => array("0" => "All applications", "1" =>"DB only", "2" =>"Selected DB"
    					)
    				)
    			)
    		),
    		"database_list" => array(
    			"type" => "select",
    			"label" => "Selected DB",
    			"required" => "false",
    			"select" => array(
    				"multiple" => "true",
    				"interface" => "checkbox",
    				"align" => "orizontal",
    				"source" => array(
    					"type" => "query",
    					"table" =>"db",
    					"id" => "db_id",
    					"label" => "name",
    					"sortby" => "name",
    					"order" => "ASC"
    					)
    				)
    			)
    		),
    	"form" => array(
    		"name" => "{$this->object}",
    		"method" => "post",
    		"action" => "",    		
			"theme" => "default"			
    		)
		);
		
		
		
		// search form model
        $this->search_model = array(
        	"fields" => array(
        		"title" => array(
        			"label" => "Search",
        			"type" => "text",
        			"op" => "like",
        			"field" => "name, description"
        			),
        		),
        	'form' => array(
        		'name' => $this->object.'_search'
        		)
    	);
		
		// 
		$this->list_model = array(
		"fields" => array(
    		"name" => array(
    			"header" => "Name",
    			"type" => "text"
    			),
    		"description" => array(
    			"header" => "Description",
    			"type" => "text"
    			),
    		"scope" => array(
    			"type" => "select",
    			"header" => "Scope"
    			),
    		"database_list" => array(
    			"type" => "select",
    			"header" => "DB"
    			)
    			
    		),
    	"grid" => array(
    		"op" => array(    			
    			"view" => array(
    				"link" => site_url("{$this->object}/view/lookuptable_id")
    			),
    			"id" => $this->object."_id"
    		),
    		"filter" => array(    			
    			"maxrows" => "all",
    			"ajaxmaxrows" => "20",
    			"default_sort" => "ORDER BY name DESC"
    		),
    		"table" => $this->object,
    		"base_url" => site_url($this->object."/xlist"),
    		"theme" => "default",
    		"target" => "_parent"
    		)
		);
		
		
		
		
		
		
		$theme_form = "default";
		
		
		// create Form class models
		$this->form->list_model = $this->list_model;
		$this->form->search_model = $this->search_model;
		$this->form->data_model = $this->data_model;
		$this->form->form_model = $this->form_model;
		$this->form->view_model = $this->view_model;
		
		//$this->form->form_model["form"]["theme"] = $theme_form;
		
	}
	
	// default page
	function index()
	{			
		redirect ($this->object."/xgrid");
	}
	
	function xgrid($page = 1){
		
		$this->cdata_user->check_permission($this->permission_object, "list");
		$data['search'] = $this->form->generate_search($page);;
		$data['grid'] = $this->form->generate_grid($page);
		
		$this->layout->main = $this->load->view($this->object."/xgrid",$data,true);	
		$this->layout->render_page();
		
	}	
	
    function create(){
        		
    	$this->cdata_user->check_permission($this->permission_object, "add");
    	if ($id = $this->form->create()){
    		redirect($this->object."/view/$id");
    	}
    	
    	$this->layout->main = $this->load->view($this->object."/create",null,true);		
    	$this->layout->render_page();
    }
    
    function edit($id){
    	
    	$this->cdata_user->check_permission($this->permission_object, "edit");
    	$this->form->form_model["form"]["cancelUrl"] = site_url($this->object."/view/$id");
    	if ($this->form->edit($id)){
    		redirect($this->object."/view/$id");
    	}
    	$this->layout->main = $this->load->view($this->object."/edit",null,true);		
    	$this->layout->render_page();
    }
    
    
    
    function view($id){
    	
        $this->cdata_user->check_permission($this->permission_object, "view");				
    	$this->form->read_data($id);
    	$data["id"] = $id;
    	$this->layout->main = $this->load->view($this->object."/view",$data,true);		
    	$this->layout->render_page();
    }
    
    
    function delete($id){
    	
    	$this->cdata_user->check_permission($this->permission_object, "delete");
    	$this->form->delete_data($id);
    	$q = "DELETE FROM lookupcode WHERE lookuptable_id = $id";
    	mysql_query($q);
    	redirect($this->object."/xgrid");
    }
	
}


?>