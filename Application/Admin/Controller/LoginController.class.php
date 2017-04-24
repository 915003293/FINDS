<?php
/**
 * Created by PhpStorm.
 * User: Jax
 * Date: 2017/3/24
 * Time: 16:45
 */
namespace Admin\Controller;
use Think\Controller;
class LoginController extends CommonController {
    public function Login(){
        if(IsLogin()){
            $this -> error('请不要重复登录！',U('Admin/System/Index'));
        }else{
            if(IS_POST){
                tag("Login");
                $User = M('user');
                $Rules = array(
                    array('username','require','账号必须填写',1),
                    array('password','require','账号必须填写',1),
                );
                if($Data = $User -> validate($Rules) -> create()){
                    $Data['password'] = SHA1(MD5($Data['password'].'find'));
                    if($User -> where($Data) -> find()){
                        session('uid',$User -> uid);
                        session('username',$User -> username);
                        $this -> success("登陆成功",U('Admin/System/Index'));
                    }else{
                        $this -> error("账号或密码错误!");
                    }
                }else{
                    $this -> error($User -> getError());
                }
            }else{
                $this -> display();
            }
        }
    }
    public function OutLogin(){
        session('uid',null);
        $this -> success('注销成功！',U('Admin/Login/Login'));
    }
}