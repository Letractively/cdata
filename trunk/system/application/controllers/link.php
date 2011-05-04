<?php
/*
 * Created on 20-8-2007
 *
 */


class Link extends Controller {
	
	
	var $object = "link";	
	var $permission_object = "module";
		
	
	
	function Link()
	{	
		parent::Controller();
		$this->load->library("form");
		$this->load->library("cdata_user");
		$this->load->library("layout");
		$this->load->library("relation");
		$this->load->model("linkmodel");
		
	}
	
	// default page
	function index()
	{			
		redirect ($this->object."/xgrid");
	}
	
	
	function xgrid($page = 1){
		
		$this->cdata_user->check_permission($this->permission_object, "list");
		$data['search'] = $this->linkmodel->search();
		$data['grid'] = $this->linkmodel->grid(null, null,$page);
		
		$this->layout->main = $this->load->view($this->object."/xgrid", $data, true);	
		$this->layout->render_page();
		
	}
	
	
	function xcreate($pclass = "root", $pid = "0"){    

		$this->cdata_user->check_permission($this->permission_object, "add");
		$data["form"] = $this->linkmodel->create($pclass, $pid);
		$this->layout->main = $this->load->view($this->object."/create",$data,true);		
		$this->layout->render_page();
		
	}
	
	
	function edit($id){
		
		$this->cdata_user->check_permission($this->permission_object, "edit");
		$data["edit"] = $this->linkmodel->edit($id);
		$this->layout->main = $this->load->view($this->object."/edit",$data,true);		
		$this->layout->render_page();
		
	}

	
	function xview($id){
        
		$this->cdata_user->check_permission($this->permission_object, "view");
		$data = array();
		$data["view"] = $this->linkmodel->view($id);
		$data = array_merge($data, $this->relation->getViewData($this->object, $id));
        $this->layout->title = $this->linkmodel->title($id);  
		$this->layout->main = $this->load->view($this->object."/xview",$data,true);		
		$this->layout->render_page();
		
	}
	
	
	function delete($id){
		
		$this->cdata_user->check_permission($this->permission_object, "delete");
		$this->linkmodel->delete($id);	

	}
	
}


?>