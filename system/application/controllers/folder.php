<?php
/*
 * Created on 20-8-2007
 *
 */


class Folder extends Controller {	
	
	
	var $object = "folder";	
	var $permission_object = "module";
		
	
	
	function Folder()
	{	
		parent::Controller();
		$this->load->library("form");
		$this->load->library("cdata_user");
		$this->load->library("layout");
		$this->load->library("relation");
		$this->load->model("foldermodel");
		
	}
	
	// default page
	function index()
	{			
		redirect ($this->object."/xgrid");
	}
	
	
	function xgrid($page = 1){
		
		$this->cdata_user->check_permission($this->permission_object, "list");
		$data['search'] = $this->form->generate_search($page);
		$data['grid'] = $this->projectmodel->grid(null, null, $page);
		$this->layout->main = $this->load->view($this->object."/xgrid", $data, true);	
		$this->layout->render_page();
		
	}
	
	
	function xcreate($pclass = null, $pid = null){
		
		$this->cdata_user->check_permission($this->permission_object, "add");
		$data["form"] = $this->foldermodel->create($pclass, $pid);
		$this->layout->main = $this->load->view($this->object."/create",$data,true);		
		$this->layout->render_page();
		
	}
	
	
	function edit($id){
		
		$this->cdata_user->check_permission($this->permission_object, "edit");
		$data["edit"] = $this->foldermodel->edit($id);
		$this->layout->main = $this->load->view($this->object."/edit",$data,true);		
		$this->layout->render_page();
		
	}
	
	
	function xview($id){

		$this->cdata_user->check_permission($this->permission_object, "view");
		$data = array();
		$data["view"] = $this->foldermodel->view($id);
		$data = array_merge($data, $this->relation->getViewData($this->object, $id));
        $this->layout->title = $this->foldermodel->title($id);  
		$this->layout->main = $this->load->view($this->object."/xview",$data,true);		
		$this->layout->render_page();
		
	}
    
    
    function xprint($id){
    
        $this->cdata_user->check_permission($this->permission_object, "view");
        $data = array(); 
        $this->foldermodel->print = true;  
        $data["view"] = $this->foldermodel->view($id);    
        $data = array_merge($data, $this->relation->getViewData_print($this->object, $id));
        $this->layout->title = $this->foldermodel->title($id);  
        $this->layout->main = $this->load->view($this->object."/xview_print", $data, true);    
        $this->layout->render_page("print");
    
    }
	
	
	function delete($id){
		
		$this->cdata_user->check_permission($this->permission_object, "delete");
		list($pclass, $pid, $title) = $this->relation->getParentNode($this->object, $id);
		$this->relation->delete("folder", $id);	
		$this->relation->log("0", $this->object, $id, "del", $this->cdata_user->get_user_id(), $title);
		redirect("$pclass/xview/$pid");
	}
	
}


?>