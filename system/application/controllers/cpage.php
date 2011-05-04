<?php
/*
 * Created on 10-nov-2006
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class Cpage extends Controller {
	
	var $object = "cpage";
	
	function Cpage()
	{	
		parent::Controller();
		$this->load->library("Cdata_user");
		$this->load->library("Layout");
		$this->load->library("Relation");
	}
	
	function index()
	{	
		$this->page("home");
	}
	
	function page($name = null)
	{
		$this->cdata_user->check_permission($this->object);		
		if(!isset($name)) {			
			$name = "home";
		}		
		$this->layout->main = $this->htmlPage($name);
		$this->layout->render_page();		
	}
	
	function htmlPage($name = null)
	{
		if(!isset($name)) {			
			$name = "home";
		}
		$data["title"] = $name;
		return $this->load->view("template/html/$name", $data, true);
	}
	
	function root(){

		$this->cdata_user->check_permission("app", "access");
		$data = array();
		$data["page"] = "Default Application root";
		$data = array_merge($data, $this->relation->getViewData("root", "0"));
		$this->layout->main = $this->load->view("cdata/home", $data, true);
		$this->layout->render_page();
	}
    
    function locked($time, $interval){

        $data = array();
        $data["time"] = $time;
        $data["interval"] = $interval;
        $this->layout->main = $this->load->view("template/html/locked", $data, true);
        $this->layout->render_page();
    }
}
?>