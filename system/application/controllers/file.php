<?php
/*
 * Created on 20-8-2007
 *
 */


class File extends Controller {
	
	
	var $object = "file";	
	var $permission_object = "module";
		
	
	
	function File()
	{	
		
		parent::Controller();
		$this->load->library("form");
		$this->load->library("cdata_user");
		$this->load->library("layout");
		$this->load->library("relation");
		$this->load->model("filemodel");
		
	}
	
	// default page
	function index()
	{			
		redirect ($this->object."/xgrid");
	}
	
	
	function xgrid($page = 1){
		
		$this->cdata_user->check_permission($this->permission_object, "list");
		$data['search'] = $this->filemodel->search($page);
		$data['grid'] = $this->filemodel->grid(null, null, $page);
		
		$this->layout->main = $this->load->view($this->object."/xgrid", $data, true);	
		$this->layout->render_page();
		
	}

	
	function xcreate($pclass, $pid){
		
		$this->cdata_user->check_permission($this->permission_object, "add");
		$data["form"] = $this->filemodel->create($pclass, $pid);
		$this->layout->main = $this->load->view($this->object."/xcreate",$data,true);		
		$this->layout->render_page();
		
	}
	
	
	function edit($id){
		
		$this->cdata_user->check_permission($this->permission_object, "edit");
		$data["edit"] = $this->filemodel->edit($id);
		$this->layout->main = $this->load->view($this->object."/edit",$data,true);		
		$this->layout->render_page();
		
	}
	
	
	function xview($id){

		$this->cdata_user->check_permission($this->permission_object, "view");
		$data["view"] = $this->filemodel->view($id);
		$data = array_merge($data, $this->relation->getViewData($this->object, $id));
        $this->layout->title = $this->filemodel->title($id);  
		$this->layout->main = $this->load->view($this->object."/xview",$data,true);		
		$this->layout->render_page();
		
	}
    
    
    function xprint($id){
    
        $this->cdata_user->check_permission($this->permission_object, "view");
        $data = array(); 
        $this->filemodel->print = true;  
        $data["view"] = $this->filemodel->view_print($id);    
        $data = array_merge($data, $this->relation->getViewData_print($this->object, $id));
        $this->layout->title = $this->filemodel->title($id);  
        $this->layout->main = $this->load->view($this->object."/xview_print", $data, true);    
        $this->layout->render_page("print");
    
    }
	
	
	function download($id, $disposition = "inline"){
        
		$this->cdata_user->check_permission($this->permission_object, "view");
        $this->filemodel->download($id, $disposition);
        	
	}
	
	function delete($id){
		
		$this->cdata_user->check_permission($this->permission_object, "delete");
		$this->filemodel->delete($id);	

	}
	
	
}


?>