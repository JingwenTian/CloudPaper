<?php
/**
 * _blank 空白页, 用于记录文字的页面
 * User: JING
 * Date: 14-8-2
 * Time: 22:23
 */
error_reporting(0);
session_start();
define('ROOT_PATH',pathinfo(__FILE__,PATHINFO_DIRNAME));

require ROOT_PATH . '/common/conmmon.php';
require ROOT_PATH . '/common/functions.php';

$jing = new Common();

//提交内容
if($_SERVER['REQUEST_METHOD'] == 'POST' && !$_POST['pass']){

	if(empty($_SERVER['HTTP_REFERER']) || $_POST['formhash'] != $_SESSION['__open_auth'] || preg_replace("/https?:\/\/([^\:\/]+).*/i", "\\1", $_SERVER['HTTP_REFERER']) !== preg_replace("/([^\:]+).*/", "\\1", $_SERVER['HTTP_HOST'])) {
    	exit('403: unknown referer.');
    }

    $content = addslashes(trim($_POST['content']));
    $sharelink = addslashes(trim($_POST['sharelink']))?:md5(mt_rand(1,999).time());
    $password = $_POST['password']?md5(addslashes(trim($_POST['password']))):'';

    if($content != ''){
        $last_user_id = $jing->DB->insert("blank", array(
            "content" => $content,
            "sharelink" => $sharelink,
            "password"=>$password,
            "time"=>date('Y-m-d H:i:s',time())
        ));
        $_SESSION['__open_auth'] = null;//清空formhash
        if($last_user_id > 0){
            echo json_encode(array(
                'flag'=>0,
                'msg'=>'提交成功',
                'sharelink'=>$sharelink
            ));
        }else{
            echo json_encode(array(
                'flag'=>1,
                'msg'=>'提交失败'
            ));
        }
    }else{
        echo json_encode(array(
            'flag'=>2,
            'msg'=>'内容不能为空'
        ));
    }

//提交密码
}elseif($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['pass']){

    $password = md5(addslashes(trim($_POST['pass'])));
    $sharelink = addslashes(trim($_POST['sharelink']));
    $is_pass = $jing->DB->query("SELECT id FROM blank WHERE password='{$password}' AND sharelink='{$sharelink}'")->fetchAll();
    //echo $jing->DB->last_query();exit;
    if($is_pass){
        //header('Location:/share/'.$sharelink);
        setcookie($sharelink,$sharelink,time()+24*3600); 
        echo json_encode(array(
            'flag'=>0,
            'sharelink'=>$sharelink
        ));
    }else{
        //密码错误时的
        echo json_encode(array(
            'flag'=>1
        ));
    }

}elseif($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['id']){

    $id = trim($_GET['id'])?:''; //sharelink
    $content = $jing->DB->select("blank",'*', array(
        "sharelink" => $id,
        "LIMIT"=>1
    ));
    //echo $jing->DB->last_query();

    if($content && $id){
        if($content[0]['password'] != '' && !isset($_COOKIE[$content[0]['sharelink']])){
            require($jing->template.'password.php');
        }else{
            require($jing->template.'share.php');
        } 
    }else{
       header('Location:/');
    }

}else{
	//formhash
	$formhash = $_SESSION['__open_auth'] = time();
    require($jing->template.'index.php');
}
