<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shop_user;
use App\Admin;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
class LoginController extends Controller
{
    /**执行登陆 */
    public function logindo(Request $request){
        $request->validate([
            'phone'=>'required',
            'pwd'=>'required',
        ],[
            'phone.required'=>'账号必填',
            'pwd.required'=>'密码必填',
        ]);
        $post = $request->except('_token');
        // $post['pwd'] = enctypt($user['pwd']);
        // dump($post);
        $user= Shop_user::where(['phone'=>$post['phone']])->first();
        // echo decrypt($user->pwd);die;
        // echo $user->account;die;
        // dd($user);
        if($post['phone']!=$user['phone']){
            return redirect('/login')->with('msg','没有此用户或密码错误');
        }
        if($post['pwd']!=decrypt($user->pwd)){
            return redirect('/login')->with('msg','没有此用户或密码错误');
        }
        // dd($user->phone);
        // dd($user->pwd);
       
        session(['userInfo'=>$user]);
        request()->session()->save();
        return redirect('/my_user');
        // 没有登陆与错误信息 返回登陆页面
        // return redirect('/login')->with('msg','没有此用户');
    }

    // 注册reg
    public function reg(){

        return view('index.reg');
    }
    // 注册reg
    public function regdo(){

        return view('index.reg');
    }









    // // 发送短息
    // public function ajaxsned(){
    //     $phone = request()->mobile;
    //     $code = rand(100000,999999);
    //     $res = $this->sendSms($phone,$code);
    //     if($res['Code']=='OK'){
    //         session(['code'=>$code]);
    //         request()->session()->save();
    //         echo json_encode(['code'=>'00000','msg'=>'ok']);die;
    //     }
    //     echo json_encode(['code'=>'00001','msg'=>'短息发送失败']);die;    
    // }
    // public function sendSms($phone,$code){
    //     AlibabaCloud::accessKeyClient('LTAI4Fby4bjbcsxvyaX9NFgE', '49eTCx8NowI5TjGZjJDI6amjUn8J79')
    //                 ->regionId('cn-hangzhou')
    //                 ->asDefaultClient();
    //     try {
    //         $result = AlibabaCloud::rpc()
    //                 ->product('Dysmsapi')
    //                 // ->scheme('https') // https | http
    //                 ->version('2017-05-25')
    //                 ->action('SendSms')
    //                 ->method('POST')
    //                 ->host('dysmsapi.aliyuncs.com')
    //                 ->options([
    //                     'query' => [
    //                         'RegionId' => "cn-hangzhou",
    //                         'PhoneNumbers' => $phone,
    //                         'SignName' => "万汇地产",
    //                         'TemplateCode' => "SMS_181190800",
    //                         'TemplateParam' => "{code:$code}",
    //                     ],
    //                 ])
    //                 ->request();
    //         return $result->toArray();
    //     } 
    //     catch (ClientException $e){
    //         return $e->getErrorMessage();
    //     } 
    //     catch (ServerException $e){
    //         return $e->getErrorMessage();
    //     }
    // }


    
}
