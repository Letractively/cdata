<?php
/*
 * Created on 20-8-2007
 *
 */


class Page extends Controller {
	
	
	var $object = "page";
	var $permission_object = "module";	
		
	
	
	function Page()
	{	
		parent::Controller();
		$this->load->library("form");
		$this->load->library("cdata_user");
		$this->load->library("layout");
		$this->load->library("relation");
		$this->load->model("pagemodel");
		
	}
	
	// default page
	function index()
	{			
		redirect ($this->object."/xgrid");
	}
	
	
	function xgrid($page = 1){
		
		$this->cdata_user->check_permission($this->permission_object, "list");
		
		$data['search'] = $this->pagemodel->search($page);
		$data['grid'] = $this->pagemodel->grid(null, null, $page);		
		$this->layout->main = $this->load->view($this->object."/xgrid", $data, true);	
		$this->layout->render_page();
		
	}
	
	
	function xcreate($pclass = "", $pid = ""){
		
		$this->cdata_user->check_permission($this->permission_object, "add");
		$data["form"] = $this->pagemodel->create($pclass, $pid);
		$this->layout->main = $this->load->view($this->object."/create",$data,true);		
		$this->layout->render_page();
		
	}
	
	function edit($id){
		
		$this->cdata_user->check_permission($this->permission_object, "edit");
		$data["edit"] = $this->pagemodel->edit($id);
		$this->layout->main = $this->load->view($this->object."/edit",$data,true);		
		$this->layout->render_page();
		
	}
	
	
	function xview($id){
        				
		$this->cdata_user->check_permission($this->permission_object, "view");
		$data = array();     
		$data["view"] = $this->pagemodel->view($id);
		$data = array_merge($data, $this->relation->getViewData("page", $id));
        $this->layout->title = $this->pagemodel->title($id);  
		$this->layout->main = $this->load->view($this->object."/xview", $data, true);	
		$this->layout->render_page();
	}
    
    
    function xprint($id){
    
        $this->cdata_user->check_permission($this->permission_object, "view");
        $data = array(); 
        $this->pagemodel->print = true;  
        $data["view"] = $this->pagemodel->view($id);    
        $data = array_merge($data, $this->relation->getViewData_print($this->object, $id));
        $this->layout->title = $this->pagemodel->title($id);  
        $this->layout->main = $this->load->view($this->object."/xview_print", $data, true);    
        $this->layout->render_page("print");
    
    }
    
	
	function delete($id){
		
		$this->cdata_user->check_permission($this->permission_object, "delete");
		$this->pagemodel->delete($id);	
		
	}
	
}


?>