<?php
/**
 * Created by PhpStorm.
 * User: Jax
 * Date: 2017/4/1
 * Time: 22:00
 */
namespace Admin\Model;
use Think\Crypt\Driver\Think;
use Think\Model;
class PluginModel extends Model{
    //获取插件列表
    public function GetPluginList(){
        $PluginFile = glob(PLUGIN_PACH.'*',GLOB_ONLYDIR);
        if($PluginFile == false or !file_exists(PLUGIN_PACH)){
            return false;
        }
        $PluginFile = array_map('basename',$PluginFile);
        $PluginList = $this -> where(array('sign'=> array('in',$PluginFile))) -> select();
        unset($PluginFile);
        foreach($PluginList as $Key => $Val){
            $ClassName = GetPluginClassName($Val['sign']);
            if(!class_exists($ClassName)){
                if(!file_exists(PLUGIN_PACH.$Val['sign'].'/'.$Val['sign'].'Plugin.class.php')){
                    //插件文件不存在,后续将添加日志系统!
                    continue;
                }
            }
            $Object = new $ClassName;
            if(!empty($Object -> Info) and is_array($Object -> Info)){
                 $Object -> Info['id'] = $Val['id'] ;
                 $Object -> Info['access'] = $Val['access'] ;
                 $Object -> Info['admin'] = $Val['admin'] ;
                 $Object -> Info['status'] = $Val['status'] ;
                 $PluginList[$Key] = $Object -> Info;
            }
        }
        return $PluginList;
    }
    //注册钩子
    public function LoadHook(){
       $Hook =  $this -> table(C('DB_PREFIX').'hook') -> getField('name,plugin');
       foreach($Hook as $Key => $Val){
           //获取挂了钩的插件
           $Names = explode(',',$Val);
           //过滤下已关闭的插件
           $Data = $this -> where('status = 1') -> getField('id,sign');
           //交集去掉不存在的插件!
           $Data = array_intersect($Names,$Data);
            foreach($Data as $Plugin){
                if(file_exists(PLUGIN_PACH.$Plugin.'/'.$Plugin.'Plugin.class.php')){
                    \Think\Hook::add($Key,GetPluginClassName($Plugin));
                }
            }
       }
    }
    //为新安装的插件注册钩子到数据库
    public function RegHook($Hook,$Sign){
        if(!$Hook or !is_array($Hook)){return false;}
        $Hook = $this -> table(C('DB_PREFIX').'hook') -> where(array('name'=>array('in',$Hook))) -> select();
        if(!$Hook){return false;}
        foreach($Hook as $Key => $Val){
            $this -> execute("update " .C('DB_PREFIX')."hook"." set `plugin` = '".($Val['plugin'] ? "{$Val['plugin']}," : '' ).$Sign."' where(name = '{$Val['name']}') ;" );
        }
        return true;
    }
    //为新装插件注册到插件表
    public function RegPlugin($Sign,$Admin,$Access = 0){
        return $this -> add(array('sign'=>$Sign,'status'=>0,'admin'=>$Admin,'access'=>$Access));
    }
    //获取钩子列表
    public function GetHookList($Data){
        if($Data){
            return $this -> table(C('DB_PREFIX').'hook') -> where($Data) -> select();
        }else{
            return $this -> table(C('DB_PREFIX').'hook') -> select();
        }
    }
    //移除插件
    public function RemovePlugin($PluginId){
        return $this -> delete($PluginId);
    }
    //通过插件ID获取插件标识
    public function GetPluginInfo($PluginId){
        $Sign =  $this -> where("id = {$PluginId}") -> find();
        return $Sign['sign'];
    }
    //移除HOOK表注册
    public function RemoveHookPlugin($Sign){
       $HookList =  $this -> table(C('DB_PREFIX').'hook') -> getField('name,plugin');
       if(!$HookList){return true;}
       foreach($HookList as $Key => $Val){
            $Plugin = str_replace($Sign,'',$Val);
           if(!str_replace(',','',$Plugin)){
               $Sql .= "UPDATE ".C('DB_PREFIX').'hook'."  SET `plugin` = '' WHERE(name = '{$Key}');";
           }else{
               $Plugin = explode(",",$Plugin);
                foreach($Plugin as $Key2 => $Val2){
                    if(!$Val2){
                        unset($Plugin[$Key2]);
                    }
                }
               $Plugin = implode(",",$Plugin);
               $Sql .= "UPDATE ".C('DB_PREFIX').'hook'."  SET `plugin` = '".$Plugin."' WHERE(name = '{$Key}') ;";
           }
       }
       if($this -> execute($Sql)!== false){
            return true;
       }else{
           return false;
       }
    }
    //启用禁用插件
    public function SetStatus($Data){
        return $this -> save($Data);
    }
}