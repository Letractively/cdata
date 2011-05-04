<?php

class Foldermodel extends Model{
	
	// user object model vars
	var $search_model = array();
	var $data_model = array();	
	var $form_model = array();		
	var $view_model = array();
	var $list_model = array();
	var $myform;
	var $object = "folder";	
	
	
	function foldermodel(){
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
    		"created" => array(
    			"type" => "datetime"
    			),
    		"listorder" => array(
    			"type" => "integer"
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
    		"teaser" => array(
    			"type" => "text",
    			"label" => "Teaser"
    			),    	 	
    		"created" => array(
    			"type" => "datetime",
    			"label" => "Created"
    			),
    		"listorder" => array(
    			"type" => "integer",
    			"label" => "List order"
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
    		"name" => array(
    			"type" => "text",
    			"label" => "Name",
    			"lenght" => "60",
    			"required" => "true"
    			),      		
    		"teaser" => array(
    			"type" => "textarea",
    			"label" => "Teaser",
    			"rows" => "5",
    			"cols" => "60",
    			"required" => "false",
    			"editor" => "false"
    			),
    		"listorder" => array(
    			"type" => "integer",
    			"label" => "List order",
    			"lenght" => "10",
    			"required" => "false"
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
        			"field" => "title, teaser"
        			),
        		),
        	"orderby" => array(
        		"order1" => array(
        			"options" => array(
        				"title" => "Name",
        				"created" => "Created"
        			)
        		)
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
    		"teaser" => array(
    			"header" => "Teaser",
    			"type" => "text"
    			),
    		"created" => array(
    			"header" => "Created",
    			"type" => "datetime"
    			)
    		),
    	"grid" => array(
    		"op" => array(
    			"add" => array(
    				"link" => "{$this->object}/create"
    			),
    			"view" => array(
    				"link" => site_url("{$this->object}/xview/folder_id")
    			),
    			"id" => $this->object."_id"
    		),
    		"filter" => array(    			
    			"maxrows" => "all",
    			"default_sort" => "ORDER BY listorder ASC, name ASC"
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
		
	}	

	
	function grid($pclass = "", $pid = "", $page = 1){
		
		if ($pclass > ""){
			$this->myform->list_model["filter"]["pclass"] = $pclass;
			$this->myform->list_model["filter"]["pid"] = $pid;
			$folderImg = $this->config->item("images")."folder.gif";
			$this->myform->list_model["grid"]["theme"] = '
<?php foreach($data["rows"] as $row){?>		
<h2><img src="'.$folderImg.'" align="bottom"/><a target="_parent" href="<?php print site_url("folder/xview/".$row["id"]);?>"><?php print $row["name"];?></a></h2>
<p><?php print $row["teaser"];?></p>
<?php
}?>
<br/>
';
		}
		return $this->myform->generate_grid($page);			
	
	}
    
    
    function grid_print($pclass = "", $pid = "", $page = 1){
        
        if ($pclass > ""){
            $this->myform->list_model["filter"]["pclass"] = $pclass;
            $this->myform->list_model["filter"]["pid"] = $pid;
            $folderImg = $this->config->item("images")."folder.gif";
            $this->myform->list_model["grid"]["theme"] = '
<?php foreach($data["rows"] as $row){?>        
<h4><a target="_parent" href="folder_xview_<?php print $row["id"];?>"><?php print $row["name"];?></a></h4>
<p><?php print $row["teaser"];?></p>
<?php
}?>
<br/>
';
        }
        return $this->myform->generate_grid($page);            
    
    }

	
	function view($id){
        
		$data["id"] = $id;
		$data["class"] = $this->object;
		$theme = '<h1><?php print $data["name"];?></h1>
		<p><?php print $data["teaser"];?></p>
		<i><?php print $data["created"];?></i>';
		
        $this->myform->view_model["view"]["theme"] = $theme; 
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
	
	function add($data){
		
		$this->myform->form_data = $data;
		$this->myform->add_data();	
	}
	
}


?>