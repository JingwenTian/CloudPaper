<?php
error_reporting(0);
spl_autoload_register(function($class){
    require preg_replace('{\\\\|_(?!.*\\\\)}', DIRECTORY_SEPARATOR, ltrim($class, '\\')).'.php';
});
# Get Markdown class
use \Michelf\Markdown;

$html = Markdown::defaultTransform($content[0]['content']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CloudPaper - 云纸片</title>

    <!-- Bootstrap core CSS -->
    <link href="http://cdn.bootcss.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="/static/bootstrap-markdown/css/bootstrap-markdown.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://blank.jingwentian.com/static/bootstrap/css/sticky-footer-navbar.css" rel="stylesheet">
    <link href="http://blank.jingwentian.com/static/bootstrap/css/prettify.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
        #blank_display_none{display: none;}
        #blank_content * {width: 100%;}
    </style>

</head>

<body>

<!-- Fixed navbar -->
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">云纸片</a>
        </div>

        <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="javascript:;" id="widget" data-toggle="modal" data-target=".bs-example-modal-lg">挂件</a></li>
                </ul>
        </div><!--/.nav-collapse -->
        
    </div>
</div>

<!-- Begin page content -->
<div class="container">

    <div id="blank_content">
    <?php 
        echo $html;
    ?>
    </div><div id="blank_display_none"></div>

</div>

<div class="footer">
    <div class="container">
        <p class="text-muted">© Copyright <a href="http://jingwentian.com" target="_blank">jingwentian.com</a></p>
    </div>
</div>

<!-- 挂件 -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myLargeModalLabel">分享挂件</h4>
        </div>
        <div class="modal-body">
            <pre class="prettyprint linenums>          
            	<ol class="linenums>
            		<li class="L0" style="list-style: none;"><span class="tag">&lt;script</span><span class="pln"> </span><span class="atn">type</span><span class="pun">=</span><span class="atv">"text/javascript"</span> <span class="atn">src</span><span class="pun">=</span><span class="atv">"http://blank.jingwentian.com/widget/<?php echo $content[0]['sharelink']?>"</span><span class="tag">&gt;&lt;/script&gt;</span></li>
            		<li class="L1" style="list-style: none;"><span class="tag">&lt;style</span><span class="tag">&gt;</span><span class="pln"> .blank_content{margin:0 auto;padding: 20px;border: 1px solid #eee;border-left-width: 5px;border-radius: 3px;border-left-color: #f0ad4e;}code,pre{font-family: Menlo, Monaco, Consolas, Courier New, monospace;}code {padding: 2px 4px;font-size: 90%;color: #c7254e;background-color: #f9f2f4;border-radius: 4px;}pre {display: block;padding: 9.5px;margin: 0 0 10px;font-size: 13px;line-height: 1.42857143;color: #333;word-break: break-all;word-wrap: break-word;background-color: #f5f5f5;border: 1px solid #ccc;border-radius: 4px;}pre code {padding: 0;font-size: inherit;color: inherit;white-space: pre-wrap;background-color: transparent;border-radius: 0;}</span><span class="tag">&lt;/style&gt;</span></li>
            	</ol>
            </pre>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script type="text/javascript">
var dataForWeixin={
        appId:  "",
        img:    "http://blank.jingwentian.com/static/images/share.jpg",
        url:    window.location.href,
        title:  "CloudPaper 云纸片 - 记录并分享文字",
        desc:   "用于临时记录文字的云端空白纸片",
        fakeid: "",
    };
(function(){
    var onBridgeReady=function(){
        //显示底栏导航
        WeixinJSBridge.call('hideToolbar');
        //WeixinJSBridge.call('hideOptionMenu');
        
        // 发送给好友; 
        WeixinJSBridge.on('menu:share:appmessage', function(argv){
            WeixinJSBridge.invoke('sendAppMessage',{
                "appid":        dataForWeixin.appId,
                "img_url":      dataForWeixin.img,
                "img_width":    "120",
                "img_height":   "120",
                "link":             dataForWeixin.url,
                "desc":             dataForWeixin.desc,
                "title":            dataForWeixin.title
            }, function(res){});
        });
        // 分享到朋友圈;
        WeixinJSBridge.on('menu:share:timeline', function(argv){
            WeixinJSBridge.invoke('shareTimeline',{
            "img_url":dataForWeixin.img,
            "img_width":"120",
            "img_height":"120",
            "link":dataForWeixin.url,
            "desc":dataForWeixin.desc,
            "title":dataForWeixin.title
            }, function(res){});
        });
        
    };
    if (typeof WeixinJSBridge == "undefined"){
        if(document.addEventListener){
            document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
        }else if(document.attachEvent){
            document.attachEvent('WeixinJSBridgeReady'   , onBridgeReady);
            document.attachEvent('onWeixinJSBridgeReady' , onBridgeReady);
        }
    }else{
        onBridgeReady();
    }
    
})();   
    
</script>

</body>
</html>

