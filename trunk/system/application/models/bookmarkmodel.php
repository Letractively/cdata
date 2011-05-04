<?php

class Bookmarkmodel extends Model{
	
	// user object model vars
	var $search_model = array();
	var $data_model = array();	
	var $form_model = array();		
	var $view_model = array();
	var $list_model = array();
	var $object = "bookmark";	
	
	
	function bookmarkmodel(){
		
		parent::Model();	

		$this->load->library("form");
		$this->myform = new Form();
		$this->load->library("cdata_user");
		$this->load->library("relation");
		
		// data model
		$this->data_model = array(
		'fields' => array(
			"pclass" => array(
    			"type" => "text"
    			),
    		"pid" => array(
    			"type" => "integer"
    			),
    		"user_id" => array(
    			"type" => "integer"
    			),
    		"object" => array(
    			"type" => "text"
    			),
    		"title" => array(
    			"type" => "text"
    			),
    		"created" => array(
    			"type" => "datetime"
    			)
    		),
        	'table' => array(
    		'name' => "{$this->object}",
    		'id' => $this->object.'_id',
    		"serialized_column" => "serialized")
		);
		
		// view model
		$this->view_model = array(
		"fields" => array(
    		"title" => array(
    			"type" => "html",
    			"label" => "Title"
    			),
    		"object" => array(
    			"type" => "text",
    			"label" => "Type"
    			),
    		"created" => array(
    			"type" => "datetime",
    			"label" => "Created"
    			)
    		),
    	"view" => array(
    		"theme" => "default"
    	)
		);
		
		// form model
        $this->form_model = array(
		"fields" => array(
			"pclass" => array(
    			"type" => "hidden"
    			), 
    		"pid" => array(
    			"type" => "hidden"
    			),
    		"user_id" => array(
    			"type" => "hidden"
    			),
    		"title" => array(
    			"type" => "text",
    			"label" => "Title",
    			"length" => "60",
    			"required" => "true"
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
        			"field" => "title, teaser, description"
        			),
        		),
        	'form' => array(
        		'name' => $this->object.'_search'
        		)
    	);
		
		// 
		$this->list_model = array(
		"fields" => array(
			"type" => array(
    			"header" => "Type",
    			"type" => "text"
    			),
    		"title" => array(
    			"header" => "Title",
    			"type" => "html"
    			),   		
    		"created" => array(
    			"header" => "Created",
    			"type" => "datetime"
    			)
    		),
    	"grid" => array(
    		"op" => array(    			
    			"delete" => array(
    				"link" => "javascript: ajax.del('$this->object', '{$this->object}_id');"
    			),
    			"id" => $this->object."_id"
    		),
    		"filter" => array(    			
    			"maxrows" => "all",
    			"default_sort" => "ORDER BY created DESC"
    		),
    		"table" => $this->object,
    		"base_url" => site_url($this->object."/xgrid"),
    		"theme" => "default"
    	)
		);
		
		// create Form class models
		$this->myform->list_model = $this->list_model;
		$this->myform->search_model = $this->search_model;
		$this->myform->data_model = $this->data_model;
		$this->myform->form_model = $this->form_model;
		$this->myform->view_model = $this->view_model;
		
		//$this->form->form_model["form"]["theme"] = $theme_form;
		
	}	
	

	function userlist($userid){
		
		$page = 1;
		$this->myform->list_model["filter"]["where"] = "user_id = $userid";
		$data["grid"] = $this->myform->generate_grid($page);
		return $this->load->view("bookmark/xgrid", $data, true);
		
	}
	
	
	function delete($id){
		
		$this->myform->delete_data($id);
		
	}



}


?>