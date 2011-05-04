<?php
/*
 * Created on 20-8-2007
 *
 */


class Db extends Controller {
	
	
	var $object = "db";	
	var $permission_object = "db";
		
	
	
	function Db()
	{	
		parent::Controller();
		$this->load->library("cdata_user");
		$this->load->library("layout");
		$this->load->library("relation");
		$this->load->model("dbmodel");
		
	}
	
	// default page
	function index()
	{			
		redirect ($this->object."/xgrid");
	}
	
	
	function xgrid($page = 1){		
		$this->cdata_user->check_permission($this->permission_object, "list");
		$data = array();
		$data['search'] = $this->dbmodel->search($page);
		$data['grid'] = $this->dbmodel->grid(null, null, $page);
		$this->layout->main = $this->load->view($this->object."/grid",$data,true);		
		$this->layout->render_page();
		
	}
	
	function xcreate($pclass = "root", $pid = "0"){    

		$this->cdata_user->check_permission($this->permission_object, "add");
		$data["form"] = $this->dbmodel->create($pclass, $pid);
		$this->layout->main = $this->load->view($this->object."/create",$data,true);		
		$this->layout->render_page();
		
	}
	
	
	function edit($id){
		
		$this->cdata_user->check_permission($this->permission_object, "edit", $id);
		$data["edit"] = $this->dbmodel->edit($id);
		$this->layout->main = $this->load->view($this->object."/edit",$data,true);		
		$this->layout->render_page();
		
	}

	
	function xview($id){
        
		$this->cdata_user->check_permission($this->permission_object, "view", $id);
		$data = array();
          
		$data["view"] = $this->dbmodel->view($id);
		$data = array_merge($data, $this->relation->getViewData($this->object, $id));
        $this->layout->title = $this->dbmodel->title($id);
		$this->layout->main = $this->load->view($this->object."/xview",$data,true);		
		$this->layout->render_page();
		
	}
	
	
	function delete($id){
		
		$this->cdata_user->check_permission($this->permission_object, "delete", $id);
		$this->dbmodel->delete($id);	

	}
    
    
    function admin($id) {
    
        $this->cdata_user->check_permission($this->permission_object, "admin", $id);
        $this->dbmodel->myform->read_data($id);
        $data["id"] = $id;
        $data["class"] = "db";
        $data["dbname"] = $this->dbmodel->myform->form_data["name"];
        $this->layout->main = $this->load->view($this->object."/admin",$data,true);    
        $this->layout->render_page();
    
    }
    
    
    function report($id) {
    
        $this->cdata_user->check_permission($this->permission_object, "report", $id);
        $this->dbmodel->myform->read_data($id);
        $this->load->library("report");
        
        $report = "<h1>Database ".$this->dbmodel->myform->form_data["name"]." report</h1>";
        $pref = $this->relation->fprefix;
        // 
        switch ($id) {
        
        case 5:
        $mod = array();
        $mod["type"] = "PieChart";
        $mod["chart_width"] = "450";
        $mod["chart_height"] = "250";
        $mod["number_prefix"] = "";
        $mod["count_name"] = "tot";
        $mod["count_label"] = "Total";
        $mod["cat_name"] = "sex";
        $mod["cat_label"] = "Gender";
        $mod["title"] = "Gender";
        $mod["query"] = "SELECT sex, count(*) as tot FROM data_patient WHERE path LIKE '%(db-$id)%' GROUP BY sex";
        $report .= $this->report->columnChart($mod);
        
        $mod["count_name"] = "tot";
        $mod["count_label"] = "Total";
        $mod["cat_name"] = "centre";
        $mod["cat_label"] = "Centre";
        $mod["title"] = "Centre";
        $mod["chart_width"] = "650";
        $mod["chart_height"] = "250";
        $mod["query"] = "SELECT centre, count(*) as tot FROM data_patient  WHERE path LIKE '%(db-$id)%' GROUP BY centre";
        $report .= $this->report->pieChart($mod);
        
        
        $mod["cols_label"] = array("Centre","Patients");
        $mod["cols"] = array("centre","tot");
        $mod["title"] = "Patients per Centre";
        $mod["chart_width"] = "500";
        $mod["query"] = "SELECT centre, count(*) as tot FROM data_patient  WHERE path LIKE '%(db-$id)%' GROUP BY centre";
        $report .= $this->report->table($mod);
        
        
        $mod["cols_label"] = array("Patient","Date", "Lab", "Method", "A", "B", "DRB1", "Note");
        $mod["cols"] = array("code","{$pref}fdate", 
        "{$pref}Lab", "{$pref}Method", "{$pref}A", "{$pref}B", "{$pref}DRB1", "{$pref}HLAnote");
        $mod["title"] = "HLA";
        $mod["chart_width"] = "700";
        $mod["query"] = "SELECT 
        data_patient.code as code, 
        data_cdform_16.{$pref}fdate, 
        data_cdform_16.{$pref}Lab, 
        data_cdform_16.{$pref}Method, 
        data_cdform_16.{$pref}A, 
        data_cdform_16.{$pref}B, 
        data_cdform_16.{$pref}DRB1, 
        data_cdform_16.{$pref}HLAnote    
        FROM data_cdform_16, data_patient  
        WHERE data_patient.path LIKE '%(db-$id)%' AND data_cdform_16.path LIKE CONCAT('%(patient-', data_patient.patient_id, ')%')";
        $report .= $this->report->table($mod);
        break;
        // end db5 report
        default:
        $report .="No report available";
        }
        
        
        $this->layout->main = $report;    
        $this->layout->render_page();
        
    }
    
    
    function exportHtml($id){
    
        
    
    }
	
}


?>