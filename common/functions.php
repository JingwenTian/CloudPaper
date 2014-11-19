<?php
session_start();

function set_magic_quotes_gpc($arr=NULL){
    
    static $isset = 1;
    if($isset==2) return ;
    if($isset==1){
        if (version_compare(PHP_VERSION, '5.3.0','<')) {
             if(get_magic_quotes_gpc()==1){
                $isset = 2;
                return ;
             }
        }
        $isset = 3;
    }
    $funcName = __FUNCTION__;
    if($arr!==NULL){
        foreach($arr as &$val){
            if(is_array($val)){
                $val=$funcName($val);    
            }else{
                $val = addslashes($val);
            }
            
        }
        return $arr;                
    }
    //GET 过滤
    foreach($_GET as &$val){
        if(is_array($val)){
            $val=$funcName($val);    
        }else{
            $val = addslashes($val);
        }
    }
    //POST 过滤
    foreach($_POST as &$val){
        if(is_array($val)){
            $val=$funcName($val);    
        }else{
            $val = addslashes($val);
        }
    }
    //COOKIE 过滤
    foreach($_COOKIE as &$val){
        if(is_array($val)){
            $val=$funcName($val);    
        }else{
            $val = addslashes($val);
        }
    }        
}
//set_magic_quotes_gpc();//调用自动过滤

/**
 * 输出各种类型的数据，调试程序时打印数据使用。
 * @param	mixed	参数：可以是一个或多个任意变量或值
 */
function p(){
	$args=func_get_args();  //获取多个参数
	if(count($args)<1){
		Debug::addmsg("<font color='red'>必须为p()函数提供参数!");
		return;
	}

	echo '<div style="width:100%;text-align:left; background-color: #fff;"><pre>';
	//多个参数循环输出
	foreach($args as $arg){
		if(is_array($arg)){
			print_r($arg);
			echo '<br>';
		}else if(is_string($arg)){
			echo $arg.'<br>';
		}else{
			var_dump($arg);
			echo '<br>';
		}
	}
	echo '</pre></div>';
}

//转换字符
function char_cv($string) {
    $string = htmlspecialchars(addslashes($string));
    return $string;
}

//清除HTML代码、空格、回车换行符
function DeleteHtml($str) { 
	$str = trim($str); 
	//$str = strip_tags($str,""); 
	$str = ereg_replace("\t","",$str); 
	$str = ereg_replace("\r\n","",$str); 
	$str = ereg_replace("\r","",$str); 
	$str = ereg_replace("\n","\\n",$str); 
	$str = ereg_replace(" "," ",$str); 

	return trim($str); 
}

/* 采集方法 */

function fetch_urlpage_contents($url){
	$c=file_get_contents($url);
	return $c;
}

//获取匹配内容
function fetch_match_contents($begin,$end,$c){
	$begin=change_match_string($begin);
	$end=change_match_string($end);
	$p = "{$begin}(.*){$end}";
	if(eregi($p,$c,$rs))
	{
	return $rs[1];}
	else { return "";}
}

//转义正则表达式字符串
function change_match_string($str){
	//注意，以下只是简单转义
	//$old=array("/","$");
	//$new=array("/","$");
	$str=str_replace($old,$new,$str);
	return $str;
}

//采集网页
function pick($url,$ft,$th){
	$c=fetch_urlpage_contents($url);
	foreach($ft as $key => $value){
		$rs[$key]=fetch_match_contents($value["begin"],$value["end"],$c);
		if(is_array($th[$key])){ 
			foreach($th[$key] as $old => $new){
				$rs[$key]=str_replace($old,$new,$rs[$key]);
			}
		}
	}
	return $rs;
}

?>
