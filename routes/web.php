<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
// 	session(['uid'=>88]);
//     return view('welcome');
// });


//视图的简便方法
// Route::view('/','welcome');
//在视图里面添加一个  需要这样使用{{$website}
// Route::view('/','welcome',['website'=>'学院']);


//路由闭包请求
// Route::get('/goods', function () {
//     return 'goods!!!';
// });


// 路由url请求
// Route::get('/goods','GoodsController@index');


//post传值  必须在form里面的method设置post方式传值

//发送邮件
// Route::get('/student',function(){
// 	return "<form action='/student_do' method=post>".csrf_field()."<input type=text name=name><button>提交</button></form>";
// });
// Route::post('student_do','StudentControlle@email');


//手动认证用户登录
Route::get('/student',function(){
	return "<form action='/login_do' method=post>".csrf_field()."账号：<input type=text name=name>密码：<input type=password name=password><button>提交</button></form>";
});
Route::post('login_do','StudentControlle@authlogin');

// Route::post('/from_do',function(){
// 	return request()->name;
// });


// get传值
// Route::get('/from', function () {
//     return "<form action='/from_do'>".csrf_field()."<input type=text name=name><button>提交</button></form>";
// });
// Route::get('/from_do',function(){
//     //request 接收值
//     return request()->name;
// });


//路由传参   地址栏参数不能用$
// Route::get('index/{id}/{cid}',function($id,$cid){
// 	echo $id.'='.$cid;
// });
// //参数后面加?好  意思是此参数可传可不传   但是function后面的参数必须给默认值
// Route::get('index/{id?}',function($id){
// 	echo $id;
// });
// Route::prefix('/brand')->middleware('checklogin')->group(function(){
Route::prefix('/brand')->group(function(){
	Route::get('add','BrandController@create');
	// Route::get('add','BrandController@create')->middleware('checktoken');
	Route::post('add_do','BrandController@store');
	Route::get('list','BrandController@index');
	Route::get('edit/{id}','BrandController@edit');
	Route::post('edit/{id}','BrandController@update');
	Route::get('del/{id}','BrandController@destroy');
});
Route::prefix('/user')->group(function(){
	Route::get('add','UserController@create');
	Route::post('add_do','UserController@store');
	Route::get('list','UserController@index');
	Route::get('edit/{id}','UserController@edit');
	Route::post('edit/{id}','UserController@update');
	Route::get('del/{id}','UserController@destroy');
});
// Route::prefix('/student')->group(function(){
// 	Route::get('add','StudentControlle@create');
// 	Route::post('add_do','StudentControlle@store');
// 	Route::get('list','StudentControlle@index');
// 	Route::get('edit/{id}','StudentControlle@edit');
// 	Route::post('edit/{id}','StudentControlle@update');
// 	Route::get('del/{id}','StudentControlle@destroy');
// });
Route::prefix('/article')->middleware('checklogin')->group(function(){
	Route::get('add','ArticleController@create');
	Route::post('add_do','ArticleController@store');
	Route::get('list','ArticleController@index');
	Route::get('edit/{id}','ArticleController@edit');
	Route::post('edit/{id}','ArticleController@update');
	Route::get('del','ArticleController@destroy');
	Route::get('checkname','ArticleController@checkname');
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
//pc端支付
Route::get('/pcpay', 'Index\IndexController@pcpay');
Route::get('/returnpay', 'Index\IndexController@returnpay');
//手机端支付
Route::get('/mobilepay', 'Index\IndexController@mobilepay');



Route::prefix('/')->group(function(){
	Route::get('/','Index\IndexController@index');
	Route::get('/proinfo/{id}','Index\IndexController@proinfo');
	Route::get('/user','Index\IndexController@user');
	Route::get('/prolist','Index\IndexController@prolist');
	Route::get('/cardo','Index\IndexController@cardo');
	Route::get('/changeNumber','Index\IndexController@changeNumber');
	Route::get('/del','Index\IndexController@del');
	Route::get('/Count','Index\IndexController@Count');
	Route::get('/SubTotal','Index\IndexController@SubTotal');
	Route::get('/pay','Index\IndexController@pay');
	Route::get('/payorder/{id}','Index\IndexController@payorder');
	Route::get('/address','Index\IndexController@address');
	Route::get('/getArea','Index\IndexController@getArea');
	Route::get('/addressdo','Index\IndexController@addressdo');
	Route::get('/addresslist','Index\IndexController@addresslist');
	Route::get('/submitpay','Index\IndexController@submitpay');
	Route::get('/success','Index\IndexController@success');
	

	Route::get('/car','Index\IndexController@car');

});
// Route::get('/','Index\IndexController@index');

Route::prefix('/login')->group(function(){
	Route::get('login','Index\RegisterController@login');
	Route::post('logindo','Index\RegisterController@logindo');
	Route::get('/reg','Index\RegisterController@register');
	Route::get('/doreg','Index\RegisterController@registerdo');
	Route::get('/email','Index\RegisterController@email');
	Route::get('/registerhandle','Index\RegisterController@registerhandle');

	
});
