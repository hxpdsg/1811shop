<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>会员注册</title>
    <link rel="shortcut icon" href="/index/images/favicon.ico" />
    
    <!-- Bootstrap -->
    <link href="/index/css/bootstrap.min.css" rel="stylesheet">
    <link href="/index/css/style.css" rel="stylesheet">
    <link href="/index/css/response.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond./index/js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    @if (session('status'))
   <div class="alert alert-success">
      <script>alert("{{ session('status') }}")</script>
   </div>
    @endif
    <div class="maincont">
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>会员注册</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="/index/images/head.jpg" />
     </div><!--head-top/-->
     <form action="/login/registerhandle" method="get" id="a" class="reg-login">
      <h3>已经有账号了？点此<a class="orange" href="login.html">登陆</a></h3>
      <div class="lrBox">
       <div class="lrList"><input type="text" placeholder="输入手机号码或者邮箱号" name="email" class="email" /></div>
       <div class="lrList2"><input type="text" placeholder="输入短信验证码" name="code" class="code"/> 
       <button class="code2">获取验证码</button>
       </div>
       <div class="lrList"><input type="password" placeholder="设置新密码（6-18位数字或字母）" name="pwd" class="pwd"/></div>
       <div class="lrList"><input type="password" placeholder="再次输入密码" name="pwd1" class="pwd1"/></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="button" value="立即注册"  class="btn" />
      </div>
      <script src="/js/jquery-3.2.1.min.js"></script>

      <script>
      var flag=false;
      $('.code2').click(function(){
        // alert(11);
        var email = $('.email').val();
        // console.log(email);
        $.get(
            "/login/doreg",
            {email:email},
            function(res)
            {
              // console.log(res);
              if (res.code==1) {
                alert('发送成功');
              };
            }
          );
        return false;
      })
      $('.btn').click(function(){
        var email = $('.email').val();
        var code = $('.code').val();
        var pwd = $('.pwd').val();
        var pwd1 = $('.pwd1').val();
        if (pwd != pwd1) {
          alert('两次密码不一致');
          return flag;
        };
          if (email=='') {
          alert('邮箱不能为空');
        }else{
          $.get(
            "/login/email",
            {email:email},
            function(res)
            {
              console.log(res);
              if (res.code==1) {
                alert(res.msg);
              };
            },'json'
          );
        }
          $('#a').submit();
           return false;

      })
      $('.email').blur(function(){
        // alert(11);
        var email = $('.email').val();
        // console.log(email);
        if (email=='') {
          alert('邮箱不能为空');
        }else{
          $.get(
            "/login/email",
            {email:email},
            function(res)
            {
              console.log(res);
              if (res.code==1) {
                alert(res.msg);
              };
            },'json'
          );
        }
        
        return false;
      })
      </script>
     </form><!--reg-login/-->
     <div class="height1"></div>
     <div class="footNav">
      <dl>
       <a href="index.html">
        <dt><span class="glyphicon glyphicon-home"></span></dt>
        <dd>微店</dd>
       </a>
      </dl>
      <dl>
       <a href="prolist.html">
        <dt><span class="glyphicon glyphicon-th"></span></dt>
        <dd>所有商品</dd>
       </a>
      </dl>
      <dl>
       <a href="car.html">
        <dt><span class="glyphicon glyphicon-shopping-cart"></span></dt>
        <dd>购物车 </dd>
       </a>
      </dl>
      <dl>
       <a href="user.html">
        <dt><span class="glyphicon glyphicon-user"></span></dt>
        <dd>我的</dd>
       </a>
      </dl>
      <div class="clearfix"></div>
     </div><!--footNav/-->
    </div><!--maincont-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/index/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/index/js/bootstrap.min.js"></script>
    <script src="/index/js/style.js"></script>
  </body>
</html>
