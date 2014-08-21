<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");

define('ROOT_PATH',pathinfo(__FILE__,PATHINFO_DIRNAME));

require ROOT_PATH . '/common/conmmon.php';
require ROOT_PATH . '/common/functions.php';

# Get Markdown class
spl_autoload_register(function($class){
    require preg_replace('{\\\\|_(?!.*\\\\)}', DIRECTORY_SEPARATOR, ltrim($class, '\\')).'.php';
});
use \Michelf\Markdown;

$jing = new Common();

$id = trim($_GET['id'])?:''; //sharelink
$content = $jing->DB->select("blank",'*', array(
        "sharelink" => $id,
        "LIMIT"=>1
));

$html = Markdown::defaultTransform($content[0]['content']);
$js_widget = "document.writeln('".DeleteHtml($html)."');";

echo $js_widget;


?>

