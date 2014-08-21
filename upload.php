<?php

define('ROOT_PATH',pathinfo(__FILE__,PATHINFO_DIRNAME));

require ROOT_PATH . '/config/config.php';
require_once(ROOT_PATH.'/common/upyun.class.php');

if(CLOSE_UPLOAD) exit('error: 403 附件上传已禁用');

$rsp = array('status'=>201, 'msg'=>'ok');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if($_FILES['filetoupload']['size']){
        
        $up_name = strtolower($_FILES['filetoupload']['name']);// 上传的文件名      
        $ext_name = pathinfo($up_name, PATHINFO_EXTENSION);// 上传文件扩展名
        //判断是否是允许上传的文件
        if(EXT_LIST){
            if(in_array($ext_name, explode(',', EXT_LIST))){
                $pass = '1';
            }else{
                $pass = null;
                $rsp['msg'] = '该文件格式不允许上传，只支持'.EXT_LIST;
            }
        }else{
            $pass = '1';
        }

        //如果是允许上传的文件，过滤后拼装图片名称
        if($pass){
            $is_img = null;
            $timestamp = time();
            // 尝试以图片方式处理
            $img_info = getimagesize($_FILES['filetoupload']['tmp_name']);
            if($img_info){
                //创建源图片
                if($img_info[2]==1){
                    $img_obj = imagecreatefromgif($_FILES['filetoupload']['tmp_name']);
                    $t_ext = 'gif';
                }else if($img_info[2]==2){
                    $img_obj = imagecreatefromjpeg($_FILES['filetoupload']['tmp_name']);
                    $t_ext = 'jpg';
                }else if($img_info[2]==3){
                    $img_obj = imagecreatefrompng($_FILES['filetoupload']['tmp_name']);
                    $t_ext = 'png';
                }
                //如果上传的文件是jpg/gif/png则处理
                if(isset($img_obj)){
                    // 是正确的图片格式
                    $is_img = '1';
                    $new_name = $timestamp.'.'.$t_ext;
                }else{
                    // 其它格式的图片
                    $rsp['msg'] = '该图片格式不支持，只支持jpg/gif/png';
                    // 直接取同扩展名
                    $new_name = $timestamp.'.'.$ext_name;
                }
            }else{
                // 非图片
                $rsp['msg'] = '上传的不是图片，只支持jpg/gif/png格式的图片';
                if(in_array($ext_name, array('jpg','jpeg','gif','png'))){
                    // 扩展名是图片，但不能用getimagesize识别，可能是改扩展名伪装
                    $new_name = $timestamp.'.bad-'.$ext_name;
                }else{
                    if(in_array($ext_name, array('php','htm','html'))){
                        $new_name = $timestamp.'.rename-'.$ext_name;
                    }else{
                        $new_name = $timestamp.'.'.$ext_name;
                    }
                }
            }
        }

        //$new_name = time().'.jpg'; //测试文件名
        $upload_dir = 'blank/'.date('Ymd');//路径
        $upload_filename = '/'.$upload_dir.'/'.$new_name;

        $out_img = file_get_contents($_FILES['filetoupload']['tmp_name']);//文件流

        $upyun = new UpYun(UPYUN_DOMAIN, UPYUN_USER, UPYUN_PW);//实例化上传类
        // 执行上传
        if($upyun->writeFile($upload_filename, $out_img, true)){
            $rsp['status'] = 200;
            $rsp['url'] = 'http://'.UPYUN_DOMAIN.'.b0.upaiyun.com/'.$upload_filename;
            $rsp['msg'] = '图片已成功上传';
        }else{
            $rsp['msg'] = '图片保存失败，请稍后再试';
        }

	}else{
		$rsp['msg'] = '附件数据没有正确上传';
	}

    header("Content-Type: text/html");
    echo json_encode($rsp);

}

