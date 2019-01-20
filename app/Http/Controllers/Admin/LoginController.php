<?php

namespace App\Http\Controllers\Admin;

require_once 'resources/org/code/Code.class.php';
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class LoginController extends Controller
{
    public function login()
    {
        //测试数据库连接
        //$pdo=DB::getPdo();
        //dd($pdo);

        //插入一条记录
       // DB::table('user')->insert(['username'=>'yaksun','password'=>md5('123456')]);

        //路由设置为any
      /*  if($input=Input::all()){
            dd($input);
        }*/

      $input=Input::all();

        if(!empty($input)){

          if( strtoupper($input['code'])==strtoupper($_SESSION['code'])){
              $user=DB::table('user')->first();
                if($user->username==$input['username'] && $user->password==md5($input['password'])){

                    session(['user'=>$user]);
                    //dd(session('user'));
                    return redirect('admin/index');
                }else{
                    return back()->with('msg','用户名或密码错误');
                }

          }else{
              return back()->with('msg','验证码错误');
          }

      }


        return view('admin.login');
   }

    public function code()
    {
        $code=new \Code();
        echo $code->make();
       // $code->get();
    }

    public function quit()
    {
        session(['user'=>null]);
        return redirect('admin/login');
    }
}
