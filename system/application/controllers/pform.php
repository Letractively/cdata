<?php
/*
 * Created on 20-8-2007
 *
 */


class Pform extends Controller {
	
	
	var $object = "pform";	
	var $permission_object = "pform";
		
	
	function Pform()
	{	
		parent::Controller();
		$this->load->library("cdata_user");
		$this->load->library("layout");
		$this->load->library("relation");
		$this->load->model("pformmodel");
		
		
	}
	
	// default page
	function index()
	{			
		redirect ($this->object."/xlist");
	}
	
	
	function xfcreate($pclass = null, $pid = null, $cdform = null){
		$cdform = $_REQUEST["cdform_id"];
		$this->cdata_user->check_permission($this->permission_object, "add");
		$data["form"] = $this->pformmodel->fcreate($pclass, $pid, $cdform);
		$this->layout->main = $this->load->view($this->object."/create", $data, true);	
		$this->layout->render_page();
		
	}

	// selection interface for form creation
	function xcreate($pclass = "", $pid = ""){
		
		$this->cdata_user->check_permission($this->permission_object, "add");
		$data["form"] = $this->pformmodel->create($pclass,$pid);				
		$this->layout->main = $this->load->view($this->object."/selectform", $data, true);	
		$this->layout->render_page();
				
	}
	
	
	function edit($id){
		
		$this->cdata_user->check_permission($this->permission_object, "edit", $id);
		$data = array();
		$data["edit"] = $this->pformmodel->edit($id);
		$this->layout->main = $this->load->view($this->object."/edit",$data,true);	
		$this->layout->render_page();
	}
	
	
	function xview($id){
		
		$this->cdata_user->check_permission($this->permission_object, "view", $id);
		$data = array(); 
		$data["view"] = $this->pformmodel->view($id);    
		$data = array_merge($data, $this->relation->getViewData("pform", $id));
        $this->layout->title = $this->pformmodel->title($id);  
		$this->layout->main = $this->load->view($this->object."/xview", $data, true);	
		$this->layout->render_page();
		
	}
    
    function xprint($id){
    
        $this->cdata_user->check_permission($this->permission_object, "view", $id);
        $data = array(); 
        $this->pformmodel->print = true;  
        $data["view"] = $this->pformmodel->view($id);    
        $data = array_merge($data, $this->relation->getViewData_print("pform", $id));
        $this->layout->title = $this->pformmodel->title($id);  
        $this->layout->main = $this->load->view($this->object."/xview_print", $data, true);    
        $this->layout->render_page("print");
    
    }
	
	
	function delete($id){
		
		$this->cdata_user->check_permission($this->permission_object, "delete", $id);
		$this->pformmodel->delete($id);
		
	}
	
}


?>