
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

    <!-- Custom styles for this template -->
    <link href="http://blank.jingwentian.com/static/bootstrap/css/sticky-footer-navbar.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<style type="text/css">
		#form{
			max-width: 400px;
			padding: 15px;
			margin: 0 auto;
			padding: 20px;
			border: 1px solid #eee;
			border-left-width: 5px;
			border-radius: 3px;
		}
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
            <a class="navbar-brand" href="/">空白页</a>
        </div>
       
    </div>
</div>

<!-- Begin page content -->
<div class="container" style="padding:90px 20px;">

    
    <form id="form"> 
		  <div class="form-group">
		    <h4 style="color: #f0ad4e;">访问密码</h4>
		    <input type="hidden" name="sharelink" id="sharelink" value="<?php echo $content[0]['sharelink'];?>">  
		    <input type="password" class="form-control" id="password" name="pass" placeholder="Password" required autofocus>
		  </div>
		 
		  <a class="btn btn-default" id="submit">Submit</a>
	</form>


</div>

<div class="footer">
    <div class="container">
        <p class="text-muted">© Copyright <a href="http://jingwentian.com" target="_blank">jingwentian.com</a></p>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script>
    $(function(){

        //save
        $('#submit').click(function(){
        	
            var sharelink = $('#sharelink').val();
            var password = $('#password').val();

            $.ajax({
                type: "post",
                url: "index.php",
                data:{ 'sharelink': sharelink, 'pass':password },
                dataType: "json",
                success: function (data) {
                    if (data.flag !=0) {
                        alert('密码错误');
                    }else{
                        //alert(msg[data.flag]);
                        window.location.href='/share/'+data.sharelink;
                    }
                }
            });


        })
    })
</script>

</body>
</html>

