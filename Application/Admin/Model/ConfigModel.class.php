<?php
/**
 * Created by PhpStorm.
 * User: Jax
 * Date: 2017/4/8
 * Time: 14:32
 */
namespace Admin\Model;
use Think\Model;
class ConfigModel extends Model{
    public function ReadConfig($Name){
        $Config = $this -> where(array('name'=>$Name)) -> find();
        $Config = $Config['config'];
        return json_decode($Config,JSON_OBJECT_AS_ARRAY);
    }
    public function WriteConfig($Name,$Data){
        $Config = $this -> ReadConfig($Name);
        if($Config != $Data ){
            return $this -> where(array('name'=>$Name)) -> save(array('config'=>json_encode($Data)));
        }else{
            return false;
        }
    }
}