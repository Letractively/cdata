<?php
/*
 * Created on 20-8-2007
 *
 */


class Patient extends Controller {
	
	
	var $object = "patient";	
	var $permission_object = "patient";
		
	
	
	function Patient()
	{	
		
		parent::Controller();
		$this->load->library("form");
		$this->load->library("cdata_user");
		$this->load->library("layout");
		$this->load->library("relation");
        $this->load->library("report");
		$this->load->model("patientmodel");		
		
	}
	
	// default page
	function index()
	{			
		redirect ($this->object."/xgrid");
	}
	
	
	function xgrid($page = 1){
		
		$this->cdata_user->check_permission($this->permission_object, "list", $id);
		$data['grid'] = $this->patientmodel->grid(null, null, $page);
		$this->layout->main = $this->load->view($this->object."/xgrid", $data, true);	
		$this->layout->render_page();
		
	}
	
	
	function xcreate($pclass = "root", $pid = "0"){    

		$this->cdata_user->check_permission($this->permission_object, "add", $id);
		$data["form"] = $this->patientmodel->create($pclass, $pid);
		$this->layout->main = $this->load->view($this->object."/create",$data,true);		
		$this->layout->render_page();
		
	}
	
	
	function edit($id){
		
		$this->cdata_user->check_permission($this->permission_object, "edit", $id);
		$data["edit"] = $this->patientmodel->edit($id);
		$this->layout->main = $this->load->view($this->object."/edit",$data,true);		
		$this->layout->render_page();
	}
	
	
	function cdform_list(){
		
		$q = "SELECT cdform_id, CONCAT(name, ' v.', version) as label FROM cdform ORDER BY name ASC, version DESC";
		$rows = mysql_query($q);
		$r = array();
		while ( $row = mysql_fetch_assoc($rows)){
			$r[$row["cdform_id"]] = $row["label"];
		}
		return $r;
	}

		
	function xview($id){
        				
		$this->cdata_user->check_permission($this->permission_object, "view", $id);	
		$data = array();
		$data["view"] = $this->patientmodel->view($id);
		$data = array_merge($data, $this->relation->getViewData("patient", $id));
        $this->layout->title = $this->patientmodel->title($id);  
		$this->layout->main = $this->load->view($this->object."/xview", $data, true);
		$this->layout->render_page();
	}
    
    
    function xprint($id){
    
        $this->cdata_user->check_permission($this->permission_object, "view", $id);
        $data = array(); 
        $this->patientmodel->print = true;  
        $data["view"] = $this->patientmodel->view($id);    
        $data = array_merge($data, $this->relation->getViewData_print($this->object, $id));
        $this->layout->title = $this->patientmodel->title($id);  
        $this->layout->main = $this->load->view($this->object."/xview_print", $data, true);    
        $this->layout->render_page("print");
    
    }
	
	
	function delete($id){
		
		$this->cdata_user->check_permission($this->permission_object, "delete", $id);
		$this->patientmodel->delete($id);	
		
	}
    
    
    function admin($id) {
    
        $this->cdata_user->check_permission($this->permission_object, "admin", $id);
        $this->patientmodel->myform->read_data($id);
        $data["id"] = $id;
        $data["class"] = "patient";
        $data["name"] = $this->patientmodel->myform->form_data["code"];
        $this->layout->main = $this->load->view($this->object."/admin",$data,true);    
        $this->layout->render_page();
    
    }
    
    
    function report($id) {
    
        $this->cdata_user->check_permission($this->permission_object, "report", $id);
        $this->patientmodel->myform->read_data($id);
        $pref = $this->relation->fprefix;
        
        $report = "<h1>Report :: patient ".$this->patientmodel->myform->form_data["code"]."</h1>";
        
        $path = $this->relation->getPath("patient", $id);
        if (preg_match("(db-5)", $path) == 0){
            $report .="No report available";
            $this->layout->main = $report;    
            $this->layout->render_page();
            return;
        }
        
        // wbc
        $table = "data_cdform_13";
        $fx = "{$pref}fdate";
        $fy = "{$pref}dailywbc";
        
        $mod = array();
        $mod["type"] = "LineChart";
        $mod["x_name"] = $fx;
        $mod["x_label"] = "Date";
        $mod["y_name"] = $fy;
        $mod["y_label"] = "Daily WBC";
        $mod["title"] = "WBC count";
        $mod["chart_width"] = "450";
        $mod["chart_height"] = "150";
        $mod["number_prefix"] = "";
        $mod["query"] = "SELECT $fx, $fy FROM $table WHERE $fy IS NOT NULL and path LIKE '%(patient-$id)%' ORDER BY $fx ASC";
        
        $report .= $this->report->lineChart($mod);
        
        $fx = "{$pref}fdate";
        $fy = "{$pref}dailyanc";
        $mod["y_name"] = $fy;
        $mod["y_label"] = "Daily ANC";
        $mod["title"] = "ANC count";
        $mod["query"] = "SELECT $fx, $fy FROM $table WHERE $fy IS NOT NULL and path LIKE '%(patient-$id)%'";
        $report .= $this->report->lineChart($mod);
        
        $fx = "{$pref}fdate";
        $fy = "{$pref}dailyalc";
        $mod["y_name"] = $fy;
        $mod["y_label"] = "Daily ALC";
        $mod["title"] = "ALC count";
        $mod["query"] = "SELECT $fx, $fy FROM $table WHERE $fy IS NOT NULL and path LIKE '%(patient-$id)%'";
        $report .= $this->report->lineChart($mod);
        
        $fx = "{$pref}fdate";
        $fy = "{$pref}dailyhb";
        $mod["y_name"] = $fy;
        $mod["y_label"] = "Daily HB";
        $mod["title"] = "HB";
        $mod["query"] = "SELECT $fx, $fy FROM $table WHERE $fy IS NOT NULL and path LIKE '%(patient-$id)%'";
        $report .= $this->report->lineChart($mod);
        
        $fx = "{$pref}fdate";
        $fy = "{$pref}dailyplatelets";
        $mod["y_name"] = $fy;
        $mod["y_label"] = "Daily Platelets";
        $mod["title"] = "Platelets";
        $mod["query"] = "SELECT $fx, $fy FROM $table WHERE $fy IS NOT NULL and path LIKE '%(patient-$id)%'";
        $report .= $this->report->lineChart($mod);
        
        $fx = "{$pref}fdate";
        $fy = "{$pref}dailyNa";
        $mod["y_name"] = $fy;
        $mod["y_label"] = "Daily Na";
        $mod["title"] = "Na";
        $mod["query"] = "SELECT $fx, $fy FROM $table WHERE $fy IS NOT NULL and path LIKE '%(patient-$id)%'";
        $report .= $this->report->lineChart($mod);
        
        $fx = "{$pref}fdate";
        $fy = "{$pref}dailyK";
        $mod["y_name"] = $fy;
        $mod["y_label"] = "Daily K";
        $mod["title"] = "K";
        $mod["query"] = "SELECT $fx, $fy FROM $table WHERE $fy IS NOT NULL and path LIKE '%(patient-$id)%'";
        $report .= $this->report->lineChart($mod);
        
        $fx = "{$pref}fdate";
        $fy = "{$pref}dailysgpt";
        $mod["y_name"] = $fy;
        $mod["y_label"] = "Daily SGPT";
        $mod["title"] = "SGPT";
        $mod["query"] = "SELECT $fx, $fy FROM $table WHERE $fy IS NOT NULL and path LIKE '%(patient-$id)%'";
        $report .= $this->report->lineChart($mod);
        
        $fx = "{$pref}fdate";
        $fy = "{$pref}dailytotbilirubin";
        $mod["y_name"] = $fy;
        $mod["y_label"] = "Daily Bilirubin Tot";
        $mod["title"] = "Bilirubin Tot";
        $mod["query"] = "SELECT $fx, $fy FROM $table WHERE $fy IS NOT NULL and path LIKE '%(patient-$id)%'";
        $report .= $this->report->lineChart($mod);
        
        $fx = "{$pref}fdate";
        $fy = "{$pref}dailycreatinine";
        $mod["y_name"] = $fy;
        $mod["y_label"] = "Daily Creatinine";
        $mod["title"] = "Creatinine";
        $mod["query"] = "SELECT $fx, $fy FROM $table WHERE $fy IS NOT NULL and path LIKE '%(patient-$id)%'";
        $report .= $this->report->lineChart($mod);
        
        $fx = "{$pref}fdate";
        $fy = "{$pref}dailymaxtemperature";
        $mod["y_name"] = $fy;
        $mod["y_label"] = "Daily Max temperature";
        $mod["title"] = "Temperature Max";
        $mod["query"] = "SELECT $fx, $fy FROM $table WHERE $fy IS NOT NULL and path LIKE '%(patient-$id)%'";
        $report .= $this->report->lineChart($mod);
        
        
        $this->layout->main = $report;    
        $this->layout->render_page();
        
    }
    
	
}


?>