<?php
use Google\Cloud\Firestore\FirestoreClient;

class firestore_{
	private $db;
	
	function __construct($config = null){
		$db = new FirestoreClient();
		$this->db = $db->collection('oneindex');
	}

	function get($key){
		$key = urlencode($key);

		$docRef = $this->db->document($key);
		$snapshot = $docRef->snapshot();
		if ($snapshot->exists()) {
			$data = $snapshot->data();
			if( is_array($data) && $data['expire'] > time() && !is_null($data['data']) ){
				return unserialize($data['data']);
			}
		}
		return null;
	}

	function set($key, $value=null, $expire=99999999){
		$key = urlencode($key);

		$data['expire'] = time() + $expire;
		$data['data'] = serialize($value);
		return $this->db->document($key)->set($data);
	}

	function clear(){
		$docs = $this->db->limit(10)->documents();
		while (!$docs->isEmpty()) {
			foreach ($docs as $doc) {
				$doc->reference()->delete();
			}
			$docs = $this->db->limit(10)->documents();
		}
	}
}
