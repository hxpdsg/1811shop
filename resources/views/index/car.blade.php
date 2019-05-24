<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>购物车列表</title>
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
     <table class="shoucangtab">
      <tr>
       <td width="75%"><span class="hui">购物车共有：<strong class="orange">2</strong>件商品</span></td>
       <td width="25%" align="center" style="background:#fff url(/index/images/xian.jpg) left center no-repeat;">
        <span class="glyphicon glyphicon-shopping-cart" style="font-size:2rem;color:#666;"></span>
       </td>
      </tr>
     </table>

     <div class="dingdanlist">
      <table>
      {{csrf_field()}}
      @foreach($res as $v)
       <tr goods_id={{$v->goods_id}}>
        <td width="4%"><input type="checkbox" name="checkall" id="allbox" class="box"></td>
        <td class="dingimg" width="15%"><img src="{{config('app.img_url')}}{{$v->goods_img}}" /></td>
        <td width="50%">
         <h3>{{$v->goods_name}}</h3>
         <time>下单时间：{{$v->created_at}}</time>
        </td>
        <td>
            <div>
              <input type="button"  class="car_btn_1" value="-" />
              <input type="text" value="{{$v->buy_number}}" name="" class="car_ipt" style="width:20%" />  
              <input type="button"   class="car_btn_2" value="+" />
            </div>
        </td>
       </tr>
       <tr>
        <th colspan="4"><strong class="Total">¥{{$v->goods_price*$v->buy_number}}</strong></th>
       </tr>
       @endforeach
       <tr>
        <td width="100%" colspan="4"><a class="del"> 删除</a></td>
       </tr>
      </table>
      <script src="/js/jquery-3.2.1.min.js"></script>

      <script>
        $(document).on("click",'.car_btn_2',function(){
            var _this = $(this);
            //input框中的值
            var buy_number =parseInt(_this.prev('input').val());
            // console.log(buy_number);
            var goods_num = _this.parents('tr').attr('goods_num');
            var goods_id = _this.parents('tr').attr('goods_id');

            // console.log(goods_id);
            // 判断库存是否大于框中的值
            if (buy_number>=goods_num) {
              //如果库存大于框中的值  那就最大是库存
              _this.prev('input').val(goods_num);
            }else{
               buy_number=buy_number+1;
              _this.prev('input').val(buy_number);
            }

            // 改变购买数量
            var flag=0;
              $.ajax({
                type:'get',
                url:"/changeNumber",
                data:{buy_number:buy_number,goods_id:goods_id},
                async:false,
                success:function(res){
                  // console.log(res);
                  // if(res.code==2){
                  //   layer.msg(res.font,{icon:res.icon});
                  //   flag=1;
                  // }
                }
              });
            // if(flag==1){
            //   return false;
            // }
            //当前复选框选中   
            boxChecked(_this);
            //小计
            getSubTotal(goods_id,_this);
            
            //计算总价
            getCount();
            })
        $(document).on("click",'.car_btn_1',function(){
            var _this = $(this);
            //input框中的值
            var buy_number =parseInt(_this.next('input').val());
            // console.log(buy_number);
            var goods_num = _this.parents('tr').attr('goods_num');
            var goods_id = _this.parents('tr').attr('goods_id');

            // console.log(buy_number);
            if (buy_number>=1) {
               buy_number=buy_number-1;
              _this.next('input').val(buy_number);
            }
            // 改变购买数量
            var flag=0;
              $.ajax({
                type:'get',
                url:"/changeNumber",
                data:{buy_number:buy_number,goods_id:goods_id},
                async:false,
                success:function(res){
                  // if(res.code==2){
                  //   layer.msg(res.font,{icon:res.icon});
                  //   flag=1;
                  // }
                }
              });
            // if(flag==1){
            //   return false;
            // }
            //当前复选框选中  
            boxChecked(_this);
            //小计
            getSubTotal(goods_id,_this);
            
            //计算总价
            getCount();
          })
        $('.del').click(function(){
          //获取选中复选框中的商品id
          var _box = $('.box');
          // console.log(_box);
          var goods_id = ''
          _box.each(function(index){
            if ($(this).prop('checked')==true) {
              goods_id+=$(this).parents("tr").attr("goods_id")+',';
            }
          });
          goods_id = goods_id.substr(0,goods_id.length-1);
          // console.log(goods_id);
          $.get(
              "/del",
              {goods_id:goods_id},
              function(res){
                  // console.log(res);
                  if (res.code==1) {
                    alert(res.msg);
                    location.href = "/car";
                    // getCount();
                  };
                },'json'
                );
        })
        $(document).on("click",'.jiesuan',function(){
          var _box = $('.box');
          console.log(_box);
          var goods_id='';
          _box.each(function(index){
            if ($(this).prop('checked')==true) {
              goods_id +=$(this).parents('tr').attr('goods_id')+',';
            };
          })
          // console.log(goods_id);
          if (goods_id=='') {
            alert('请选择一件商品');
            return false;
          }else{
            goods_id = goods_id.substr(0,goods_id.length-1);
          }
          // console.log(goods_id);
          $.get(
              "/pay",
              function(res)
              {
                console.log(res);
                if (res.code==1) {
                  location.href = "/payorder/"+goods_id;
                }else if(res.code==2){
                  alert(res.msg);
                    location.href="/login/login";
                }
              },'json'
            )
        })
        function getCount()
        {
          var _box = $('.box');
          // console.log(_box);
          var goods_id = '';
          _box.each(function(index){
            if ($(this).prop('checked')==true) {
             goods_id+=$(this).parents("tr").attr("goods_id")+',';
            };
          })
          var goods_id = goods_id.substr(0,goods_id.length-1);
          console.log(goods_id);
          $.get(
              "/Count",
              {goods_id:goods_id},
              function(res){
                // console.log(res);
                $('.count').text('￥'+res);
              }
            );
        }
        function boxChecked(_this)
        {
          _this.parents("tr").find("input[class='box']").prop("checked",true);
        }
        //计算小计
        function getSubTotal(goods_id,_this)
        {
          // console.log(goods_id);
          $.get(
              "/SubTotal",
              {goods_id:goods_id},
              function(res){
                // console.log(res); 
                _this.parents('tr').next('tr').text('￥'+res); 

              }
            );
        }
      </script>
     </div><!--dingdanlist/-->
     <div class="height1"></div>
     <div class="gwcpiao">
     <table>
      <tr>
       <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
       <td width="50%">总计：<strong class="count">¥ 0</strong></td>
       <td width="40%"><a  class="jiesuan">去结算</a></td>
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