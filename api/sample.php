<?php

error_reporting(E_ALL & ~E_NOTICE);
//输入处理
function input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$name = input($_GET['name']);

if(!empty($name)){
    
    $file = json_decode(file_get_contents('../../ahpu/data/'.$name));
    $array = array(
        'status' => true,
        'raw' => $file->source[0],
        //第一个数据->json 解码为数组->汉字编码->数组键值翻转->重新排序
        'source' => array_values(array_flip(json_decode(json_encode($file->source[0]),TRUE)))
    );

}else{
    $array = array(
        'status' => false,
        'code' => 101,
        'msg' =>'参数无效'   
    );
}

echo json_encode($array);
?>