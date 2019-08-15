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

$string = input($_POST['string']);
$name = input($_POST['file']);

if(!empty($string) && !empty($name)){

    //分隔key 名/类型字符串，保存数组
    $array = explode('|',$string);
    $key_array = array();
    for($k=0;$k<count($array);$k+=2){
        $key_array[$array[$k]] = $array[$k + 1];
    }
    $key_array['id'] = 'integer';

    //获取 source 内容并增加 id 字段
    $file = json_decode(file_get_contents('../../ahpu/data/'.$name));
    for($i=0;$i<count($file->source);$i++){
        $file->source[$i]->id = $i;
    }
    $string = json_encode($file->source, JSON_UNESCAPED_UNICODE);
    file_put_contents("../data/".explode('.',$name)[0].".data.json",$string);

    //创建数据库 config 文件
    $file = array(
        'last_id' => count($file->source) - 1,
        'schema' => $key_array,
        'relations' => array()
    );
    $string1 = json_encode($file, JSON_UNESCAPED_UNICODE);
    file_put_contents("../data/".explode('.',$name)[0].".config.json",$string1);

    $array = array(
        'status' => true,
        'code' => 102,
        'msg' =>'录入成功'   
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