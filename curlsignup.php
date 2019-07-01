
<?php
////
 // A very simple PHP example that sends a HTTP POST to a remote site// A ver 
//

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"localhost/login%20page/authenticate.php");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
            "request=signup&name=xyz&email=xyz@gmail.com&password=123&mobileno=777777777");

// in real life you should use something like:
// curl_setopt($ch, CURLOPT_POSTFIELDS, 
//          http_build_query(array('postvar1' => 'value1')));

// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec ($ch);

curl_close ($ch);

// further processing ....
//if ($server_output == "OK") { ... } else { ... }

?>