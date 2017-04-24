<?php
/**
 * Created by PhpStorm.
 * User: Jax
 * Date: 2017/3/24
 * Time: 15:30
 */
namespace Admin\Controller;
use Think\Controller;
use Think\Hook;
class CommonController extends Controller{
    public function __construct(){
        parent::__construct();
        $this -> LoadPlugman();
        $this -> AuthCheck();
    }
    public function AuthCheck(){
        $Auth =  new \Think\Auth;
        if(IsLogin()){
            if(session('uid')==1){
                $NavData  = M('auth_rule') -> order('orderby desc,id asc') -> select();
            }else{
                if(CONTROLLER_PATH){
                    if(!$Auth -> check(MODULE_NAME .'/'.CONTROLLER_NAME.'/'.ACTION_NAME.'/'.C('VAR_ADDON').'/'.CONTROLLER_PATH,session('uid'))){
                        $this -> error("您当前所在的用户组没有这个权限！");
                    }
                }else{
                    if(!CONTROLLER_NAME == 'Login'){
                        if(!$Auth -> check(MODULE_NAME .'/'.CONTROLLER_NAME.'/'.ACTION_NAME,session('uid'))){
                            $this -> error("您当前所在的用户组没有这个权限！");
                        }
                    }
                }
                $Rid = $Auth -> getGroups(session('uid'));
                if(!$Rid){
                    session('uid',null);
                    $this -> error("请先为这个账号添加一个用户组!",U('Admin/Login/Login'));
                }else{
                    $Rid = $Rid[0]['rules'];
                    $NavData  = M('auth_rule') -> order('orderby desc,id asc') -> where(array('id'=>array('in',$Rid))) -> select();
                }
            }
            $this -> assign("Nav",GetNavList($NavData));
            $this->GetPostion($NavData);
        }else{
            if(CONTROLLER_NAME != 'Login'){
                $this -> error("请先登录！",U('Admin/Login/Login'));
            }
        }
    }
    public function LoadPlugman(){
        $Plugin = D('Plugin');
        $Plugin -> LoadHook();
    }
    public function GetPostion($NavData = null){
        if(CONTROLLER_PATH){
            $Postion = GetNowPostion($NavData,ArraySearch($NavData,'name',MODULE_NAME .'/'.CONTROLLER_NAME.'/'.ACTION_NAME.'/'.C('VAR_ADDON').'/'.CONTROLLER_PATH));
        }else{
            $Postion = GetNowPostion($NavData,ArraySearch($NavData,'name',MODULE_NAME .'/'.CONTROLLER_NAME.'/'.ACTION_NAME));
        }
        $Postion = substr($Postion,0,-1);
        $Postion = explode('|',$Postion);
        $Postion = array_reverse($Postion);
        $Postion = implode('&nbsp;/&nbsp;',$Postion);
        $this -> assign("Postion",$Postion);
    }

}