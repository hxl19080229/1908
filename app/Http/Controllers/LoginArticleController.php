<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;
class LoginArticleController extends Controller
{
    /**执行登陆 */
    public function do_login(Request $request){
        $user = $request->except('_token');
        // dd($user);
        $user['pwd'] = md5(md5($user['pwd']));
        $admin = Users::where($user)->first();
        // dd($user);
        // dd($admin);
        if($admin){
            session(['userInfo'=>$admin['admin']]);
            $request->session()->save();
            return redirect('/article');
        } 
        return redirect('/loginArticle')->with('msg','没有此用户');;
        // $user = $request->except('_token');
        // $user['pwd'] = md5(md5($user['pwd']));
        // $admin= Admin::where($user)->first();
        // dd($admin);
        // if($admin){
        //     //  用户信息存入session---防非法登陆
        //     session(['adminuser'=>$admin]);
        //     $request->session()->save();
        //     return redirect('/people');
        // }
        // // 没有登陆与错误信息 返回登陆页面
        // return redirect('/login')->with('msg','没有此用户');
    }
}
