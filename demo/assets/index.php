<?php

 header('Content-Type:application/json; charset=utf-8');
    // 从文件中读取数据到PHP变量  
    $json_string = file_get_contents('./data.json');  
      
    // 用参数true把JSON字符串强制转成PHP数组  
    $data = json_decode($json_string, true);  
      
    // 显示出来看看  
    // var_dump($json_string); 
    // var_dump ($data); 
    // print_r($data); 
 		exit(json_encode($data));
 
  ?>