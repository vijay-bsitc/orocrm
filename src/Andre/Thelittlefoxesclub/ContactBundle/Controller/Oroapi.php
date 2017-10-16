<?php 
namespace Andre\Thelittlefoxesclub\ContactBundle\Controller;

ini_set('max_execution_time', 0);			
ini_set('memory_limit',-1);

class Oroapi   
{
    public $_username;
    public $_apiUrl; 
    public $_apiKey;
    public $_password;
    public $_userSalt;
	public $ch;
	public $auth;	
	public $headerArray;
	public $response;
	public $cInfo;

 	
    public function __construct ($username, $password, $apiUserKey, $apiUrl, $userSalt = '') {
    	
        $this->_username = $username;
        $this->_password = $password;
        $this->_apiKey = $apiUserKey;
        $this->_userSalt = $userSalt; // deprecated in OroCRM v1.0
		$this->_apiUrl 	= $apiUrl;
 		$this->auth 		= '1';	
		$this->ch = curl_init();
		$this->headerArray 	= $this->getHeaders();
    }
 
    private function _encodePassword($raw, $salt)  {
        $salted = $this->_mergePasswordAndSalt($raw, $salt);
        $digest = hash('sha1', $salted, true);
        return base64_encode($digest);
    }
 
    private function _mergePasswordAndSalt($password, $salt) {
        if (empty($salt)) {
            return $password;
        }
        if (false !== strrpos($salt, '{') || false !== strrpos($salt, '}')) {
            throw new \InvalidArgumentException('Cannot use { or } in salt.');
        }
        return $password.'{'.$salt.'}';
    }
 
    public function getHeaders () {
		$prefix = gethostname();
        $created = date('c');
        $nonce  = base64_encode(substr(md5(uniqid($prefix . '_', true)), 0, 16));
        $passwordDigest = $this->_encodePassword(base64_decode($nonce) . $created . $this->_apiKey, $this->_userSalt);
        $wsseProfile = sprintf(
            'X-WSSE: UsernameToken Username="%s", PasswordDigest="%s", Nonce="%s", Created="%s"',
            $this->_username,
            $passwordDigest,
            $nonce,
            $created
        );
        return array('Authorization: WSSE profile=\"UsernameToken\"\n',$wsseProfile,'Content-Type: application/vnd.api+json');
    }
 	
	public function logMessage($msg){
		$logFileName = 'orocrm_api.log';
		//Mage::log( $msg, null, $logFileName, true);
	}
	
	public function getCommonResponse($url, $method='POST', $param='',  $encodeJson='yes', $callingFunction=""){
 		// echo 'Hello<pre>'; print_r($url); echo '</pre>'; die;
   		if( $encodeJson=="yes")	{
 			$param = json_encode($param);
		}else{
			if($param && $param!=""){
				$param = http_build_query($param); 
			}
		}
  		curl_setopt($this->ch, CURLOPT_URL, $url);
		curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headerArray);
		if($param && $param!=""){	

			curl_setopt($this->ch,CURLOPT_POST, 1);  		
			curl_setopt($this->ch, CURLOPT_POSTFIELDS, $param);
		}
 		curl_setopt ($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
  		curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 30 );
		curl_setopt($this->ch, CURLOPT_TIMEOUT, 30 );
		$response = curl_exec($this->ch);
		$errmsg = curl_error($this->ch); 
		$cInfo = curl_getinfo($this->ch);
		$this->response = $response;
		$this->cInfo = $cInfo;		
		return json_decode($response, true);	 
 	}	
	
	/*----------------------- start customer  -------------------- */
	
	
	/**********************************************************/
	public function get_api_accounts(){
		echo $url = $this->_apiUrl.'/api/accounts';
		$response = $this->getCommonResponse($url, 'GET');	 
		return $response;
	}
	public function get_api_accounts_id($id){
		echo $url = $this->_apiUrl.'/api/accounts/'.trim($id);
		$response = $this->getCommonResponse($url, 'GET');	 
		return $response;
	}

	public function post_api_account($data){
		echo $url = $this->_apiUrl.'/api/accounts';
		$response = $this->getCommonResponse($url, 'POST',$data);	 
		return $response;
	}
	public function patch_api_account($data,$id){
		echo $url = $this->_apiUrl.'/api/accounts/'.trim($id);
		$response = $this->getCommonResponse($url, 'PATCH',$data);	 
		return $response;
	}
	/**********************************************************/


	public function getCustomerById($id){
		$url = $this->_apiUrl.'/contacts/'.trim($id);
		//$url = $this->_apiUrl.'/contacts/'.$id.'/addresses';
		//$url = $this->_apiUrl.'/contacts';
		$response = $this->getCommonResponse($url, 'GET');	 
		return $response;
	}
	
	public function getAllCustomers($limit='1000',$page='1'){
 		$url = $this->_apiUrl.'/contacts?limit='.$limit.'&page='.$page;
		$response = $this->getCommonResponse($url, 'GET');	 
		return $response;
	}	
	
	
	public function getAllMagentoCustomers(){
 		$url = $this->_apiUrl.'/contacts/magento'; 
		$response = $this->getCommonResponse($url, 'GET');	 
		return $response;
	}
	
	
	
	public function searchCustomerByEmail($email=''){
		$param=''; $encodeJson='no';
		$url = $this->_apiUrl.'/search/advanced?query=from orocrm_contact where email ~ '.$email.'';
 		$response = $this->getCommonResponse($url, 'GET' ,$param ,  $encodeJson ,'searchCustomerByEmail');	
		return $response;		
	}	

	public function createCustomer($customer){
		$url = $this->_apiUrl.'/contact';			
		$response = $this->getCommonResponse($url, 'POST', $customer, 'no','createCustomer');
		return $response;
	}
	
	public function updateCustomer($customerid,$customer){
		$url = $this->_apiUrl.'/contact/'.$customerid.'/';			
		$response = $this->getCommonResponse($url, $method='PUT', $customer,  'yes' ,'updateCustomer');		
		return $response;
	}
	
	/*----------------------- start tags  -------------------- */
	public function createTags($tags, $cid){
 		$url = $this->_apiUrl.'/tags/OroCRM_Bundle_ContactBundle_Entity_Contact/'.$cid;			
		$response = $this->getCommonResponse($url, 'POST', $tags, 'no','createTags');
  		return $response;
	}
		
	
	public function getAllTags(){
 		$url = $this->_apiUrl.'/tags';
		$response = $this->getCommonResponse($url, 'GET');	 
		return $response;
	}
	
	
	/*----------------------- start tags  -------------------- */
	
	public function __destruct(){
 		curl_close($this->ch);
 	}

}
