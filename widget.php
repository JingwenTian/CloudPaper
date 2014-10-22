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

//挂件直接访问
if($_SERVER['REQUEST_METHOD'] == 'GET') {

	$id = trim($_GET['id'])?:''; //sharelink
	$content = $jing->DB->select("blank",'*', array(
	        "sharelink" => $id,
	        "LIMIT"=>1
	));

	//如果无需密码直接输出内容
	if($content[0]['password'] == '') {
		$html = Markdown::defaultTransform($content[0]['content']);
		$js_widget .= "document.writeln('<link href=\"http://jingplus.qiniudn.com/static/css/github-markdown-style.css?t=20141023\" media=\"all\" rel=\"stylesheet\" type=\"text/css\" />');"; //挂件携带样式
		$js_widget .= "document.writeln('<div class=\"markdown-body\">".DeleteHtml($html)."</div>');";
	//如需密码则输出加密提示
		$js_widget .= "document.writeln('<div class=\"gist-meta\"><a href=\"http://blank.jingwentian.com/share/{$id}\" target=\"_blank\" style=\"float:right\">view raw</a>hosted with ❤ by <a href=\"http://blank.jingwentian.com\" target=\"_blank\">CloudPaper</a></div>');";
	}else {
		$js_widget = "document.writeln('".DeleteHtml(file_get_contents('./template/widget_pass.php'))."')";
	}

	echo $js_widget;

//挂件加密访问
}elseif($_SERVER['REQUEST_METHOD'] == 'POST') {

}



/*
<style> .blank_content{margin:0 auto;padding: 20px;border: 1px solid #eee;border-left-width: 5px;border-radius: 3px;border-left-color: #f0ad4e;}code,pre{font-family: Menlo, Monaco, Consolas, Courier New, monospace;}code {padding: 2px 4px;font-size: 90%;color: #c7254e;background-color: #f9f2f4;border-radius: 4px;}pre {display: block;padding: 9.5px;margin: 0 0 10px;font-size: 13px;line-height: 1.42857143;color: #333;word-break: break-all;word-wrap: break-word;background-color: #f5f5f5;border: 1px solid #ccc;border-radius: 4px;}pre code {padding: 0;font-size: inherit;color: inherit;white-space: pre-wrap;background-color: transparent;border-radius: 0;}</style>
 */

?>

