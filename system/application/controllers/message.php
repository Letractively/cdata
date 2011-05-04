<?php
/*
 * Created on 20-8-2007
 *
 */


class Message extends Controller {
	
	
	// user object model vars
	var $search_model = array();
	var $data_model = array();	
	var $form_model = array();		
	var $view_model = array();
	var $list_model = array();
	var $object = "message";	
		
	
	
	function Bookmark()
	{	
		parent::Controller();
		$this->load->library("form");
		$this->load->library("cdata_user");
		$this->load->library("layout");
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
    		"subject" => array(
    			"type" => "text"
    			),
    		"body" => array(
    			"type" => "text"
    			),	
    		"assigned" => array(
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
    		"subject" => array(
    			"type" => "text",
    			"label" => "Type"
    			),
    		"body" => array(
    			"type" => "html",
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
    				"link" => "javascript: ajax.delete('{$this->object}_id');"
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
		
		$this->cdata_user->check_permission($this->object, "list");
		$data['search'] = $this->form->generate_search($page);
		$data['grid'] = $this->form->generate_grid($page);
		
		$this->layout->main = $this->load->view($this->object."/xgrid", $data, true);	
		$this->layout->render_page();
		
	}
	
	function xlist($userid){
		
		$this->cdata_user->check_permission($this->object, "list");
		$page = 1;
		$this->form->list_model["filter"]["where"] = "user_id = $userid";
		$data['grid'] = $this->form->generate_grid($page);
		$this->layout->main = $this->load->view($this->object."/xgrid", $data, true);	
		$this->layout->render_page("iframe");
	}
	
	function create($pclass, $pid){
		
		$this->cdata_user->check_permission($this->object, "create");
		$this->relation->bookmark($pclass, $pid);
		
	}
	
	function edit($id){
		
		$this->cdata_user->check_permission($this->object, "edit");
		$this->form->form_model["form"]["cancelUrl"] = site_url($this->object."/view/$id");
		if ($this->form->edit($id)){
			redirect($this->object."/view/$id");
		}
		$this->layout->main = $this->load->view($this->object."/edit", $data, true);	
		$this->layout->render_page("iframe");
	}
	
	function view($id){

		$this->cdata_user->check_permission($this->object, "view");
		$this->form->read_data($id);
		$this->form->form_data["title"] = "<a href=\"".$this->form->form_data["url"]."\">".$this->form->form_data["title"]."</a>";
		$data["id"] = $id;
		$data["class"] = $this->object;
		$this->layout->main = $this->load->view($this->object."/view", $data, true);	
		$this->layout->render_page("iframe");
	}
	
	function xview($id){
        				
		$this->cdata_user->check_permission($this->object, "view");
		$data = array();     
		$data = array_merge($data, $this->relation->getViewData($this->object, $id));
		$this->layout->main = $this->load->view($this->object."/xview", $data, true);	
		$this->layout->render_page();
	}
	
	function delete($id){
		
		$this->cdata_user->check_permission($this->object, "delete");
		$this->form->delete_data($id);
	}
	
}


?>