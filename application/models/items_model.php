<?php
	class Items_model extends CI_Model {
		function get_all_items(){
			$this->db->order_by('id','asc');
			$query = $this->db->get('items');
			$res=array();
			foreach ($query->result_array() as $row){
				$res[$row['id']]=$row;
			}
			return $res;
		}
		function get_item($id){
			$id += 0;	//a fliter
			$query = $this->db->get_where('items',array(
				'id'=>$id,
			));
			return $query->row_array();
		}
		//items
		function update_items($items){
			if(!is_array($items)){
				return false;
			}
			$this->db->empty_table('items');
			foreach($items as $item){
				if(!isset($item['id']) || !isset($item['name'])) continue;	//容错
				$data = array(
					'id' => $item['id']+0,
					'name' => $item['name'],
				);
				$this->db->insert('items',$data);
			}
		}
	}