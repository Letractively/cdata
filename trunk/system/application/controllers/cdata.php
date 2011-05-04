<?php
/*
 * Created on 20-8-2007
 *
 */


class Cdata extends Controller {

	
	function Cdata()
	{	
		parent::Controller();
		$this->load->library("form");
		$this->load->library("cdata_user");
		
		// data model
		$this->data_model = array(
		'fields' => array(),
        	'table' => array(
        		'name' => "",
        		'id' => $this->object.'_id',
        		"serialized_column" => "data"
        		)
		);
		
		// view model
		$this->view_model = array(
		"fields" => array(),
    	"view" => array(
    		"theme" => "default"
    		)
		);
		
		// form model
        $this->form_model = array(
		"fields" => array(    		
    		),
    	"form" => array(
    		"name" => "",
    		"method" => "post",
    		"action" => "",
    		"delete" => array(
				"link" => "",
				"id" => ""
				),
			"theme" => "default"
    		)
		);
		
		
		
		// search form model
        $this->search_model = array(
        	"fields" => array(
        		),
        	"orderby" => array(
        		"order1" => array(
        			"options" => array(
        			)
        		)
        	),
        	"form" => array(
        		'name' => ""
        		)
    	);
		
		// 
		$this->list_model = array(
		"fields" => array(
    		),
    	"grid" => array(
    		"op" => array(
    			"add" => array(
    				"link" => ""
    			),
    			"edit" => array(
    				"link" => ""
    			),
    			"view" => array(
    				"link" => ""
    			),
    			"id" => ""
    		),
    		"filter" => array(    			
    			"maxrows" => "20",
    			"default_sort" => ""
    		),
    		"table" => "",
    		"base_url" => "",
    		"theme" => "default"
    		)
		);
		
		$theme_form = "default";
		
		
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
		//redirect ($this->object."/xgrid");
	}
	
	
	function xgrid($page = 1){
		
		$data['search'] = $this->form->generate_search($page);;
		$data['grid'] = $this->form->generate_grid($page);
		$data["content"] = $this->load->view($this->object."/xgrid",$data,true);
		
		$this->template_print($data);
		
	}
	
	
	function create(){
        
		if (isset($_REQUEST['submit'])) {
			$this->form->form_data = $_REQUEST;
			
			if ($this->form->form_check()){
				$this->form->form_data['created'] = date("d-m-Y H:i:s");
				// save data
                $sql = $this->form->add_data();
                redirect("{$this->object}/xgrid");
			}
		}
		
		$data['content'] = $this->load->view($this->object."/create", null, true);
		$this->template_print($data);
	}
	
	
	function edit($id){
		
		if ($this->form->edit($id)){
			redirect($this->object."/xgrid");
		}
		$data['content'] = $this->load->view($this->object."/edit", null, true);
		$this->template_print($data);
	}
	

	
	function view($id){
        				
		$this->form->read_data($id);
		$data["id"] = $id;
		$data["content"] = $this->load->view($this->object."/view", $data, true);
		
		$this->template_print($data);
	}
	
	function template_print($data)
	{
		$data["header"] = $this->load->view($this->config->item("cdata_template_dir")."header",$data, true);
		$data["footer"] = $this->load->view($this->config->item("cdata_template_dir")."footer",$data, true);
		$this->load->view($this->config->item("cdata_template_dir")."container", $data);		
	}
	
	
	
	function delete($id){
		$this->form->delete_data($id);
		redirect($this->object."/xgrid");
	}
	
}


?>