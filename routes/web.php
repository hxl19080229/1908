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
// 闭包路由
// Route::get('/', function () {
//     $name = '1908 欢迎你';
//     return view('welcome',['name'=>$name]);
// });
// 路由显示视图---不走控制器,直接走视图模板--(直接走方法)
Route::get('/show', function () {
    echo "hello word";
});
Route::view('/adduser', 'user.add');
// 里面还可以写第三个参数
Route::view('/adduser', 'user.add',['aa'=>'蓝天']);
// 路由显示视图----走的控制器
Route::get('/user', 'UserController@index');
// Route::get('/adduser', 'UserController@add');//一样的 Route::view('/adduser', 'user.add');
Route::post('/adddo', 'UserController@add');
// 必填
// Route::get('/goods/{id}', function($goods_id){
//     echo $goods_id;
// });
Route::get('/goods/{id}/{name}', function($goods_id,$name){
    echo $goods_id;
    echo $name;
});
// 可选
// Route::get('/goods/{id?}', function($goods_id=null){
//     echo "白云";
//     echo $goods_id;
// });

// 正则约束
// Route::get('/goods/{id}', function($goods_id){
//     echo "商品ID:";
//     echo $goods_id;
// });
Route::get('/show/{id}', function($goods_id){
    echo "ID:";
    echo $goods_id;
});
// Route::get('/goods/{id}/{name}', function($goods_id,$name){
//     echo "商品ID:";
//     echo $goods_id;
//     echo "商品名称";
//     echo $name;
// })->where(['name'=>'\w+']);

//周测
Route::view('/create', 'create.index');
Route::get('/create/indexss','CreateController@indexss');
Route::get('/create/create','CreateController@create');
Route::post('/create/store','CreateController@store');
// 外来务工人员统计
// 路由分组 prefix-前缀   group-分组->middleware('checklogin')
Route::prefix('people')->group(function(){
    Route::get('create','PeopleController@create');
    Route::post('store','PeopleController@store');
    Route::get('/','PeopleController@index');
    Route::get('edit/{id}','PeopleController@edit');
    Route::post('update/{id}','PeopleController@update');
    Route::get('destroy/{id}','PeopleController@destroy');
});
//登陆界面
// Route::view('/login', 'login');
// //执行界面
// Route::post('logindo','LoginController@logindo');
// Route::view('/login_publiclogin_public', 'login_public.login_public');

// 学生表
// 路由分组 prefix-前缀   group-分组
// Route::prefix('student')->group(function(){
    Route::get('/student/create','StudentController@create');
    Route::post('student/store','StudentController@store');
    Route::get('/student','StudentController@index');
    Route::get('/student/edit/{id}','StudentController@edit');
    Route::post('/student/update/{id}','StudentController@update');
    Route::get('/student/destroy/{id}','StudentController@destroy');
    
// });

// 品牌表
// 路由分组 prefix-前缀   group-分组
Route::prefix('brand')->group(function(){
    Route::get('create','BrandController@create');
    Route::post('store','BrandController@store');
    Route::get('/','BrandController@index');
    Route::get('edit/{id}','BrandController@edit');
    Route::post('update/{id}','BrandController@update');
    Route::get('destroy/{id}','BrandController@destroy');
});
Route::get('/newss','NewssController@index');
// 文章  ->middleware('checklogin')
Route::prefix('article')->group(function(){
    Route::get('create','ArticleController@create');
    Route::post('store','ArticleController@store');
    Route::get('/','ArticleController@index');
    Route::get('edit/{id}','ArticleController@edit');
    Route::post('update/{id}','ArticleController@update');
    Route::get('destroy/{id}','ArticleController@destroy');
    Route::post('checkOnly','ArticleController@checkOnly');
});
// 设置cookie
Route::get('/article/setCookie','ArticleController@setCookie');
//登陆界面
// Route::view('/loginArticle', 'loginArticle');
//执行界面
// Route::post('do_login','LoginArticleController@do_login');

// 分类表
Route::prefix('cate')->group(function(){
    Route::get('create','CateController@create');
    Route::post('store','CateController@store');
    Route::get('/','CateController@index');
    Route::get('edit/{id}','CateController@edit');
    Route::post('update/{id}','CateController@update');
    Route::get('destroy/{id}','CateController@destroy');
    Route::post('checkOnly','CateController@checkOnly');
});
// 商品表
Route::prefix('goods')->group(function(){
    Route::get('create','GoodsController@create');
    Route::post('store','GoodsController@store');
    Route::get('/','GoodsController@index');
    Route::get('edit/{id}','GoodsController@edit');
    Route::post('update/{id}','GoodsController@update');
    Route::get('destroy/{id}','GoodsController@destroy');
    Route::post('checkOnly','GoodsController@checkOnly');
});
// 管理员表
Route::prefix('admin')->group(function(){
    Route::get('create','AdminController@create');
    Route::post('store','AdminController@store');
    Route::get('/','AdminController@index');
    Route::get('edit/{id}','AdminController@edit');
    Route::post('update/{id}','AdminController@update');
    Route::get('destroy/{id}','AdminController@destroy');
    Route::post('checkOnly','AdminController@checkOnly');
});
// 前台模块
//前台登陆界面
Route::view('/login', 'index.login');
//执行登陆界面
Route::post('logindo','Index\LoginController@logindo');
//前台注册界面
Route::get('/reg', 'Index\LoginController@reg');
//执行登陆界面
Route::post('regdo','Index\LoginController@regdo');
// 发送短息
// Route::get('/send', 'Index\LoginController@reg');
// Route::get('/test', 'Index\LoginController@test');
// 前台首页
Route::get('/', 'Index\IndexController@index');
// 商品列表页proinfo
// Route::get('/prolist','Index\ProlistController@index');
Route::get('/prolist', 'Index\ProlistController@prolist');
Route::get('/proinfo', 'Index\ProlistController@proinfo');
