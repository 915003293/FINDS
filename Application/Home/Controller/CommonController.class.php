<?php
/**
 * Created by PhpStorm.
 * User: Jax
 * Date: 2017/4/19
 * Time: 16:44
 */
 namespace Home\Controller;
 use Think\Controller;
 class CommonController extends Controller{
    public function __construct(){
        parent::__construct();
        $this -> initTemplet();
        $this -> initSite();
        $this -> initNav();
    }
    public function initTemplet(){
        C('DEFAULT_THEME','test');
    }
    public function initSite(){
        $Model = D('Admin/Config');
        $SiteInfo = $Model -> ReadConfig('Site');
        if($SiteInfo['access']==0){
            $this -> error("很抱歉,网站关闭中!");
        }
        $this -> assign('Site',$SiteInfo);
    }
    public function initNav(){
        $navList = D('nav') -> getNav();
        foreach($navList as $key => $val){
            $stringArr = explode("/",$val['link']);
            if(count($stringArr)>=3){
                $stringArr = $stringArr[0].'/'.$stringArr[1].'/'.$stringArr[2];
            }
            if($stringArr == MODULE_NAME .'/'.CONTROLLER_NAME.'/'.ACTION_NAME){
                $navList[$key]['selected'] = true;
            }
        }
        $this -> assign('nav',$navList);
    }
 }