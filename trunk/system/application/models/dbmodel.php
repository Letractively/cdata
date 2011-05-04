<?php

class Dbmodel extends Model{
	
	// user object model vars
	var $search_model = array();
	var $data_model = array();	
	var $form_model = array();		
	var $view_model = array();
	var $list_model = array();
	var $object = "db";	
	
	function dbmodel(){
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
    		"name" => array(
    			"type" => "text"
    			),
    		"teaser" => array(
    			"type" => "text"
    			),
    		"note" => array(
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
    		"name" => array(
    			"type" => "text",
    			"label" => "Name",
    			"tab" => "tmain"
    			),
    		"teaser" => array(
    			"type" => "html",
    			"label" => "Description",
    			"tab" => "tmain"
    			),
    		"note" => array(
    			"type" => "html",
    			"label" => "Note",
    			"tab" => "tnote"
    			),
    		"created" => array(
    			"type" => "datetime",
    			"label" => "Created",
    			"tab" => "tmain"
    			)
    		),
    	"view" => array(
    		"theme" => "default",
    		"tab" => array(
				"tmain" => "Main",
				"tnote" => "Note"
				)
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
    		"name" => array(
    			"type" => "text",
    			"label" => "Name",
    			"length" => "50",
    			"required" => "true",
    			"tab" => "tmain"
    			),  
    		"teaser" => array(
    			"type" => "textarea",
    			"label" => "Description",
    			"rows" => "20",
    			"cols" => "50",
    			"required" => "false",
    			"editor" => "true",
    			"tab" => "tmain"
    			),  
    		"note" => array(
    			"type" => "textarea",
    			"label" => "Note",
    			"rows" => "20",
    			"cols" => "50",
    			"required" => "false",
    			"editor" => "true",
    			"default" =>"",
    			"tab" => "tnote"
    			)    		 		    		
    		),
    	"form" => array(
            "locking" => "true",
    		"name" => "{$this->object}",
    		"method" => "post",
    		"action" => "",    		
			"theme" => "default",
			"tab" => array(
				"tmain" => "Main",
				"tnote" => "Note"
				)
    		)
		);
		
		
		
		// search form model
        $this->search_model = array(
        	"fields" => array(
        		"title" => array(
        			"label" => "Search",
        			"type" => "text",
        			"op" => "like",
        			"field" => "name, teaser, note"
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
    			"maxrows" => "20",
    			"default_sort" => "ORDER BY created DESC"
    		),
    		"table" => $this->object,
    		"base_url" => site_url($this->object."/xgrid"),
    		"target" => "_parent",
    		"theme" => "default"
    		)
		);
		
		$theme_form = "default";
		
		
		// create Form class models
		$this->myform->list_model = $this->list_model;
		$this->myform->search_model = $this->search_model;
		$this->myform->data_model = $this->data_model;
		$this->myform->form_model = $this->form_model;
		$this->myform->view_model = $this->view_model;	
	}	

	
	function grid($pclass = "", $pid = "", $page = 1){
		
		if ($pclass > ""){
			$this->myform->list_model["filter"]["pclass"] = $pclass;
			$this->myform->list_model["filter"]["pid"] = $pid;
		}
		return $this->myform->generate_grid($page);			
	
	}
	
	function search(){
		return $this->myform->generate_search();	
	}
	
	
	function view($id){
        
		$data["id"] = $id;
		$data["class"] = $this->object;
		$this->myform->read_data($id);
		return $this->myform->generate_view($id);
		
	}
    
	function title($id = null){
        
        $col = "name";
        if (!isset($this->myform->form_data[$col])){
            $this->myform->read_data($id);  
        }
        return $this->myform->form_data[$col];
        
    }
    
    
	function edit($id){
		
		$this->myform->form_model["form"]["cancelUrl"] = site_url("admin/unlock/".$this->object."/$id");
		if ($this->myform->edit($id)){
			$this->relation->log("0", $this->object, $id, "edit", $this->cdata_user->get_user_id(), $this->myform->form_data["name"]);
			redirect($this->object."/xview/$id");
		}
		return $this->myform->generate_form();
	}

	
	function create($pclass = "root", $pid = "0"){    
		
		// add value to hidden field in the form
		$_REQUEST["pclass"] = $pclass;
        $_REQUEST["pid"] = $pid;
        $this->myform->form_model["form"]["cancelUrl"] = site_url($pclass."/xview/$pid");
        
		if (isset($_REQUEST['submit'])) {
			$this->myform->form_data = $_REQUEST;			
			if ($this->myform->form_check()){
				$this->myform->form_data['created'] = date("d-m-Y H:i:s");
				// save data
                $id = $this->myform->add_data();
                $this->relation->log("0", $this->object, $id, "add", $this->cdata_user->get_user_id(), $this->myform->form_data["name"]);
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