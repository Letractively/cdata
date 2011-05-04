<?php
/*
 * Created on 20-8-2007
 *
 */


class Project extends Controller {
	
	
	var $object = "project";
	var $permission_object = "module";	
		
	
	
	function Project()
	{	
		parent::Controller();
		$this->load->library("form");
		$this->load->library("cdata_user");
		$this->load->library("layout");
		$this->load->library("relation");
		$this->load->model("projectmodel");
		
	}
	
	// default page
	function index()
	{			
		redirect ($this->object."/xgrid");
	}
	
	
	function xgrid($page = 1){
		
		$this->cdata_user->check_permission($this->permission_object, "list");
		$data = array();
		$data['search'] = $this->projectmodel->search($page);
		$data['grid'] = $this->projectmodel->grid(null, null, $page);
		$this->layout->main = $this->load->view($this->object."/xgrid",$data,true);		
		$this->layout->render_page();
		
	}

	
	function xcreate($pclass = "", $pid = ""){
		
		$this->cdata_user->check_permission($this->permission_object, "add");
		$data["form"] = $this->projectmodel->create($pclass, $pid);
		$this->layout->main = $this->load->view($this->object."/create",$data,true);		
		$this->layout->render_page();
	}
	
	function edit($id){
		
		$this->cdata_user->check_permission($this->permission_object, "edit");
		$data["edit"] = $this->projectmodel->edit($id);
		$this->layout->main = $this->load->view($this->object."/edit",$data,true);		
		$this->layout->render_page();
		
	}
	
	
	function xview($id){
        				
		$this->cdata_user->check_permission($this->permission_object, "view");
		$data = array();
		$data["view"] = $this->projectmodel->view($id);
		$data = array_merge($data, $this->relation->getViewData($this->object, $id));
        $this->layout->title = $this->projectmodel->title($id);  
		$this->layout->main = $this->load->view($this->object."/xview",$data,true);		
		$this->layout->render_page();
		
	}
	
	function delete($id){
		
		$this->cdata_user->check_permission($this->permission_object, "delete");
		$this->projectmodel->delete($id);	
		
	}
	
}


?>