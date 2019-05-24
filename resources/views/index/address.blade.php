<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>收货地址</title>
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
    <div class="maincont">
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>收货地址</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="/index/images/head.jpg" />
     </div><!--head-top/-->
     <form action="login.html" method="get" class="reg-login">
      <div class="lrBox">
       <div class="lrList"><input type="text" placeholder="收货人" name="address_name" id="address_name" /></div>
       <div class="lrList"><input type="text" placeholder="详细地址" name="address_detail" id="address_detail" /></div>
       <div class="lrList">
        <select class="area" id="province">
        <option value="0" selected="selected">省份/直辖市</option>
        @foreach($provinceInfo as $v)
         <option value="{{$v->id}}">{{$v->name}}</option>
          @endforeach
        </select>

        <select class="area" id="city">
        <option value="0" selected="selected">市/区</option>
        </select>

        <select  class="area" id="area">
        <option value="0" selected="selected">县</option>
        </select>
       </div>

       <div class="lrList"><input type="text" placeholder="手机" name="address_tel" id="address_tel" /></div>
       <div> <td><input type="checkbox" id="is_defaut">是否为默认收货地址</td></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="button" value="保存" class="add" />
      </div>
     </form><!--reg-login/-->
<script src="/js/jquery-3.2.1.min.js"></script>

     <script>
    $(function(){
     
        //省份
        $('.area').change(function(){
          var _this = $(this);
          var pid = _this.val();
          // console.log(pid);
          var _option = "<option value='0' selected='selected'>请选择...</option>";
          _this.nextAll('select').html(_option);

          $.get(
            "/getArea",
            {pid:pid},
            function(res)
            {
                // console.log(res);
                for (var i=0;i<res.length;i++) {
                  _option +="<option value='"+res[i]['id']+"'>"+res[i]['name']+"</option>";

                };
                // console.log(_option);
                _this.next('select').html(_option);
                },'json'
              );
        })
        //保存 
        $('.add').click(function(){
           var data ={};
            data.province = $('#province').val();
            data.city = $('#city').val();
            data.area = $('#area').val();
            data.address_name = $('#address_name').val();
            data.address_tel = $('#address_tel').val();
            data.address_detail = $('#address_detail').val();
            var is_defaut = $('#is_defaut').prop('checked')
            if (is_defaut == true) {
              data.is_defaut =1;
            }else{
              data.is_defaut =2;
            }
            // console.log(is_defaut);
            console.log(data);
            $.get(
              "/addressdo",
              data,
              function(res)
              {
                // console.log(res);
                if (res.code==1) {
                  alert(res.msg);
                  location.href="/addresslist";
                };
              },'json'
              );

          })
})
</script>
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
      <dl class="ftnavCur">
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
    <!--jq加减-->
    <script src="/index/js/jquery.spinner.js"></script>
   <script>
	$('.spinnerExample').spinner({});
   </script>
  </body>
</html>