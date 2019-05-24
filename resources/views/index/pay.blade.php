<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>支付</title>
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
       <h1>购物车</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="/index/images/head.jpg" />
     </div><!--head-top/-->
     <div class="dingdanlist">
      <table>
      
      @if($pay==null)
       <tr>
        <td class="dingimg" width="75%" colspan="2"> <a href="/address">新增收货地址</a></td>
        <td align="right"><img src="/index/images/jian-new.png" /></td>
       </tr>
      @else
      @foreach($pay as $v)
       <tr >
        <td width="50%">
         <h3><input type="radio" value="{{$v->address_id}}" @if($v->is_defaut=='1') checked @endif>   {{$v->address_name}} {{$v->address_tel}}</h3>
         <time>{{$v->province}} {{$v->city}} {{$v->area}} {{$v->address_detail}}</time>
        </td>
        <td align="right"><a href="address.html" class="hui"><span class="glyphicon glyphicon-check"></span> 修改信息</a></td>
       </tr>
       @endforeach

      @endif
      <tbody id="goodsInfo">
       @foreach($data as $v)
       <tr goods_id={{$v->goods_id}}>
        <td class="dingimg" width="15%"><img src="{{config('app.img_url')}}{{$v->goods_img}}" /></td>
        <td width="50%">
         <h3>{{$v->goods_name}}</h3>
         <time>下单时间：{{$v->created_at}}</time>
        </td>
        <td align="right"><span class="qingdan">X {{$v->buy_number}}</span></td>
        <td align="right"><span class="qingdan">¥{{$v->buy_number*$v->goods_price}}</span></td>
       </tr>
       
      @endforeach 
      </tbody>
       <tr>
        <td class="dingimg" width="75%" colspan="2">商品金额</td>
        <td align="right"><strong class="orange">¥{{$Total}}</strong></td>
       </tr>
       <tr>
        <td class="dingimg" width="75%" colspan="2">折扣优惠</td>
        <td align="right"><strong class="green">¥0.00</strong></td>
       </tr>
       <tr>
        <td class="dingimg" width="75%" colspan="2">抵扣金额</td>
        <td align="right"><strong class="green">¥0.00</strong></td>
       </tr>
       <tr>
        <td class="dingimg" width="75%" colspan="2">运费</td>
        <td align="right"><strong class="orange">¥0.00</strong></td>
       </tr>
      </table>
     </div><!--dingdanlist/-->
     
     
    </div><!--content/-->
    
    <div class="height1"></div>
    <div class="gwcpiao">
     <table>
      <tr>
       <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
       <td width="50%">总计：<strong class="orange">¥{{$Total}}</strong></td>
       <td width="40%"><a href="/pcpay">电脑端支付</a><a href="/mobilepay">手机端支付</a><a  class="jiesuan">提交订单</a></td>
      </tr>
     </table>
    </div><!--gwcpiao/-->
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
<script src="/js/jquery-3.2.1.min.js"></script>

<script>
      $(function(){
          //提交订单
          $('.jiesuan').click(function(){
            // alert(11);
            var _tr = $('#goodsInfo').children('tr');
            // console.log(_tr);
            var goods_id = '';
            _tr.each(function(index){
            goods_id+=$(this).attr('goods_id')+',';
            })
            var goods_id = goods_id.substr(0,goods_id.length-1);
            // console.log(goods_id);
            var address_id = $(':checked').val();
            // console.log(address_id);
            $.get(
              "/submitpay",
              {goods_id:goods_id,address_id:address_id},
              function(res)
              {
                // console.log(res);
                if (res.code==1) {
                  alert(res.msg);
                }else if(res.code==2){
                  alert(res.msg);
                }
                
              },'json'
            )
          })
        })
    </script>