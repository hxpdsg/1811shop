<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class IndexController extends Controller
{
    //电脑端支付
    public function pcpay()
    {
        
        $config = config('pay');
        // dd(app_path('libs\aliyunpay\pagepay\service\AlipayTradeService.php'));
        require_once app_path('libs\aliyunpay\pagepay\service\AlipayTradeService.php');
        require_once app_path('libs\aliyunpay\pagepay\buildermodel\AlipayTradePagePayContentBuilder.php');

        //商户订单号，商户网站订单系统中唯一订单号，必填
        $order_no = date('YmdHis').rand(10000,99999);

        //订单名称，必填
        $subject = '潮牌衣服';
        //通过订单号查询订单金额
        //付款金额，必填
        $order_amount = 200000;

        //商品描述，可空
        $body = '时尚潮流';

        //构造参数
        $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setTotalAmount($order_amount);
        $payRequestBuilder->setOutTradeNo($order_no);

        $aop = new \AlipayTradeService($config);

        /**
         * pagePay 电脑网站支付请求
         * @param $builder 业务参数，使用buildmodel中的对象生成。
         * @param $return_url 同步跳转地址，公网可以访问
         * @param $notify_url 异步通知地址，公网可以访问
         * @return $response 支付宝返回的信息
        */
        $response = $aop->pagePay($payRequestBuilder,$config['return_url'],$config['notify_url']);

        //输出表单
        var_dump($response);
    }
    public function returnpay()
    {
        $config = config('pay');
        require_once app_path('libs\aliyunpay\pagepay\service\AlipayTradeService.php');


        $arr=$_GET;
        $alipaySevice = new \AlipayTradeService($config); 
        $result = $alipaySevice->check($arr);
        // dd($arr);
        /* 实际验证过程建议商户添加以下校验。
        1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
        2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
        3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
        4、验证app_id是否为该商户本身。
        */
        if($result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代码
            
            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

            //商户订单号
            $where['order_no'] = htmlspecialchars($_GET['out_trade_no']);
            $where['order_amount'] = htmlspecialchars($_GET['total_amount']);
            // dd($where['order_amount']);

            //支付宝交易号
            $trade_no = htmlspecialchars($_GET['trade_no']);
            $count = DB::table('order')->where($where)->count();
            // dd($count);
            if($count){
                echo "验证成功<br />支付宝交易号：".$order_no."订单号：".$where['order_no']."订单金额".$where['order_amount']."此订单存在异常";exit;
            }
            if(config('pay.seller_id') !=htmlspecialchars($_GET['seller_id'])){
                echo "验证成功<br />支付宝交易号：".$trade_no."订单号：".$where['order_no']."订单金额".$where['trade_amount']."此订单存在异常,商户id不匹配";exit;
            }
            if(config('pay.app_id') !=htmlspecialchars($_GET['app_id'])){
                echo "验证成功<br />支付宝交易号：".$trade_no."订单号：".$where['order_no']."订单金额".$where['trade_amount']."此订单存在异常,APP_id不匹配";exit;
            }
                
            echo "验证成功<br />支付宝交易号：".$trade_no;

            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
            
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }
        else {
            //验证失败
            echo "验证失败";
        }
    }
    //手机端支付
    public function mobilepay()
    {

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = DB::table('category')->where('cate_pid',0)->get();
        // dd($category);
        $goods = DB::table('goods')->limit(10)->get();
        // dd($goods);
        return view('index/index',compact('category','goods'));

    }
    //商品详情页
    public function  proinfo($id)
    {
        $res = DB::table('goods')->where('goods_id',$id)->first();
        // dd($res);
        return view('/index/proinfo',compact('res')); 
    }
    // 个人中心
    public function user()
    {
        return view('index/user');

    }
    //所有商品
    public function prolist()
    {
        return view('index/prolist');

    }
    //购物车添加
    public function cardo()
    {
        $data = request()->input();
        $where = [
            ['goods_id','=',$data['goods_id']],
            ['is_del','=',1]
        ];
        $res = DB::table('cart')->where($where)->first();
        // dd($res);
        $buy = DB::table('goods')->where('goods_id',$data['goods_id'])->first();
        // dd($data);
        $buy_number = $data['buy_number'];
        $goods_num = $buy->goods_num;

        if ($buy_number>$goods_num) {
               return ['code'=>2,'msg'=>'库存不足'];exit;
        }else{
                if ($res) {
                // echo 1;exit;
                // dd($buy_number);
                $r_id = request()->session()->get('r_id');
                // dd($r_id);
                $where = [
                    ['r_id','=',$r_id],
                    ['goods_id','=',$data['goods_id']]
                ];
                $res2 = DB::table('cart')->where($where)->increment('buy_number',$data['buy_number']);

               // $res2 = DB::table('cart')->update($data);
               // dd($res2);
               if ($res2) {
                   return ['code'=>1,'msg'=>'加入购物车成功'];
               }
            }else{
                // echo 2;exit;
                $data['created_at'] = time();
                // echo 1;exit;
                $r_id = request()->session()->get('r_id');
                // dd(request()->session()->get('r_id'));
                $data['r_id'] = $r_id;
                // dd($data);
                $res1 = DB::table('cart')->insert($data);
                // dd($res);
                if ($res1) {
                   return ['code'=>1,'msg'=>'加入购物车成功'];
                }
            }
            }

        
        
    }
    //购物车列表展示
    public function car()
    {
        $r_id = request()->session()->get('r_id');
        // dd($r_id);
        $where = [
            ['r_id','=',$r_id],
            ['is_del','=',1]
        ];
        $res = DB::table('cart')->join('goods','goods.goods_id','=','cart.goods_id')->where($where)->get()->toArray();
        // dd($res);
        foreach ($res as $k => $v) {
            $res[$k]->created_at = date('Ymd H:i:s',$v->created_at);
        }
        // dd($res);
        return view('index/car',['res'=>$res]);

    }
    //更改购买数量
    public function changeNumber()
    {
        // $goods_id = request()->goods_id;
        // $data = request()->except('goods_id');
        $data = request()->input();
        // dd($data);

        $r_id = request()->session()->get('r_id');
        // dd($r_id);
           $where = [
                ['r_id','=',$r_id],
                ['goods_id','=',$data['goods_id']]
            ];
            $dare = DB::table('cart')->where($where)->update(['buy_number'=>$data['buy_number']]);
            // dd($dare);
    }
    //购物车删除
    public function del()
    {
        $goods_id = request()->goods_id;
        // dd($goods_id);
        $goods_id = explode(',', $goods_id);
        // dd($goods_id);
        $r_id = request()->session()->get('r_id');
        // dd($r_id);
        $where = [
                ['r_id','=',$r_id],
                // ['goods_id','in',$data['goods_id']]
            ];
            // dd($where);
        $date = DB::table('cart')->where($where)->whereIn('goods_id',$goods_id)->update(['is_del'=>2]);
        // dd($date);
        if ($date) {
            return ['code'=>1,'msg'=>'删除成功'];
        }

    }
    //总价
    public function Count()
    {
        $goods_id = request()->goods_id;
        $goods_id = explode(',', $goods_id);

        // dd($goods_id);
        $r_id = request()->session()->get('r_id');
        // dd($r_id);
        $whe = [
            ['r_id','=',$r_id],
            ['is_del','=',1],
        ];
        
        $data = DB::table('cart')-> join('goods','cart.goods_id','=','goods.goods_id')->where($whe)->whereIn('goods.goods_id',$goods_id)->get();
        // dd($goods_price);
        // dd($data);
        $count = 0;
        foreach ($data as $k => $v) {
            $count += $v->goods_price*$v->buy_number;
        }
        // dd($count);
        echo $count;

    }
    public function SubTotal()
    {
        $goods_id = request()->goods_id;
        $r_id = request()->session()->get('r_id');
        // dd($r_id);
        // dd($goods_id);
        $where = [
            ['r_id','=',$r_id],
            ['is_del','=',1],
            ['goods_id','=',$goods_id]
        ];
        $data = DB::table('cart')->where($where)->get();
        // dd($data);
        $goods_price = DB::table('goods')->where('goods_id',$goods_id)->get();
        // dd($goods_price);

        $Total = 0;
        foreach ($goods_price as $key => $value) {
            foreach ($data as $k => $v) {
            $Total += $value->goods_price*$v->buy_number;
            }
        }
        // dd($Total);
        echo $Total;
        

    }
    //结算
    public function pay()
    {
        $r_id = request()->session()->get('r_id');
        // dd($r_id);
        if ($r_id) {
            return ['code'=>1];
        }else{
            return ['code'=>2,'msg'=>'请登录'];
        }
    }
    public function payorder($goods_id)
    {
        $goods_id = explode(',', $goods_id);
        // dd($goods_id);
        $r_id = request()->session()->get('r_id');
        $pay = DB::table('address')->where('r_id',$r_id)->get()->toArray();
        // dd($pay);

        
        $where = [
            ['r_id','=',$r_id],
            ['is_del','=',1],
        ];
        $data = DB::table('cart')-> join('goods','cart.goods_id','=','goods.goods_id')->where($where)->whereIn('goods.goods_id',$goods_id)->get();
        // dd($data);
        $Total = 0;
        foreach ($data as $k => $v) {
            $Total += $v->goods_price*$v->buy_number;
        }
        // dd($Total);
        // echo $Total;
        return view('/index/pay',['data'=>$data,'Total'=>$Total,'pay'=>$pay]);        
    }
    //地址
    public function address()
    {
        $provinceInfo = $this->getAreaInfo(0);

        return view('/index/address',compact('provinceInfo'));
    }
    //省份
    public function getAreaInfo($pid)
    {
        
        $provinceInfo = DB::table('area')->where('pid',$pid)->get()->toArray();
        
        if ($provinceInfo) {
            return $provinceInfo;
        }else{
            return false;
        }
    }
    public function getArea()
    {
        $pid = request()->pid;
        // dd($pid);
        // // dump($pid);exit;
        if ($pid=='') {
            return ['code'=>2,'msg'=>'请至少选择一个'];
        }
        $areaInfo = $this->getAreaInfo($pid);
        if ($areaInfo) {
            echo json_encode($areaInfo);
        }
    }
   
   public function addressdo()
   {
        $data = request()->input();
        // dd($data);
        if ($data['is_defaut']==1) {
           $r_id = request()->session()->get('r_id');
            $data['r_id'] = $r_id;
            // dd($res);
            $defail = [
                'is_defaut'=>2
            ];
            $res2 = DB::table('address')->where('r_id',$r_id)->update($defail);
            // dd($res2);
            $res = DB::table('address')->insert($data);

            if ($res || $res2) {
                return ['code'=>1,'msg'=>'保存成功'];
            }else{
                echo 2;
            }
            }else{
            $r_id = request()->session()->get('r_id');
            $data['r_id'] = $r_id;
            $res = DB::table('address')->insert($data);
            if ($res ) {
                return ['code'=>1,'msg'=>'保存成功'];
            }
        }
    
   }
   public function addresslist()
   {
        $r_id = request()->session()->get('r_id');

        $data = DB::table('address')->where('r_id',$r_id)->get();
        // dd($data);
        return view('index/addresslist',['data'=>$data]);
   }
   //表单提交
   public function submitpay()
   {
    $goods_id = request()->goods_id;
    $address_id = request()->address_id;
    // dd($address_id);
    // $address_id ='';
    if ($goods_id=='') {
         return ['code'=>2,'msg'=>'商品不能为空'];
    }
    if ($address_id=='') {
         return ['code'=>2,'msg'=>'收货地址不能为空'];
    }
            //订单信息写入订单表
                $r_id = request()->session()->get('r_id');
                // // dump($user_id);exit;
                $order_no = $this->OrderNo();//订单号
                // dd($order_no);
                $order_amount = $this->getOrderAmount($goods_id);
                // dump($order_amount);exit;

                // $orderInfo['goods_id'] =$goods_id;//商品id
                $orderInfo['r_id'] =$r_id;//user_id
                $orderInfo['address_id'] =$address_id;//地址id
                $orderInfo['order_no'] =$order_no;//订单号
                $orderInfo['order_amount'] =$order_amount;//订单总金额
                $orderInfo['created_at'] =time();//添加时间
                // dd($orderInfo);
                $order_id = DB::table('order')->insertGetId($orderInfo);
                // dd($order_id);
            //订单收货地址
                $addressWhere = [
                    ['address_id','=',$address_id],
                    ['is_del','=',1]
                ];
                $addressInfo = DB::table('address')->where($addressWhere)->first();
                $addressInfo = $this->objectToArray($addressInfo);
                // dd($addressInfo);
                if ($addressInfo=='') {
                    return ['code'=>2,'msg'=>'没有此收货地址，请重新选择'];
                }
                
                $addressInfo['order_id'] = $order_id;
                
                unset($addressInfo['is_defaut']);
                unset($addressInfo['address_id']);
                // dd($addressInfo);

                $res2 = DB::table('orderaddress')->insert($addressInfo);

                // dd($res2);
                if ($res2=='') {
                    return ['code'=>2,'msg'=>'没有此收货地址，添加失败'];

                }
            //订单详情添加
                $goodsInfo = $this->getOrderDetail($goods_id);
                // dd($goodsInfo);
                foreach ($goodsInfo as $k => $v) {
                    $goodsInfo[$k]['order_id'] = $order_id;
                    $goodsInfo[$k]['r_id'] = $r_id;
                }
                // $goodsInfo = '';
                // dd($goodsInfo);
                if ($goodsInfo=='') {
                    return ['code'=>2,'msg'=>'没有商品详情数据'];
                }
                // dd($goodsInfo);
                $res3 =  DB::table('orderdetail')->insert($goodsInfo);
                // dd($res3);
                if ($res3=='') {
                    return ['code'=>2,'msg'=>'订单详情写入失败'];
                }
                //删除购物车数据
                $cartWhere = [
                    ['r_id','=',$r_id],
                    ['is_del','=',1],
                ];
                 $goods_id = explode(',', $goods_id);

                // dd($cartWhere);
                $res4 = DB::table('cart')->where($cartWhere)->whereIn('goods_id',$goods_id)->update(['is_del' => 2]);
                // dd($res4);
                 // dd($goodsInfo);
                foreach ($goodsInfo as $k => $v) {
                    // $goodsWhere = [
                    //     ['goods_id','in',$goods_id]
                    // ];
                    $update = [
                        'goods_num' => $v['goods_num']-$v['buy_number']
                    ];
                    // dd($goods_id);
                    // dd($update);
                    $res5 = DB::table('goods')->whereIn('goods_id',$goods_id)->update($update);
                    // dd($res5);
                    if ($res5='') {
                    return ['code'=>2,'msg'=>'减少库存失败'];
                    }
                }
                // echo 1;
                    // dump($res5);exit;
                $arr = [
                    'code'=>1,
                    'msg'=>'下单成功',
                    'order_id'=>$order_id
                ];
                echo json_encode($arr);
   }
   //订单号
    public function OrderNo()
    {
        $r_id = request()->session()->get('r_id');
        return time().rand(100,999).$r_id;
    }
    public function getOrderAmount($goods_id)
    {
        $goods_id = explode(',', $goods_id);
        $r_id = request()->session()->get('r_id');
        $where = [
            ['r_id','=',$r_id],
            ['is_del','=',1]
        ];

        $data = DB::table('cart')-> join('goods','cart.goods_id','=','goods.goods_id')->where($where)->whereIn('goods.goods_id',$goods_id)->get();
        // dd($data);
        $count = 0;
        foreach ($data as $k => $v) {
            $count += $v->goods_price*$v->buy_number;
        }
        // dd($count);
        
        return $count;
    }
    function objectToArray($object) {
    //先编码成json字符串，再解码成数组
    return json_decode(json_encode($object), true);
    }
    //获取商品详情信息
    public function getOrderDetail($goods_id)
    {
       
        $r_id = request()->session()->get('r_id');
        $goods_id = explode(',', $goods_id);

        // dd($goods_id);
            $where = [
                ['r_id','=',$r_id],
                ['goods_up','=',1],
                ['is_del','=',1]
            ];
             $goodsInfo = DB::table('cart')
             ->select('cart.goods_id','goods_name','goods_price','buy_number','goods_img','is_del','goods_num')
             -> join('goods','cart.goods_id','=','goods.goods_id')
             ->where($where)
             ->whereIn('goods.goods_id',$goods_id)
             ->get()
             ->toArray();
             // dd($goodsInfo);
            $goodsInfo = $this->objectToArray($goodsInfo);
            // dd($goodsInfo);
            return $goodsInfo;
    }





}
