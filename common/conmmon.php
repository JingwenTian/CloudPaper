<?php
/**
 * 公共方法
 * User: JING
 * Date: 14-8-2
 * Time: 22:23
 */

@spl_autoload_register(array("Common","__autoload"));//实现类的自动加载

require ROOT_PATH . '/config/config.php';

class Common {

    public function __construct(){

    }

    public function __set($name , $value){
        $this->$name = $value;
    }

    public function __get($name){

        if($name == 'DB'){
            return $this->getHost();
        }elseif($name == 'HOST'){
            return $this->HOST = WEB_SITE;
        }elseif($name == 'template'){
            return $this->template = ROOT_PATH . '/template/';
        }elseif($name == 'cache' ){
            return $this->cache();
        }elseif($name == 'curl'){
            return $this->curl();
        }else{
            return $this->$name;
        }

    }

    private function curl() {
        if(!isset($this->curl)){
            $curl = new curl();
            $this->curl = $curl;
        }
        return $this->curl;
    }

    private function cache() {
        if(!isset($this->cache)){
            $cache = new cache();
            $this->cache = $cache;
        }
        return $this->cache;
    }

    private function getHost(){
        if(!isset($this->DB)){
            $DB= new medoo(array(
                'database_type' => UC_CONNECT,
                'database_name' => UC_DBNAME,
                'server' => UC_DBHOST,
                'username' => UC_DBUSER,
                'password' => UC_DBPW,
                'charset'=>UC_DBCHARSET,
                'port'=>UC_DBTABLEPRE
            ));
            //$DB = new db();
            //$DB->connect(UC_DBHOST,UC_DBUSER,UC_DBPW,UC_DBNAME,UC_DBCHARSET);
            $this->DB = $DB;
        }
        return $this->DB;
    }

    public static function __autoload($classname){
        $classpath= ROOT_PATH.'/common/'.$classname.'.class.php';
        if(file_exists($classpath)){
            require $classpath;
        }else{
            //echo 'class file'.$classpath.'not found!';
        }
    }

    public function display($template) {
        require $this->template.'/'.$template.'.php';
    }



}

