<?php

class Model_icd extends CI_Model{
	public $table = "tbl_icd";
	var $column_order = array('id_icd','kode_icd','nama_icd');
    var $column_search = array('id_icd','kode_icd','nama_icd');
    var $order = array('tbl_icd.id_icd' => 'desc');

	function __construct()
	{
		parent::__construct();
	}

	private function _get_datatables_query()
    {
        $from = $this->db->from($this->table);
 
        $i = 0;
     
        foreach ($this->column_search as $item)
        {
            if($this->input->post('search')['value'])
            {
                 
                if($i===0)
                {
                    $this->db->group_start();
                    $this->db->like($item, $this->input->post('search')['value']);
                }
                else
                {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }
 
                if(count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
         
        if($this->input->post('order'))
        {
            $this->db->order_by($this->column_order[$this->input->post('order')['0']['column']], $this->input->post('order')['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    public function get_datatables()
    {
        $this->_get_datatables_query();
        if($this->input->post('lengt') != -1)
        $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }
 
    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $query = $this->db->from($this->table);
        return $this->db->count_all_results();
    }

}