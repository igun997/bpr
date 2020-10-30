<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Indie_Model extends CI_Model{

	private $is_pagination = FALSE;
	private $pagination_data = [];

	private $limit = 0;
	private $offset = 0;

	protected $_table_name;
	protected $_primary_key;
	protected $_object_name;
	private $is_cache_enabled = FALSE;
	private $caching = [];
	private $joins = [];
	private $selects = [];
	private $join_selects = [];
	private $join_task = [];

	private $position = TRUE;
	private $middleware_use = FALSE;
	private $mid_name = NULL;
	private $anon;

	protected $fields;

	protected $db_name;

	public function __construct(){

		parent::__construct();

		$this->_table_name = NULL;
		$this->_primary_key = NULL;

		$this->fields = [];
	}

	protected function _join(String $table, String $condition, String $type = ''){

		$this->db->db_select($this->db_name);

		if(!in_array($table, $this->joins)){

			// $this->db->join($table, $condition, $type);
			$this->join_task[] = [
				'table' => $table,
				'condition' => $condition,
				'type' => $type
			];
			$this->joins[] = $table;
		}
	}

	protected function _start_query_cache(){

		$this->db->db_select($this->db_name);

		if(!$this->is_cache_enabled){

			$this->db->start_cache();
			$this->is_cache_enabled = TRUE;
		}
	}

	public function count(){
		$this->db->db_select($this->db_name);

		if ($this->join_task) {

			foreach ($this->join_task as $join_task) {

				extract($join_task);

				$this->db->join($table, $condition, $type);
			}
		}



		if($this->is_cache_enabled){

			$this->db->stop_cache();
		}

		$count = $this->db->count_all_results($this->_table_name);

		if($this->is_cache_enabled){

			$this->db->flush_cache();
			$this->is_cache_enabled = FALSE;
			$this->resetFilter();
		}

		return $count;
	}

	public function find($force_raw = FALSE){

		$this->db->db_select($this->db_name);

		if ($this->join_task) {

			foreach ($this->join_task as $join_task) {

				extract($join_task);

				$this->db->join($table, $condition, $type);
			}
		}
		if($this->is_cache_enabled){

			$this->db->stop_cache();
		}
		if($this->is_pagination){

			$this->db->limit($this->limit, $this->offset);
		}
		if(!$this->selects){

			$this->selects[] = $this->_table_name.'.*';
		}

		$select = array_merge($this->selects, $this->join_selects);

		if($select){

			$this->db->select(implode(',',$select));
		}

		$result = $this->db->get($this->_table_name)->result();

		if($result){

			$return = [];
			$is_objectable = (count($this->selects) > 1) || (count($this->join_selects) > 0); // ## Experimental

			foreach($result as $r){

				if($is_objectable){

					$return[] = $r;
				}else{

					if ($force_raw) {

						$return[] = $r;
					} else {

						$return[] = new $this->_object_name($r);
					}
				}
			}

			if($this->is_pagination){

				$this->db->select($this->_table_name.'.'.$this->_primary_key);
				$this->pagination_data = [
					'total_record' => $this->db->count_all_results($this->_table_name)
				];
			}
			if($this->is_cache_enabled){

				$this->db->flush_cache();
				$this->is_cache_enabled = FALSE;
				$this->resetFilter();
			}

			return $return;
		}

		if($this->is_cache_enabled){

			$this->db->flush_cache();
			$this->is_cache_enabled = FALSE;
			$this->resetFilter();
		}

		return NULL;
	}

	public function findById($id){

		$this->db->db_select($this->db_name);

		if(isset($this->caching[$id])){

			return clone $this->caching[$id];
		}
		
		$data = $this->withId($id)->findOne();

		if($data){

			$this->caching[$id] = clone $data;
			return $data;
		}

		return NULL;
	}

	public function findOne($force_raw = FALSE){
		
		$this->db->db_select($this->db_name);

		if ($this->join_task) {

			foreach ($this->join_task as $join_task) {

				extract($join_task);

				$this->db->join($table, $condition, $type);
			}
		}
		if($this->is_cache_enabled){

			$this->db->stop_cache();
		}
		if(!$this->selects){

			$this->selects[] = $this->_table_name.'.*';
		}

		$select = array_merge($this->selects, $this->join_selects);

		if($select){

			$this->db->select(implode(',',$select));
		}

		$result = $this->db->get($this->_table_name)->row();

		if($result){

			$is_objectable = (count($this->selects) > 1) || (count($this->join_selects) > 0); // ## Experimental

			if($this->is_cache_enabled){

				$this->db->flush_cache();
				$this->is_cache_enabled = FALSE;
				$this->resetFilter();
			}

			if($is_objectable){

				return $result;
			}else{

				if($force_raw){

					return $result;
				}else{

					return new $this->_object_name($result);
				}
			}
		}

		if($this->is_cache_enabled){

			$this->db->flush_cache();
			$this->is_cache_enabled = FALSE;
			$this->resetFilter();
		}

		return NULL;
	}


	public function compile(){

		$this->db->db_select($this->db_name);

		if ($this->join_task) {

			foreach ($this->join_task as $join_task) {

				extract($join_task);

				$this->db->join($table, $condition, $type);
			}
		}
		if($this->is_cache_enabled){

			$this->db->stop_cache();
		}
		if(!$this->selects){

			$this->selects[] = $this->_table_name.'.*';
		}

		$select = array_merge($this->selects, $this->join_selects);

		if($select){

			$this->db->select(implode(',',$select));
		}

		$this->db->from($this->_table_name);

		$result = $this->db->get_compiled_select();

		if($this->is_cache_enabled){

			$this->db->flush_cache();
			$this->is_cache_enabled = FALSE;
			$this->resetFilter();
		}

		return $result;
	}

	public function update($update_data){

		$this->db->db_select($this->db_name);

		if($this->is_cache_enabled){

			$this->db->stop_cache();
		}

		$update = $this->db->update($this->_table_name, $update_data);

		if($this->is_cache_enabled){

			$this->db->flush_cache();
			$this->is_cache_enabled = FALSE;
			$this->resetFilter();
		}

		return $update;
	}

	public function delete(object $object){

		$this->db->db_select($this->db_name);

		$this->db->where($this->_table_name.'.'.$this->_primary_key, $object->{$this->_primary_key});

		return ($this->db->delete($this->_table_name));
	}

	public function save(object $object, bool $force_insert = FALSE){

		$this->db->db_select($this->db_name);

		if(empty($object->{$this->_primary_key}) || $force_insert){
			if ($this->position === FALSE && ($this->middleware_use === TRUE)){
				$anon = $this->anon;
				if ($this->mid_name){
				}else{
					$anon($this,NULL,$object);
				}
			}
			if($this->db->insert($this->_table_name, $object)){
				if ($this->position === TRUE && ($this->middleware_use === TRUE)){
					$anon = $this->anon;
					if ($this->mid_name){
					}else{
						$anon($this,$this->db->insert_id(),$object);
					}
				}
				return TRUE;
			}
		}else{
			if ($this->position === FALSE && ($this->middleware_use === TRUE)){
				$anon = $this->anon;
				if ($this->mid_name){
					Middleware::run($this->mid_name,$anon($this,NULL,$object));
				}else{
					$anon($this,NULL,$object);
				}
			}
			$this->db->where($this->_table_name.'.'.$this->_primary_key, $object->{$this->_primary_key});
			if($this->db->update($this->_table_name, $object)){
				if ($this->position === TRUE && ($this->middleware_use === TRUE)){
					$anon = $this->anon;
					if ($this->mid_name){
					}else{
						$anon($this,NULL,$object);
					}
				}
				return TRUE;
			}
		}

		return FALSE;
	}

	public function setLimit(int $limit, int $offset = 0){

		$this->is_pagination = TRUE;

		$this->limit = $limit;
		$this->offset = $offset;

		return $this;
	}

	public function getPaginationData(){

		$response = $this->pagination_data;

		$this->is_pagination = FALSE;
		$this->pagination_data = [];

		return $response;
	}

	public function resetFilter(){

		$this->is_pagination = FALSE;
		$this->selects = [];
		$this->join_selects = [];
		$this->joins = [];
		$this->join_task = [];
	}

	public function withSelectFields(Array $fields, bool $strict_mode = TRUE){

		$this->db->db_select($this->db_name);

		try{

			foreach($fields as $field){

				if($strict_mode){

					if(in_array($field, $this->fields)){

						$this->selects[] = $this->_table_name.'.'.$field;
					}else{

						throw new Exception('Field '.$field.' is not found');
					}
				}else{

					$this->selects[] = $field;
				}
			}
		}catch(Exception $e){

			show_error($e->getMessage());
		}

		return $this;
	}

	public function joinWith(String $table, String $reference_field, String $source_field, String $join_type = '', ?Array $fields = [], Array $opt_cond = [], bool $strict_mode = TRUE){

		$this->db->db_select($this->db_name);

		$alias_check = explode(' ', $table);
		$table_ori = NULL;

		if(count($alias_check) > 1){

			$table_ori = $table;
			$table = $alias_check[1];
		}

		if($fields){

			foreach($fields as $field){

				if($strict_mode){

					$this->join_selects[] = $table.'.'.$field;
				}else{

					$this->join_selects[] = $field;
				}
			}
		}else if($fields !== NULL){

			$this->join_selects[] = $table.'.*';
		}

		$foreign_check = explode('.', $source_field);
		$foreign_check2 = explode('=', $source_field);

		if(count($foreign_check) > 1) {

			$cond = $foreign_check[0] . '.' . $foreign_check[1] . '=' . $table . '.' . $reference_field;
		}else {

			if(count($foreign_check2) == 1) {

				$cond = $this->_table_name . '.' . $source_field . '=' . $table . '.' . $reference_field;
			}
		}

		if(count($foreign_check2) > 1) {

			$cond = $table . '.' . $reference_field . '=' . $foreign_check2[1];
		}else {

			if(count($foreign_check) == 1) {

				$cond = $this->_table_name . '.' . $source_field . '=' . $table . '.' . $reference_field;
			}
		}

		if($opt_cond){

			foreach($opt_cond as $o_cond){

				$cond .= ' AND '.$o_cond;
			}
		}

		if($table_ori){

			$this->_join($table_ori, $cond, $join_type);
		}else{

			$this->_join($table, $cond, $join_type);
		}

		return $this;
	}

	public function groupWith(Array $group_by){

		$this->_start_query_cache();

		$this->db->group_by($group_by);

		return $this;
	}

	public function orderBy(Array $order_by, bool $strict_mode = NULL){

		$this->_start_query_cache();

		foreach($order_by as $key => $sort){

			$this->db->order_by($key,$sort,$strict_mode);
		}

		return $this;
	}

	public function withId($id){

		$this->_start_query_cache();

		if (is_array($id)) {

			if ($id) {

				$this->db->where_in($this->_table_name.'.'.$this->_primary_key, $id);
			} else {

				$this->db->where($this->_table_name . '.' . $this->_primary_key, NULL);
			}
		} else {

			$this->db->where($this->_table_name.'.'.$this->_primary_key, $id);
		}

		return $this;
	}

	public function withMiddleware($func,$is_after = TRUE,$middleware = NULL){
		$this->middleware_use = TRUE;
		$this->anon = $func;
		$this->mid_name = $middleware;
		$this->position = $is_after;
		return $this;
	}
}
