EasyCurl
========

Class for work with php Curl

Example:
```
  require_once('EasyCurl/EasyCurl.php');
  
  //Print response:
  $response =  EasyCurl::url('http://localhost/1.php')->exec();
  print($response);
  
  //set PHP Curl settings
  //full information here: http://php.net/manual/en/function.curl-setopt.php
  $settings = array(
  	CURLOPT_RETURNTRANSFER => 1,
  	CURLOPT_SSL_VERIFYPEER => FALSE,
  );
  
  $response = EasyCurl::url('http://localhost/1.php')->set($settings)->exec();
  print($response);
  
  
  //Set Header and Body
  $head = array(
  	"Content-Type: text/xml",
  );
  
  $body = 'param=1&param2=24';
  
  $response = EasyCurl::url('http://localhost/1.php')->set($settings)->head($head)->body($body)->exec();
  print($response);
```

it's work ;)
