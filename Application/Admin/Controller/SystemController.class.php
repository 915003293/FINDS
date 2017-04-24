<?php
/**
 * Created by PhpStorm.
 * User: Jax
 * Date: 2017/3/28
 * Time: 14:01
 */
namespace Admin\Controller;
use Think\Controller;
class SystemController extends CommonController{
    public function Index(){
        $this -> display();
    }
    public function EditSiteBaseInfo(){
        $Config = D('Config');
        if(!I('title')){
            $this -> error("站点名称必须填写");
        }elseif(!I('key_word')){
            $this -> error("站点关键字必须填写");
        }elseif(!I('description')){
            $this -> error("站点描述必须填写");
        }elseif(!I('bottom_info')){
            $this -> error("底部信息必须填写");
        }
        $Data = array(
            'title'=>I('title'),
            'key_word'=>I('key_word'),
            'description'=>I('description'),
            'bottom_info'=>I('bottom_info'),
        );
        if(isset($_POST['access'])){
            $Data['access'] = 1;
        }else{
            $Data['access'] = 0;
        }
        if(I('count_code')){
            $Data['count_code'] = I('count_code');
        }

        if($Config -> WriteConfig('Site',$Data)){
            $this -> success("修改成功！");
        }else{
            $this -> error("修改失败");
        }
    }
    public function Site(){
        $Config = D('Config');
        $this -> assign('SiteInfo',$Config -> ReadConfig('Site'));
        $this -> display();
    }
}