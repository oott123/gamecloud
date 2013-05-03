<?php
	class Cdkeys_model extends CI_Model {
		function validate_cdkeys($key,$pwd='',$del=false){
			$result = $this->db->get_where('cdkey',array('key'=>$key));
			$result = $result->row_array();
			if(isset($result['pwd']) && $pwd && $pwd == $result['pwd'] && $del && $result['amount']>0){
				$this->delete_cdkeys($result['id']);
			}
			return $result;
		}
		//cdkeys
		function gen_cdkey($type,$tid,$amount,$comment,$cdknum = 1){
			$dataset = array();
			for($i=1;$i<=$cdknum;$i++){
				$data = array(
					'key' => rand(10000000,99999999),
					'pwd' => rand(100000,999999),
					'type' => $type,
					'tid' => $tid,
					'amount' => $amount,
					'comment' => $comment,
				);
				$dataset[] = $data;
				$this->db->insert('cdkey',$data);
			}
			return $dataset;
		}
		function get_cdkeys($page){
			$query = $this->db->get('cdkey',30,30*($page-1));
			return $query->result_array();
		}
		function delete_cdkeys($id){
			if(!is_array($id)){
				$id = array($id);
			}
			$this->db->where_in('id',$id);
			$this->db->delete('cdkey');
		}
		function count_cdkeys(){
			return $this->db->count_all_results('cdkey');
		}
	}