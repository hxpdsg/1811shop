<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Register;
use DB;
class RegisterController extends Controller
{
   public function login(){
        return view('index.login');
       
    }
    public function logindo()
    {
        $data = request()->except('_token');
        // dd($data);
        if($data['email']==''){
            return redirect('/login/login')->with('status','账号不能为空');

        }
        if($data['pwd']==''){
            return redirect('/login/login')->with('status','密码不能为空');

        }
        $res = DB::table('register')->where('email',$data['email'])->first();
        // dd($res);
        if ($res->pwd!=$data['pwd']) {
            return redirect('/login/login')->with('status','账号或密码错误');
           
        }else{
            
                // dd($r_id);
            // session(['user'=>$res]);
                request()->session()->put('r_id',$res->r_id);
                // dd(request()->session()->get('r_id'));
                return redirect('/')->with('status','登陆成功');
        }
           



    }
    public function register()
    {
        return view('index.register');
        
    }
    public function registerhandle()
    {
        // echo 1111;die;
        $data = request()->except('pwd1');
        // $data = request()->input();
        $code  = request()->session()->get('code');
        // dd($code);
        if ($data['code'] != $code['rand']) {
            return redirect('/login/reg')->with('status','验证码错误');
        }
        // if ($data['pwd'] != $data['pwd1']) {
        //     return redirect('/login/reg')->with('status','两次密码输入不一致');
           
        // }
        $res = DB::table('register')->insert($data);
        // $res = Register::insert($data);
        // dd($res);
        if ($res) {

            return redirect('/login/login')->with('status','注册成功');
          
        }
    }
    public function registerdo()
    {
        $email =  request()->email;
        // dd($email);
        $rand = rand(100000,999999);
        \Mail::raw($rand,
            function($message)use($email){
        //设置主题
            $message->subject("十三亿少女的梦");
        //设置接收方
            $res = $message->to($email);
            
        });
        // dd($res);
        // if ($res) {
                $code = [
                    'time'=>time(),
                    'rand'=>$rand,
                    'email'=>$email
                ];
                request()->session()->put('code',$code);
            return ['code'=>1,'msg'=>'发送成功'];
        // }else{
        //     return ['code'=>2,'msg'=>'发送失败'];
        // }
    }
    public function email()
    {
        // echo 1;die;
        $email = request()->email;
        // dd($email);
        $res = DB::table('register')->where('email',$email)->count();
        // dd($res);
        if ($res) {
            return ['code'=>1,'msg'=>'用户名已存在'];
           
        }

    }

}
