<?php
	//echo json_encode($_POST);

	$mobileno = $_POST["mobileno"];
	//echo $mobileno;
	if($_POST["verification_code"]=="")
	{
		//echo 'code empty';
		$startdata = array(
			'api_key'=>'gZr8Q6RQzaRQ5nEx3PPS44bt0uRmUovR',
			'via'=>'sms',
			'phone_number'=>$mobileno,
			'country_code'=>91
		);
		$sms_response = curl_request("https://api.authy.com/protected/json/phones/verification/start","POST",$startdata);

		echo json_encode($sms_response);
	}else{
		
		$verification_code = $_POST["verification_code"];
		$checkdata = array(
			'api_key'=>'gZr8Q6RQzaRQ5nEx3PPS44bt0uRmUovR',
			'verification_code'=>$verification_code,
			'phone_number'=>$mobileno,
			'country_code'=>91
		);
		$sms_check = curl_request("https://api.authy.com/protected/json/phones/verification/check","GET",$checkdata);

		echo json_encode($sms_check);
	}



	function curl_request($url,$method,$data,$header_data=0)
	{
		
		$curl = curl_init();
		curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
		curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
		$curl_options = array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
  			CURLOPT_MAXREDIRS => 10,
 			CURLOPT_TIMEOUT => 30,
  			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  			CURLOPT_CUSTOMREQUEST => $method,
  			CURLOPT_POSTFIELDS => http_build_query($data),
  			CURLOPT_HTTPHEADER => array(
    			"cache-control: no-cache",
    			"content-type: multipart/form-data"
    		),
		);
		if($header_data!=""){
			$curl_options[CURLOPT_HTTPHEADER] = $header_data;
		}

		curl_setopt_array($curl,$curl_options);


		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
		
		if($err){	
			return false;
		} else {
			return $response;
		}
	}

?>