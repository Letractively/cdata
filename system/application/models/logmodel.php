<?php

class Logmodel extends Model{
	
	// user object model vars
	var $search_model = array();
	var $data_model = array();	
	var $form_model = array();		
	var $view_model = array();
	var $list_model = array();
	var $object = "log";	
	
	
	function logmodel(){
		
		parent::Model();	

		$this->load->library("form");
		$this->myform = new Form();
		$this->load->library("cdata_user");
		$this->load->library("relation");
		
		// data model
		$this->data_model = array(
		'fields' => array(
				"type" => array(
        			"type" => "text"
        			),
        		"action" => array(
        			"type" => "text"
        			),
        		"class" => array(
        			"type" => "text"
        			),
        		"id" => array(
        			"type" => "integer"
        			),
        		"user_id" => array(
        			"type" => "integer"
        			),	
        		"message" => array(
        			"type" => "text"
        			),	
        		"created" => array(
        			"type" => "datetime"
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
    			"type" => array(
        			"type" => "text",
        			"label" => "Type"
        			),
        		"action" => array(
        			"type" => "text",
        			"label" => "Action"
        			),
        		"class" => array(
        			"type" => "text",
        			"label" => "Class"
        			),
        		"id" => array(
        			"type" => "integer",
        			"label" => "ID"
        			),
        		"user_id" => array(
        			"type" => "integer",
        			"label" => "User"
        			),	
        		"created" => array(
        			"type" => "datetime",
        			"label" => "Date"
        		),
        		"message" => array(
        			"type" => "text",
        			"label" => "Message"
        		)
    		),
    		    	
    	"view" => array(
    		"theme" => "default"    	
    		)
		);
		
		// form model
        $this->form_model = array(
		"fields" => array(	
				"type" => array(
        			"type" => "select",
        			"label" => "Type",
        			"select" => array(
	    				"multiple" => "false",
	    				"null_value" => "true",
	    				"interface" => "list",
	    				"source" => array(
	    					"type" => "array",
	    					"options" => array("0" => "Content", "1" =>"System", "2" =>"Error")
	    					)
	    				)
        			),
        		"action" => array(
        			"type" => "select",
        			"label" => "Action",
        			"select" => array(
	    				"multiple" => "false",
	    				"null_value" => "true",
	    				"interface" => "list",
	    				"source" => array(
	    					"type" => "array",
	    					"options" => array("add" => "Add", "edit" =>"Edit", "view" =>"View", 
	    					"del" => "Delete", "in" =>"Login", "out"=>"Logout", "unlock" => "Unlock")
	    					)
	    				)
        			),
        		"class" => array(
        			"type" => "text",
        			"label" => "Class",
        			"select" => array(
	    				"multiple" => "false",
	    				"null_value" => "true",
	    				"interface" => "list",
	    				"source" => array(
	    					"type" => "array",
	    					"options" => array("cdform" => "Form Template", "patient" =>"Patient", "pform" =>"Form", 
	    					"file" => "File", "folder" => "Folder", "page" =>"Page", "link"=>"Link", "project"=>"Project", "todo"=>"Todo", "event"=>"Event", "user"=>"User", "db"=>"Database", "centre"=>"Centre", "group"=>"Group")
	    					)
	    				)
        			),
        		"id" => array(
        			"type" => "integer",
        			"label" => "ID"
        			),
        		"user_id" => array(
        			"type" => "select",
        			"label" => "User",
        			"select" => array(
	    				"multiple" => "true",
	    				"interface" => "list",
	    				"align" => "orizontal",
	    				"source" => array(
	    					"type" => "query",
	    					"table" =>"users",
	    					"id" => "user_id",
	    					"label" => "lastname",
	    					"sortby" => "lastname",
	    					"order" => "ASC"
	    					)
    					)
        			),	
        		"when" => array(
        			"type" => "datetime",
        			"label" => "Date"
        		),
        		"message" => array(
        			"type" => "text",
        			"label" => "Message"
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
        		"type" => array(
        			"label" => "Type",
        			"type" => "select",
        			"op" => "like",
        			"field" => "type"
        			),
        		"action" => array(
        			"label" => "Action",
        			"type" => "select",
        			"op" => "like",
        			"field" => "action"
        			),
        		"class" => array(
        			"label" => "Class",
        			"type" => "select",
        			"op" => "like",
        			"field" => "class"
        			)
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
        			"type" => "select"
        			),
        		"action" => array(
        			"header" => "Action",
        			"type" => "select"
        			),
        		"class" => array(
        			"header" => "Class",
        			"type" => "select"
        			),
        		"message" => array(
        			"header" => "Title",
        			"type" => "text"
        			),
        		"user_id" => array(
        			"header" => "User",
        			"type" => "select"
        			),
        		"created" => array(
        			"header" => "Date",
        			"type" => "datetime"
        			)
    			
    		),
    	"grid" => array(
    		"op" => array(    			
    			"view" => array(
    				"link" => site_url("{$this->object}/view/log_id")
    			),
    			"id" => $this->object."_id"
    		),
    		"filter" => array(    			
    			"maxrows" => "300",
    			"yuimaxrows" => "50",
    			"default_sort" => "ORDER BY created DESC"
    		),
    		"table" => $this->object,
    		"base_url" => site_url($this->object."/xlist"),
    		"theme" => "default",
    		"target" => "_parent"
    		)
		);
		
		$theme_form = "default";
		
		// create Form class models
		$this->myform->list_model = $this->list_model;
		$this->myform->search_model = $this->search_model;
		$this->myform->data_model = $this->data_model;
		$this->myform->form_model = $this->form_model;
		$this->myform->view_model = $this->view_model;
		
		//$this->form->form_model["form"]["theme"] = $theme_form;
		
	}	

	function grid($pclass = "", $pid = "", $page = 1){
		
		return $this->myform->generate_grid($page);			
	
	}

	
	function userlist($userid){
		
		$page = 1;
		$this->myform->list_model["filter"]["orderby"] = "created DESC";
		$this->myform->list_model["filter"]["type"] = "0";
		$this->myform->list_model["grid"]["filter"]["maxrows"] = "200";
		return $this->myform->generate_grid($page);	
		
	}



}


?>