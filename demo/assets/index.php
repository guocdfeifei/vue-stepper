<?php

 header('Content-Type:application/json; charset=utf-8');
    // ���ļ��ж�ȡ���ݵ�PHP����  
    $json_string = file_get_contents('./data.json');  
      
    // �ò���true��JSON�ַ���ǿ��ת��PHP����  
    $data = json_decode($json_string, true);  
      
    // ��ʾ��������  
    // var_dump($json_string); 
    // var_dump ($data); 
    // print_r($data); 
 		exit(json_encode($data));
 
  ?>