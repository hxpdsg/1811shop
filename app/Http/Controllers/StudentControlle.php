<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use App\Student; 

use Illuminate\Support\Facades\Auth;

class StudentControlle extends Controller
{
    //手动验证登录
    public function authlogin()
    {
      $name =  request()->name;
      $password =  request()->password;
      if (Auth::attempt(['email' => $name, 'password' => $password])) {
 
        // return redirect()->intended('dashboard');
        return "登陆成功";
      }else{
        return "登录失败";
      }

    }

    //发送邮件
    public function email()
    {
      $email =  request()->name;
      // dd($email);
        
        $this->send($email);  
        echo "发送成功";
    }
//send后面的email  是视图文件 在resources/views的email.blade.php文件写的内容 可以自定义文件名和内容
//发送邮件的配置在config中mail的账号和用户名
    public function send($email){
        \Mail::send('email' , ['name'=>$email] ,
            function($message)use($email){
        //设置主题
            $message->subject("十三亿少女的梦");
        //设置接收方
            $message->to($email);
        });
    }
    // public function send($email){
    //     \Mail::raw('我有一个哥哥，前两年开公司赚了不少钱。嫂子跟他吃的好穿的好。可公司倒闭了，他也背了一身债，可能好多年都还不完。他不想让嫂子跟着他受委屈。就递给了她一份离婚协议书。但后来两人没离婚，这个哥哥拼命赚钱，把欠的钱都还清了，还赚了不少，有次吃饭的时候我们开玩笑问嫂子，当初怎么不和他离婚。她笑了笑没说话。哥哥说:那天晚上嫂子抱着他大腿不让他走，一边哭一边说:以前都是你养我，现在换我养你行不行？哥哥说他这辈子绝对不会让一个女人养他。嫂子又说:那你继续养我行吗？养我很便宜的，花不了你多少钱。你没钱没事，我养你，你不让我养你也没事，那你养我，养我很便宜的',
    //         function($message)use($email){
    //     //设置主题
    //         $message->subject("十三亿少女的梦");
    //     //设置接收方
    //         $message->to($email);
    //     });
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('student/add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->input();
        $validator = \Validator::make($request->all(), [             
                
            'student_name' => 'required',     
            ],[
                'student_name.required' => '用户名不能为空!',
            ]); 
        if ($validator->fails()) {             
            return redirect('student/add')->withErrors($validator)->withInput();
            // return ['code'=>1,'msg'=>''];         
        }
        // dd($data);
        $res = DB::table('student')->insert($data);
        // dd($res);
        if ($res) {
            return response()->json(['code' => 1]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
