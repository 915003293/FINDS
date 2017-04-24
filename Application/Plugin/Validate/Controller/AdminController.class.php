<?php
/**
 * Created by PhpStorm.
 * User: Jax
 * Date: 2017/4/1
 * Time: 20:58
 */
namespace Plugin\Validate\Controller;
class AdminController extends \Admin\Controller\CommonController{
    public function Index(){
        $Json = json_decode(ReadPluginConfig('Validate'),JSON_OBJECT_AS_ARRAY);
        if(IS_POST){
            $Config = array('id'=>I('post.id'),'key'=>I('post.key'));
            if($Json == $Config){
                $this -> error("没有进行任何修改！");
            }
            if(!WritePluginConfig('Validate',$Config)){
                $this -> error("修改配置失败!");
            }else{
                $this -> success("修改配置成功!");
            }
        }else{
            $this -> assign('Validate',$Json);
            $this -> display(PLUGIN_PACH.'Validate/View/Admin/Index.html');
        }
    }
}