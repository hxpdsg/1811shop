<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use App\Http\Requests\StoreBrandPost;

use App\Brand; 

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pagesize =config('app.pageSize');
        $query = request()->all();
        // dd($query);
        $where = [];
        if (isset($query['brand_name'])) {
            $where[] = ['brand_name','like',"%$query[brand_name]%"];
        }
        if ($query['brand_url']??'') {
            $where['brand_url'] = $query['brand_url'];
        }
         // DB::connection()->enableQueryLog();
        // $data = DB::table('brand')->where($where)->paginate($pagesize);
        $data = Brand::where($where)->paginate($pagesize);

        // $logs = DB::getQueryLog();
        // dd($logs);


        // dump($query);exit;
        return view('brand.list', ['data' => $data,'query'=>$query]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // echo 123;
        return view('brand/add');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
    // public function store(StoreBrandPost $request){
        // echo 2222;
        //  $validator = \Validator::make($request->all(), [             
        //     'brand_name' => 'required|unique:brand|max:255',         
        //     'user_age' => 'required',     
        //     'user_tel' => 'required',     
        //     ],[
        //         'brand_name.required' => '用户名不能为空!',
        //         'brand_name.unique' => '用户名已存在!',
        //         'brand_name.max' => '用户名长度不能超过255!',
        //         'user_age.required' => '年龄不能为空!',
        //         'user_tel.required' => '电话不能为空!',
        //     ]); 
 
        // if ($validator->fails()) {             
        //     return redirect('brand/add')->withErrors($validator)->withInput();         
        // }
        $data = $request->except('_token');
        //validate验证第一种方法
         // $validatedData = $request->validate([         
         //    'brand_name' => 'required|unique:brand|max:255',         
         //    'brand_url' => 'required',     
         //    'brand_logo' => 'required',     
         //    'brand_desc' => 'required',     
         //    ],[
         //        'brand_name.required' => '用户名不能为空!',
         //        'brand_name.unique' => '用户名已存在!',
         //        'brand_name.max' => '用户名长度不能超过255!',
         //        'brand_url.required' => '网址不能为空!',
         //        'brand_logo.required' => 'logo不能为空!',
         //        'brand_desc.required' => '描述不能为空!',
         //    ]);
        // dd($request->hasFile('brand_logo'));
        if ($request->hasFile('brand_logo')) {
            $res = $this->uplode($request,'brand_logo');
            // dd($res);
            if ($res['code']) {
                $data['brand_logo'] = $res['font'];
            }
        }
        // dd($uplode);
        // $res = DB::table('brand')->insert($data);
        $res = Brand::insert($data);
        // dd($res);
        if ($res) {
            return redirect('/brand/list');
        }
    }
    public function uplode(Request $request,$file)
    {
        // dump($file);exit;
        if ($request->file($file)->isValid()) {         
           $photo = $request->file($file);         
           // $extension = $photo->extension();         
            $store_result = $photo->store(date('Ymd'));  
            // dd($store_result);
            return ['code'=>1,'font'=>$store_result];     

        }else{
            return ['code'=>0,'font'=>'上传出错'];     

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
        // $data = DB::table('brand')->where('brand_id', '=', $id)->get();
        $data = Brand::where('brand_id', '=', $id)->get();
        // dd($data);
        return view('brand.edit',['data'=>$data]);
        
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
        $data = $request->except('_token');
        // dd($data);
        if ($request->hasFile('brand_logo')) {
            $res = $this->uplode($request,'brand_logo');
            // dd($res);
            if ($res['code']) {
                $data['brand_logo'] = $res['font'];
            }
        }
       // $res = DB::table('brand')->where('brand_id', $data['brand_id'])->update($data);
       $res =Brand::where('brand_id', $data['brand_id'])->update($data);
       // dd($res);
        if ($res) {
            return redirect('/brand/list');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dump($id);exit;
        // $res = DB::table('brand')->where('brand_id', '=', $id)->delete();
        $res = Brand::where('brand_id', '=', $id)->delete();
        if ($res) {
            return redirect('/brand/list');
        }
    }
}
