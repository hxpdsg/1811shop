<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Article;
use App\Classify;
use Illuminate\Validation\Rule;
class ArticleController extends Controller
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
        if (isset($query['article_title'])) {
            $where[] = ['article_title','like',"%$query[article_title]%"];
        }
        if (isset($query['classify_name'])) {
            $where[] = ['classify_name','like',"%$query[classify_name]%"];
        }
        

        $data = Article::join('classify','article.classify_id','=','classify.classify_id')->where($where)->paginate($pagesize);
        // dd($data);
        foreach ($data as $key => $value) {
           $data[$key]['created_at'] = date('Ymd',$value['created_at']);
        }
        return view('article.list',['data' => $data,'query'=>$query]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $res = DB::table('classify')->get();
        // dd($res);

        return view('article/add',['res'=>$res]);
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        // dd($data);
         $validator = \Validator::make($request->all(), [             
            'article_title' => 'required|unique:article',         
            'classify_id' => 'required',     
            'is_sign' => 'required',     
            'is_show' => 'required',     
            ],[
                'article_title.required' => '标题不能为空!',
                'article_title.unique' => '标题已存在!',
                'classify_id.required' => '分类不能为空!',
                'is_sign.required' => '文章重要性不能为空!',
                'is_show.required' => '显示不能为空!',
            ]); 
 
        if ($validator->fails()) {             
            return redirect('article/add')->withErrors($validator)->withInput();         
        }
        dd($request->hasFile('article_img'));
        if ($request->hasFile('article_img')) {
            $res = $this->uplode($request,'article_img');
            // dd($res);
            if ($res['code']) {
                $data['article_img'] = $res['font'];
            }
        }
        $data['created_at'] = time();
        // dd($data);
        $res = Article::insert($data);
        // dd($res);
        if ($res) {
            return redirect('/article/list');
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
        $res = DB::table('Classify')->get();
        $data = Article::where('article_id','=',$id)->first();
        // dd($data);
        return view('/article/edit',compact('res','data'));
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
        dd($id);
        // echo 111;exit;
        $data = $request->except('_token');
        // dd($data);
         $validator = \Validator::make($request->all(), [
          'article_title' => [         
          'required',         
          Rule::unique('article')->ignore($data['article_id'],'article_id'),     
          ],             
            'classify_id' => 'required',     
            'is_sign' => 'required',     
            'is_show' => 'required',     
            ],[
                
                'classify_id.required' => '分类不能为空!',
                'is_sign.required' => '文章重要性不能为空!',
                'is_show.required' => '显示不能为空!',
            ]); 
 
        if ($validator->fails()) {             
            return redirect('article/edit/'.$data['article_id'])->withErrors($validator)->withInput();         
        }
        // if ($request->hasFile('article_img')) {
        //     $res = $this->uplode($request,'article_img');
        //     // dd($res);
        //     if ($res['code']) {
        //         $data['article_img'] = $res['font'];
        //     }
        // }
        // dd($data);
       // $res =Article::where('article_id',$data['article_id'])->update($data);
       // dd($res);    
       // if ($res) {
       //      return redirect('/article/list');
       //  }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {

        // $id = request()->input('article_id');
        // dd($id);
         $article_id = request()->all('article_id');
        // dd($article_id);
        // $res = Article::where('article_id', '=', $article_id)->delete();
        $res = Article::destroy($article_id);
        // dd($res);
        if ($res) {
            // return redirect('/article/list');
            return response()->json(['code' => 1,'msg'=>'删除成功']);

        }
    }

    public function checkname()
    {

         $article_title = request()->all('article_title');
         // dd($article_title);
         $res = Article::where('article_title',$article_title)->count();
         // dd($res);
         if ($res) {
            return response()->json(['code' => 1,'msg'=>'用户已存在']);
              
         }
    }


}
