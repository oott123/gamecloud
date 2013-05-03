<?php
	class Pages_model extends CI_Model {
		function get_all_pages(){
			$this->db->order_by('order','asc');
			$query = $this->db->get('pages');
			$res=array();
			foreach ($query->result_array() as $row){
				$res[$row['id']]=$row;
			}
			return $res;
		}
		function get_page($pageid){
			$pageid += 0;	//a fliter
			$query = $this->db->get_where('pages',array(
				'id'=>$pageid,
			));
			return $query->row_array();
		}
		//pages
		function delete_page($pageid){
			$pageid = $pageid + 0;
			$this->db->delete('pages', array('id' => $pageid));
		}
		function update_page($pageid,$data){
			$pageid = $pageid + 0;
			$this->db->where('id', $pageid);
			$this->db->update('pages', $data);
		}
		function add_page($data){
			$this->db->insert('pages', $data);
		}
	}