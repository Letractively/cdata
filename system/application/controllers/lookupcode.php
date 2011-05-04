<?php
/*
 * Created on 20-8-2007
 *
 */


class Lookupcode extends Controller {
	
	
	// user object model vars
	var $search_model = array();
	var $data_model = array();	
	var $form_model = array();		
	var $view_model = array();
	var $list_model = array();
	var $object = "lookupcode";	
	var $permission_object = "db";
	
	
	function Lookupcode()
	{	
		parent::Controller();
		$this->load->library("form");
		$this->load->library("cdata_user");
		$this->load->library("layout");
		$this->load->library("relation");
		

		
		//lookup code
        
        // data model
		$this->data_model = array(
		'fields' => array(
			"lookuptable_id" => array(
    			"type" => "integer"
    			),
			"code" => array(
    			"type" => "text"
    			),
    		"label" => array(
    			"type" => "text"
    			),
    		"level" => array(
    			"type" => "text"
    			)
    		),
        	'table' => array(
    		'name' => "{$this->object}",
    		'id' => $this->object.'_id',
    		"serialized_column" => "")
		);
		
		// view model
		$this->view_model = array(
		"fields" => array(
    		"name" => array(
    			"type" => "text",
    			"label" => "Code"
    			),
    		"label" => array(
    			"type" => "text",
    			"label" => "Label"
    			),
    		"level" => array(
    			"type" => "text",
    			"label" => "Order"
    			)
    		),
    	"view" => array(
    		"theme" => "default"    	
    		)
		);
		
		// form model
        $this->form_model = array(
		"fields" => array(
			"lookuptable_id" => array(
				"type" => "hidden"
				),
			"code" => array(
    			"type" => "text",
    			"label" => "Code",
    			"required" => "true"
    			),
    		"label" => array(
    			"type" => "text",
    			"label" => "Label",
    			"required" => "true"
    			),
    		"level" => array(
    			"type" => "text",
    			"label" => "Order"
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
    		"code" => array(
    			"header" => "Code",
    			"type" => "text"
    			),
    		"label" => array(
    			"header" => "Label",
    			"type" => "text"
    			),
    		"level" => array(
    			"header" => "Order",
    			"type" => "text"
    			)
    		),
    	"grid" => array(
    		"op" => array( 
    			"edit" => array(
    				"link" => "#",
    				"onclick" => "myedit(lookupcode_id);return false;"
    			),
    			"delete" => array(
    				"link" => "#",
    				"onclick" => "mydelete(lookupcode_id);"
    			),
    			"id" => $this->object."_id"
    		),
    		"filter" => array(    			
    			"maxrows" => "all",
    			"ajaxmaxrows" => "20",
    			"default_sort" => "ORDER BY level ASC"
    		),
    		"table" => $this->object,
    		"base_url" => site_url($this->object."/xgrid"),
    		"theme" => "default",
    		"target" => ""
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
   
	function xgrid($lkpid){
		
		$this->cdata_user->check_permission($this->permission_object, "list");
		$page = 1;
		$this->form->list_model["filter"]["where"] = "lookuptable_id = $lkpid";		
		$data['grid'] = $this->form->generate_grid($page);
		$this->layout->main = $this->load->view($this->object."/xgrid",$data,true);
		$this->layout->render_page("iframe");		
	}
	
    function create($lkpid = null){
        		
    	$this->cdata_user->check_permission($this->permission_object, "add");
    	$this->form->form_data["lookuptable_id"] = $lkpid;
    	$this->form->form_model["form"]["cancelUrl"] = site_url("{$this->object}/create/$lkpid"); 
    	if ($this->form->create()){
    		redirect($this->object."/create/$lkpid");
    	}
		$this->layout->main = $this->load->view($this->object."/create",null,true);
    	$this->layout->render_page("iframe");	
    }
    
    
    function edit($id){
    	
    	$this->cdata_user->check_permission($this->permission_object, "edit");    	   	
    	if ($this->form->edit($id)){
    		redirect($this->object."/create/".$this->form->form_data["lookuptable_id"]);
    	}
    	$tid = $this->form->form_data["lookuptable_id"];
    	$this->form->form_model["form"]["cancelUrl"] = site_url("{$this->object}/create/$tid"); 
    	$this->layout->main = $this->load->view($this->object."/edit",null,true);		
    	$this->layout->render_page("iframe");
    }
    
    
    
    function view($id){
    	
        $this->cdata_user->check_permission($this->permission_object, "view");				
    	$this->form->read_data($id);
    	$data["id"] = $id;
    	$data["list"] = $this->codegrid($id);
    	$this->layout->main = $this->load->view($this->object."/view",$data,true);		
    	$this->layout->render_page();
    }
    
    
    function delete($id){
    	
    	$this->cdata_user->check_permission($this->permission_object, "delete");
    	$this->form->read_data($id);
    	$tid = $this->form->form_data["lookuptable_id"];
    	$this->form->delete_data($id);
    	redirect($this->object."/xgrid/$tid");
    }
	
}


?>