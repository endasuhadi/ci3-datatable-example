<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Icd extends CI_Controller {

	public function index()
	{
		$this->load->view('icd');
	}

	public function ajax_list()
	{
		$csrf_name = $this->security->get_csrf_token_name();
		$csrf_hash = $this->security->get_csrf_hash();  
		$this->load->model("model_icd","model");
		if($this->input->method(TRUE)=='POST'):
			$list = $this->model->get_datatables();
	        $data = array();
	        $no = $this->input->post('start');
	        $now = strtotime(date("Y-m-d"));
	        foreach ($list as $data1) {
	            	$no++;
	                $row = array();
	                $row[] = $no;
	                $row[] = $data1->kode_icd;
	                $row[] = $data1->nama_icd;
	                $data[] = $row;
			}
			$output = array(
	                        "draw" => $this->input->post('draw'),
	                        "recordsTotal" => $this->model->count_all(),
	                        "recordsFiltered" => $this->model->count_filtered(),
	                        "data" => $data,
	                );
			$output[$csrf_name] = $csrf_hash;  
	        //output to json format
	        echo json_encode($output);
		endif;
	}

}