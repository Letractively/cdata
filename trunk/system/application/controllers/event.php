<?php
/*
 * Created on 20-8-2007
 *
 */


class Event extends Controller {
	
	
	var $object = "event";	
	var $permission_object = "module";
		
	
	
	function Event()
	{	
		parent::Controller();
		$this->load->library("form");
		$this->load->library("cdata_user");
		$this->load->library("layout");
		$this->load->library("relation");
		$this->load->model("eventmodel");
		
	}
	
	// default page
	function index()
	{			
		redirect ($this->object."/xgrid");
	}
	
	
	function xgrid($page = 1){
		
		$this->cdata_user->check_permission($this->permission_object, "list");
		$data['search'] = $this->myform->generate_search($page);
		$data['grid'] = $this->eventmodel->grid(null, null, $page);
		
		$this->layout->main = $this->load->view($this->object."/xgrid", $data, true);	
		$this->layout->render_page();
		
	}
	
	function userlist(){
		
		$this->cdata_user->check_permission($this->permission_object, "list");
		$page = 1;
		$this->form->list_model["filter"]["orderby"] = "start DESC";
		$data['grid'] = $this->form->generate_grid($page);	
		$this->layout->main = $this->load->view($this->object."/xgrid", $data, true);	
		$this->layout->render_page("iframe");
	}
	
	function xcreate($pclass = "", $pid = ""){
		
		$this->cdata_user->check_permission($this->permission_object, "add");
		$data["form"] = $this->eventmodel->create($pclass, $pid);
		$this->layout->main = $this->load->view($this->object."/create",$data,true);		
		$this->layout->render_page();
		
	}
	
	function edit($id){
		
		$this->cdata_user->check_permission($this->permission_object, "edit");
		$data["edit"] = $this->eventmodel->edit($id);
		$this->layout->main = $this->load->view($this->object."/edit",$data,true);		
		$this->layout->render_page();
		
	}
	
	
	function xview($id){
        				
		$this->cdata_user->check_permission($this->permission_object, "view");
		$data = array();
		$data["view"] = $this->eventmodel->view($id);
		$data = array_merge($data, $this->relation->getViewData($this->object, $id));
        $this->layout->title = $this->eventmodel->title($id);  
		$this->layout->main = $this->load->view($this->object."/xview",$data,true);		
		$this->layout->render_page();
		
	}
	
	function delete($id){
		
		$this->cdata_user->check_permission($this->permission_object, "delete");
		$this->eventmodel->delete($id);	

	}	
	
}


?>