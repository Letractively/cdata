<?php

class Subscriptionmodel extends Model{
	
	// user object model vars
	var $search_model = array();
	var $data_model = array();	
	var $form_model = array();		
	var $view_model = array();
	var $list_model = array();
	var $object = "subscription";	
	
	
	function subscriptionmodel(){
		
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
    		"level" => array(
    			"type" => "text"
    			),
    		"object" => array(
    			"type" => "text"
    			),
    		"title" => array(
    			"type" => "text"
    			),
    		"type" => array(
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
    		"level" => array(
    			"type" => "select",
    			"label" => "Level"
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
    		"level" => array(
    			"type" => "select",
    			"label" => "Subscription level",
    			"required" => "true",
    			"select" => array(
    				"multiple" => "false",
    				"null_value" => "false",
    				"interface" => "list",
    				"source" => array(
    					"type" => "array",
    					"options" => array("0" => "This content only", "1"=>"This content and any sub-content")
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
    		"level" => array(
    			"header" => "Level",
    			"type" => "select"
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
		return $this->myform->generate_grid($page);
		
	}
	
	
	function delete($id){
		
		$this->myform->delete_data($id);
		
	}
	
	
	function create($class = "root", $id = "0"){
		
		$this->cdata_user->check_permission("app", "access");
		if (!$this->cdata_user->get_role()>0){$this->cdata_user->noAuth();}
			
		$this->myform->form_data["pclass"] = $class;
		$this->myform->form_data["pid"] = $id;		
		$this->myform->form_model["form"]["cancelUrl"] = site_url("$class/xview/$id");
		
		if(isset($_POST["submit"])){
			$this->myform->form_data = $_POST;
			if ($this->myform->form_check()){			
				$user_id = $this->cdata_user->get_user_id();
				//check 
				$qc = "SELECT subscription_id FROM subscription WHERE pclass = '".$_POST["pclass"]."' AND pid=".$_POST["pid"]." AND user_id = $user_id";
				$rs = mysql_query($qc);
				if (mysql_num_rows($rs)>0){$this->myform->form_error["form"] = "You have already subscribed to this resource";
				} else {
					list($cl, $cid, $name) = $this->relation->getParentNode($class,$id);
			        $title = mysql_real_escape_string( "<a href=\"javascript: ajax.open('$class','$id')\">$name</a>");
			        $date = date("d-m-Y H:i:s");
			        $type = $this->relation->object_table[$class]["name"];
					$this->myform->form_data["title"] = $title;
					$this->myform->form_data["created"] = $date;
					$this->myform->form_data["title"] = $title;
					$this->myform->form_data["type"] = $type;
					$this->myform->form_data["user_id"] = $user_id;
					$this->myform->add_data();
					redirect("$class/xview/$id");
				}
			}
		}		
		return $this->myform->generate_form();
		
	}

	
	function usersNode($class, $id, $level = null){
		if (!isset($level)){
			//no level where cond
			$q = "SELECT user_id FROM subscription WHERE pclass = '$class' AND pid = $id";
		} else {
			$q = "SELECT user_id FROM subscription WHERE pclass = '$class' AND pid = $id AND level = '$level'";
		}
		$rs = mysql_query($q);
		$users = array();
		while($r = mysql_fetch_assoc($rs)){
			$users[] = 	$r["user_id"];
		}
		return $users;
		
	}


}


?>