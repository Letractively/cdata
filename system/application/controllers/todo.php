<?php
/*
 * Created on 20-8-2007
 *
 */


class Todo extends Controller {
	
	
	var $object = "todo";	
	var $permission_object = "module";
			
	
	function Todo()
	{	
		parent::Controller();
		$this->load->library("form");
		$this->load->library("cdata_user");
		$this->load->library("layout");
		$this->load->library("relation");
		$this->load->model("todomodel");
		
	}
	
	// default page
	function index()
	{			
		redirect ($this->object."/xgrid");
	}
	
	
	function xgrid($page = 1){
		
		$this->cdata_user->check_permission($this->permission_object, "list");
		$data['search'] = $this->form->generate_search($page);
		$data['grid'] = $this->todomodel->grid(null, null, $page);
		
		$this->layout->main = $this->load->view($this->object."/xgrid", $data, true);	
		$this->layout->render_page();
		
	}
	
	
	function userlist($userid){
		
		$this->cdata_user->check_permission($this->permission_object, "list");
		$page = 1;
		$this->form->list_model["filter"]["where"] = "assigned REGEXP '[[:<:]]".$userid."[[:>:]]'";
		$data['grid'] = $this->form->generate_grid($page);
		$this->layout->main = $this->load->view($this->object."/xgrid", $data, true);	
		$this->layout->render_page("iframe");
	}
	
	
	function xcreate($pclass = "root", $pid = "0"){    

		$this->cdata_user->check_permission($this->permission_object, "add");
		$data["form"] = $this->todomodel->create($pclass, $pid);
		$this->layout->main = $this->load->view($this->object."/create",$data,true);		
		$this->layout->render_page();
		
	}
	
	
	function edit($id){
		
		$this->cdata_user->check_permission($this->permission_object, "edit", $id);
		$data["edit"] = $this->todomodel->edit($id);
		$this->layout->main = $this->load->view($this->object."/edit",$data,true);		
		$this->layout->render_page();
		
	}

	
	function xview($id){
        
		$this->cdata_user->check_permission($this->permission_object, "view", $id);
		$data = array();
		$data["view"] = $this->todomodel->view($id);
		$data = array_merge($data, $this->relation->getViewData($this->object, $id));
        $this->layout->title = $this->todomodel->title($id);  
		$this->layout->main = $this->load->view($this->object."/xview",$data,true);		
		$this->layout->render_page();
		
	}
	
	
	function delete($id){
		
		$this->cdata_user->check_permission($this->permission_object, "delete", $id);
		$this->todomodel->delete($id);	

	}
	
}


?>