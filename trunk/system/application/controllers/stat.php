<?php
/*
 * Created on 20-8-2007
 *
 */


class Stat extends Controller {
		
	
	
	function Stat()
	{	
		
		parent::Controller();
		$this->load->library("form");
		$this->load->library("cdata_user");
		$this->load->library("layout");
		$this->load->library("relation");		
		
	}
	
	// default page
	function index()
	{			
		
		$this->sys();
		
		
	}
	
	
	function sys(){
		
		$this->cdata_user->check_permission("app", "access");
		$modules = $this->relation->object_table;
		$stat = array();
		foreach ($modules as $key => $prop){
			$tid = $prop["id"];
			$tname = $prop["table"];
			$tclass = $key;
			$name = $prop["name"];
			$stat[$key] = array();
			$stat[$key]["name"] = $name;
			// tot recs
			$q = "SELECT COUNT(*) AS tot FROM $tname";
			$res = mysql_query($q);			
			$r = mysql_fetch_assoc($res);
			$stat[$key]["tot"] =  $r["tot"];					
		}
		
		$data["stat"] = $stat;
        
		$this->layout->main = $this->load->view("stat/sys_summary", $data, true);	
		$this->layout->render_page();
		
	}
    
    
    function db($id = null){
        
        if (is_null($id) ){$id =8;}
        $this->cdata_user->check_permission("app", "access");
        $this->load->model("patientmodel");
        
        
        $q = "SELECT * FROM patient WHERE pclass ='db' AND pid = $id";
        $rows = mysql_query($q);
        $s = array();
        $s["tot"] = 0;
        $s["male"] = 0;
        $s["female"] = 0;
        $s["avgAge"] = null;
        $totAge = 0;
        
        while ($row = mysql_fetch_assoc($rows)){
            
            ++ $s["tot"];
            $this->patientmodel->myform->read_row($row);
            switch($this->patientmodel->myform->form_data["sex"]){
                case "m": ++$s["male"]; break;
                case "f": ++$s["female"]; break;   
            }
            if(!is_null($this->patientmodel->age())) {
                ++$totAge;
                $s["avgAge"] = ($s["avgAge"] + $this->patientmodel->age()) / $totAge;
            }
        } 
        
        
        $data["stat"] = "<h3>Patient Referral DB</h3>
        <b>Patients information</b><br/><br/>
        <b>Total</b>: {$s['tot']}<br/><b>Gender</b>: Male {$s['male']} :: Female {$s['female']}<br/><b>Average Age</b>: {$s['avgAge']}<br/>";
        $this->layout->main = $this->load->view("stat/stat", $data, true);    
        $this->layout->render_page();
        
    }
	
	
	
	
}


?>