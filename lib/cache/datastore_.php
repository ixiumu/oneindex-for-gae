<?php
use Google\Cloud\Datastore\DatastoreClient;

class datastore_{
	private $db;
	
	function __construct($config = null){
		$datastore = new DatastoreClient();
		$this->db = $datastore;
	}

	function get($key){
		$data = $this->db->lookup($key);
		if( is_array($data) && $data['expire'] > time() && !is_null($data['data']) ){
			return $data['data'];
		}
		return null;
	}

	function set($key, $value=null, $expire=99999999){
		$data['expire'] = time() + $expire;
		$data['data'] = $value;
		$task = $this->db->entity($this->db->key($key), $data);
		return $this->db->insert($task);
	}

	function clear(){
		# $this->m->flush(10);
	}
}
