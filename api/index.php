<?php

error_reporting(E_ALL & ~E_NOTICE);
//引入composer
require '../vendor/autoload.php';
define('LAZER_DATA_PATH', dirname(dirname(__FILE__)) . '/data/');

use Lazer\Classes\Database as Lazer;

//输入处理
function input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$string = input($_GET['string']); //请求字符串
$id = input($_GET['id']); //数据库名

if(!empty($string) && !empty($id)){

    //分隔字符串存入数组
    $array = explode('|',$string);
    $k = -1;
    $status = true;
    for($i=0;$i<count($array);$i+=2){
    	if($array[$i] !== '' && $array[$i + 1] !== ''){
        $k+=1;
        $key_array[$k]['key'] = $array[$i];
        $key_array[$k]['value'] = $array[$i + 1];
    	}else{
    		$status = false;
    		break;
    	}
    }
    
    if($status){

    //数据库比对
    $array = Lazer::table((string)$id)->where($key_array[0]['key'],'=',$key_array[0]['value'])->andWhere($key_array[1]['key'],'=',$key_array[1]['value'])->find()->asArray();
        if(!$array){
            $array = array(
                'status' => false,
                'code' => 103,
                'msg' =>'未找到匹配'   
            );
        }else{
            $array = array(
                'status' => true,
                //键名数组
                'key_array' => array_values(array_flip($array[0])),
                //数据数组
                'source_array' => array_values($array[0])
            );
        }
    }else{
    	$array = array(
        'status' => false,
        'code' => 102,
        'msg' =>'参数缺少'   
    );
    }
}else{
    $array = array(
        'status' => false,
        'code' => 101,
        'msg' =>'参数无效'   
    );
}
echo json_encode($array);
