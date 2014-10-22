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

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
		/* some private styles */
        @media (min-width: 992px){
            .modal-lg {width: 600px;}
        }
        #content, .md-preview{
            padding: 20px;
            border: 1px solid #eee;      
            border-radius: 3px;
        	/*border-left-width: 5px;
            border-left-color: #f0ad4e;*/
        }
        .md-editor{margin:20px 0;}
		.md-header{padding:10px;}
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
                <li><a href="javascript:;" id="save" data-loading-text="提交中..">保存</a></li>
                <li><a href="javascript:;" data-toggle="modal" data-target=".bs-example-modal-lg">修改链接</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">其他 <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="javascript:;" data-toggle="modal" data-target=".bs-example-modal-lg2">添加密码</a></li>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>

<!-- Begin page content -->
<div class="container">

    <form class="form">
        <input type="hidden" id="formhash" name="formhash" value="<?php echo $formhash;?>" />
        <textarea id="content" class="form-control" name="content" data-provide="markdown" rows="30"></textarea>
    </form> 

    <div class="form-group">
        <input id="filetoupload" type="file" name="filetoupload">
        <input type="hidden" value="" id="id_imgurl">
        <span id="upload-prompt" style="display:none;color:red">附件上传中，请稍候！</span>
        <p class="help-block">Upload pictures here.</p>
    </div>

</div>

<div class="footer">
    <div class="container">
        <p class="text-muted">© Copyright <a href="http://jingwentian.com" target="_blank">jingwentian.com</a></p>
    </div>
</div>


<!-- 修改链接 -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myLargeModalLabel">修改链接</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <div class="input-group">
                  <div class="input-group-addon">http://blank.jingwentian.com/share/</div>
                  <input class="form-control" type="text" id="sharelink" placeholder="xxxx">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Save</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- 添加密码 -->
<div class="modal fade bs-example-modal-lg2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myLargeModalLabel">添加密码</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <div class="input-group">
                  <div class="input-group-addon">password</div>
                  <input class="form-control" type="text" id="password" placeholder="xxxx">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Save</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/static/bootstrap/js/jquery.upload-1.0.2.min.js"></script>
<script type="text/javascript" src="/static/bootstrap-markdown/js/bootstrap-markdown.js"></script>
<script type="text/javascript" src="/static/bootstrap-markdown/locale/bootstrap-markdown.fr.js"></script>
<script type="text/javascript" src="/static/bootstrap-markdown/js/markdown.js"></script>
<!-- http://toopay.github.io/bootstrap-markdown/ -->
<script>

    $(function(){
        //save
        $('#save').click(function(){
            var content = $('#content').val();
            var sharelink = $('#sharelink').val();
            var password = $('#password').val();
            var formhash = $('#formhash').val();
            var btn = $(this)
            btn.button('loading')
            $.ajax({
                type: "post",
                url: "index.php",
                data:{ 'content': content, 'sharelink': sharelink, 'password':password,'formhash':formhash },
                dataType: "json",
                success: function (data) {
                    var msg=['提交成功','保存失败','内容不能为空'];
                    if (data.flag !=0) {
                        //alert(msg[data.flag]);
                        location.reload();
                    }else{
                        //alert(msg[data.flag]);
                        window.location.href='./share/'+data.sharelink;
                    }
                }
            });
        });

        //upload 
        $("#filetoupload").change(function() {
            $("#upload-prompt").text("附件上传中，请稍候！");
            $("#upload-prompt").show();
            if($(this).val()){
                $(this).upload("upload.php", function(res) {
                    if(res.status == 200){
                        $("#upload-prompt").text(res.msg);
                        var con = document.getElementById("content").value;
                        document.getElementsByTagName("textarea")[0].focus();
                        document.getElementById("content").value = con + "\n![]("+res.url+")\n";
                        document.getElementsByName("filetoupload")[0].value="";
                    }else{
                        alert(res.msg);
                    }
                }, "json");
            }
        });

    })
</script>

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
<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//piwik.jingwentian.com/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', 2]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="//piwik.jingwentian.com/piwik.php?idsite=2" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->
</body>
</html>

