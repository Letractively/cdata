<?php

class Todomodel extends Model{
	
	// user object model vars
	var $search_model = array();
	var $data_model = array();	
	var $form_model = array();		
	var $view_model = array();
	var $list_model = array();
	var $object = "todo";	
	var $myform;
	
	
	function todomodel(){
		
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
    		"title" => array(
    			"type" => "text"
    			),
    		"teaser" => array(
    			"type" => "text"
    			),
    		"start" => array(
    			"type" => "date"
    			),
    		"finish" => array(
    			"type" => "date"
    			),
    		"status" => array(
    			"type" => "text"
    			),
    		"progress" => array(
    			"type" => "text"
    			),
    		"assigned" => array(
    			"type" => "text"
    			),
    		"notify" => array(
    			"type" => "text"
    			),
    		"description" => array(
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
    		"teaser" => array(
    			"type" => "text",
    			"label" => "Teaser"
    			),
    		"start" => array(
    			"type" => "date",
    			"label" => "Start"
    			),
    		"finish" => array(
    			"type" => "date",
    			"label" => "Finish"
    			),
    		"status" => array(
    			"type" => "select",
    			"label" => "Status"
    			),
    		"progress" => array(
    			"type" => "select",
    			"label" => "Progress"
    			),
    		"assigned" => array(
    			"type" => "select",
    			"label" => "Assigned to"
    			),  
    		"notify" => array(
    			"type" => "checkbox",
    			"label" => "Notify User"
    			), 
    		"description" => array(
    			"type" => "html",
    			"label" => "Description"
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
    		"title" => array(
    			"type" => "text",
    			"label" => "Title",
    			"length" => "60",
    			"required" => "true"
    			),      		
    		"teaser" => array(
    			"type" => "text",
    			"label" => "Teaser",
    			"length" => "100",
    			"required" => "false",
    			"editor" => "false"
    			),  
    		"start" => array(
    			"type" => "date",
    			"label" => "Start",
    			"length" => "10",
    			"required" => "false"
    			),
    		"finish" => array(
    			"type" => "date",
    			"label" => "Finish",
    			"length" => "10",
    			"required" => "false"
    			),
    		"status" => array(
    			"type" => "select",
    			"label" => "Status",
    			"required" => "false",
    			"select" => array(
    				"multiple" => "false",
    				"null_value" => "true",
    				"interface" => "list",
    				"source" => array(
    					"type" => "array",
    					"options" => array("3" =>"In Progress",
    					"4"=>"On Hold", "5"=>"Complete")
    					)
    				)
    			),
    		"progress" => array(
    			"type" => "select",
    			"label" => "Progress",
    			"required" => "false",
    			"select" => array(
    				"multiple" => "false",
    				"null_value" => "true",
    				"interface" => "list",
    				"source" => array(
    					"type" => "array",
    					"options" => array("0" => "0%", "10" =>"10%", "20" =>"20%", "30" =>"30%",
    					"40"=>"40%", "50"=>"50%", "60" => "60%", "70" =>"70%", "80" =>"80%", "90" =>"90%",
    					"100"=>"100%")
    					)
    				)
    			),
    		"assigned" => array(
    			"type" => "select",
    			"label" => "Assigned to",
    			"required" => "true",
    			"select" => array(
    				"multiple" => "true",
    				"interface" => "checkbox",
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
    		"notify" => array(
    			"type" => "checkbox",
    			"label" => "Notify User",
    			"required" => "false"    			
    			),
    		"description" => array(
    			"type" => "textarea",
    			"label" => "Description",
    			"rows" => "20",
    			"cols" => "50",
    			"required" => "false",
    			"editor" => "true"
    			)    		 		    		
    		),
    	"form" => array(
            "locking" => "true",
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
    		"title" => array(
    			"header" => "Title",
    			"type" => "text"
    			),   
    		"teaser" => array(
    			"header" => "Teaser",
    			"type" => "text"
    			),  
    		"start" => array(
    			"header" => "Start",
    			"type" => "date"
    			), 	
    		"finish" => array(
    			"header" => "Finish",
    			"type" => "date"
    			), 
    		"status" => array(
    			"header" => "Status",
    			"type" => "select"
    			),	
    		"created" => array(
    			"header" => "Created",
    			"type" => "datetime"
    			)
    		),
    	"grid" => array(
    		"op" => array(    			
    			"view" => array(
    				"link" => site_url("{$this->object}/xview/{$this->object}_id")
    			),
    			"id" => $this->object."_id"
    		),
    		"filter" => array(    			
    			"maxrows" => "all",
    			"default_sort" => "ORDER BY status ASC, created DESC"
    		),
    		"table" => $this->object,
    		"base_url" => site_url($this->object."/xgrid"),
    		"theme" => "default",
    		"target" => "_parent"
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

	function grid($pclass = "", $pid = "", $page = 1){
		
		if ($pclass > ""){
			$this->myform->list_model["filter"]["pclass"] = $pclass;
			$this->myform->list_model["filter"]["pid"] = $pid;
		}
		return $this->myform->generate_grid($page);			
	
	}

	function userlist($userid){
		
		$page = 1;
		$this->myform->list_model["filter"]["where"] = "assigned REGEXP '[[:<:]]".$userid."[[:>:]]'";
		return $this->myform->generate_grid($page);
		
	}

	
	function search($page){
		return $this->myform->generate_search($page);	
	}
	
	
	function view($id){
        
		$data["id"] = $id;
		$data["class"] = $this->object;
		$this->myform->read_data($id);
		return $this->myform->generate_view($id);
		
	}
    
    
    function title($id = null){
        
        $col = "title";
        if (!isset($this->myform->form_data[$col])){
            $this->myform->read_data($id);  
        }
        return $this->myform->form_data[$col];
        
    }
    
    

	
	function edit($id){
		
		$this->myform->form_model["form"]["cancelUrl"] = site_url("admin/unlock/".$this->object."/$id");
		if ($this->myform->edit($id)){
			$this->relation->log("0", $this->object, $id, "edit", $this->cdata_user->get_user_id(), $this->myform->form_data["title"]);
			redirect($this->object."/xview/$id");
		}
		return $this->myform->generate_form();
	}

	
	function create($pclass = "root", $pid = "0"){    
		
		// add value to hidden field in the form
		$_REQUEST["pclass"] = $pclass;
        $_REQUEST["pid"] = $pid;
		if (isset($_REQUEST['submit'])) {
			$this->myform->form_data = $_REQUEST;			
			if ($this->myform->form_check()){
				$this->myform->form_data['created'] = date("d-m-Y H:i:s");
				// save data
                $id = $this->myform->add_data();
                $this->relation->log("0", $this->object, $id, "add", $this->cdata_user->get_user_id(), $this->myform->form_data["title"]);
                if(isset($_POST["notify"])){
                	$users = array();
                	foreach ($_POST["assigned"] as $userid){
                		$users[] = 	$userid;
                	}	
                	$message = "<b>New Todo</b><br/><br/>";
                	$message .= "<b>Title</b>: {$_POST["title"]}}<br/>";
                	$message .= "<b><a href=\"".site_url("todo/xview/".$id)."\">Link</a></b><br/>";
                	$this->relation->notifyUsers($users, "New Todo notification", $message);
                }
                redirect($this->object."/xview/$id");
			}
		}
        $this->myform->form_model["form"]["locking"] = "false"; 
		return $this->myform->generate_form();
	}
	
	
	function delete($id){

		list($pclass, $pid, $title) = $this->relation->getParentNode($this->object, $id);
		$this->relation->delete($this->object, $id);
		$this->relation->log("0", $this->object, $id, "del", $this->cdata_user->get_user_id(), $title);		
		redirect("$pclass/xview/$pid");
		
	}

}


?>