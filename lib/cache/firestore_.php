<?php
use Google\Cloud\Firestore\FirestoreClient;

class firestore_{
	private $m;
	
	function __construct($config = null){
		$db = new FirestoreClient();
		$this->m = $db->collection('oneindex');
	}

	function get($key){
		$key = urlencode($key);

		$docRef = $this->m->document($key);
		$snapshot = $docRef->snapshot();
		if ($snapshot->exists()) {
			$data = $snapshot->data();
			if( is_array($data) && $data['expire'] > time() && !is_null($data['data']) ){
				return $data['data'];
			}
		}
		return null;
	}

	function set($key, $value=null, $expire=99999999){
		$key = urlencode($key);

		$data['expire'] = time() + $expire;
		$data['data'] = $value;
		return $this->m->document($key)->set($data);
	}

	function clear(){
		$this->m->flush(10);
	}
}
