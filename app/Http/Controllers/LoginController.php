<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;
class LoginController extends Controller
{
    /**执行登陆 */
    public function logindo(Request $request){
        $user = $request->except('_token');
        $user['pwd'] = md5(md5($user['pwd']));
        $admin= Users::where($user)->first();
        // dd($admin);
        if($admin){
            //  用户信息存入session---防非法登陆
            session(['adminuser'=>$admin]);
            $request->session()->save();
            return redirect('/people');
        }
        // 没有登陆与错误信息 返回登陆页面
        return redirect('/login')->with('msg','没有此用户');
    }
}
