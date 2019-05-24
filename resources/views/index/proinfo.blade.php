<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>商品详情</title>
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
       <h1>产品详情</h1>
      </div>
     </header>
     <div id="sliderA" class="slider">
      <img src="{{config('app.img_url')}}{{$res->goods_img}}" />
      
     </div><!--sliderA/-->
     <table class="jia-len">
     <form action="#" method="post">
           {{csrf_field()}}
       
      <tr>
       <th><strong class="orange">{{$res->goods_price}}</strong></th>
       <td>
        <!-- <input type="text" class="spinnerExample"   -->
                
                <div >
                    <input type="button" id="jia" class="n_btn_1" value="+" />     <!-- 加号-->
                    <input type="text" value="1" id="kuang" class="n_ipt" style="width:20%"/>
                    <input type="button"  id="jian" class="n_btn_2" value="-" />   <!-- 减号 -->
                </div>
                <input type="hidden" name="goods_id" id="goods_id" value="{{$res->goods_id}}">
                     
       </td>
      </tr>
<script src="/js/jquery-3.2.1.min.js"></script>

      <script>
          $(function(){
           

                //加号
                $('#jia').click(function(){
                    //获取+号给他加一操作然后在 在框中赋+1的值 相当于循环一下  然后获取库存在框中值如果大于库存就等于库存
                    var goods_num = parseInt($('#kuang').val());
                    var num = goods_num+1;
                    var kucun = $('#kucun').html();
                    // console.log(goods_num);
                    $('#kuang').val(num);
                    if (goods_num>=kucun) {
                        $('#kuang').val(kucun);
                    };
                })
                // 减号
                $('#jian').click(function(){
                    //获取-号 给他减一操作然后在 在框中赋-1的值 如果减一操作的时候值小于等于1的时候让他等于1 停止
                    var goods_num = parseInt($('#kuang').val());
                    var num = goods_num-1;
                    $('#kuang').val(num);

                    if (goods_num<=1) {
                        $('#kuang').val(1);

                    };
                })
                // input框
                $('#kuang').blur(function(){
                    var kuang = $('#kuang').val();
                    var res = /^\d{1,}$/;
                    var kucun = $('#kucun').html();
                    // console.log(kuang);

                    if (!res.test(kuang)||kuang==''||parseInt(kuang)<1) {
                        var kuang = $('#kuang').val(1);
                        }else if(parseInt(kuang) >kucun){
                        $('#kuang').val(kucun);
                        }else{
                        $('#kuang').val(parseInt(kuang));
                    }
                })
                $('#gwc').click(function(){
                    var buy_number = $('#kuang').val();
                    var goods_id = $('#goods_id').val();
                    // console.log(buy_number);
                    // console.log(goods_id);
                    $.get(
                        "/cardo",
                        {buy_number:buy_number,goods_id:goods_id},
                        function(res){
                            // console.log(res);
                            if (res.code==1) {
                              alert(res.msg);
                              location.href="/car";
                            }else if (res.code==2) {
                              alert(res.msg);
                            };

                        },'json'
                        );
                })
            
        })
      </script>
      <tr>
       <td>
        <strong>{{$res->goods_name}}</strong>
        <p class="hui">这辈子我已经很满意了，知道你的名字，听过你的声音，牵过你的手，吻过你的唇，感受过你的怀抱，拥有过你的温柔。三里清风三里路，步步风里再无你</p>
       </td>
       <td align="right">
        <a href="javascript:;" class="shoucang"><span class="glyphicon glyphicon-star-empty"></span></a>
       </td>
      </tr>
     </form>

     </table>
     <div class="height2"></div>
     <h3 class="proTitle">商品规格</h3>
     <ul class="guige">
      <li class="guigeCur"><a href="javascript:;">50ML</a></li>
      <li><a href="javascript:;">100ML</a></li>
      <li><a href="javascript:;">150ML</a></li>
      <li><a href="javascript:;">200ML</a></li>
      <li><a href="javascript:;">300ML</a></li>
      <div class="clearfix"></div>
     </ul><!--guige/-->
     <div class="height2"></div>
     <div class="zhaieq">
      <a href="javascript:;" class="zhaiCur">商品简介</a>
      <a href="javascript:;">商品参数</a>
      <a href="javascript:;" style="background:none;">订购列表</a>
      <div class="clearfix"></div>
     </div><!--zhaieq/-->
     <div class="proinfoList">
      <img src="/index/images/image4.jpg" width="636" height="822" />
     </div><!--proinfoList/-->
     <div class="proinfoList">
      暂无信息....
     </div><!--proinfoList/-->
     <div class="proinfoList">
      暂无信息......
     </div><!--proinfoList/-->
     <table class="jrgwc">
      <tr>
       <th>
        <a href="index.html"><span class="glyphicon glyphicon-home"></span></a>
       </th>
       <td><input type="button" id="gwc"  value="加入购物车">
       </td>
      </tr>
     </table>
    </div><!--maincont-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/index/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/index/js/bootstrap.min.js"></script>
    <script src="/index/js/style.js"></script>
    <!--焦点轮换-->
    <script src="/index/js/jquery.excoloSlider.js"></script>
    <script>
		$(function () {
		 $("#sliderA").excoloSlider();
		});
	</script>
     <!--jq加减-->
    <script src="/index/js/jquery.spinner.js"></script>
   <script>
	$('.spinnerExample').spinner({});
	</script>
  </body>
</html>