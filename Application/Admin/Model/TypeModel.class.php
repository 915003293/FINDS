<?php
/**
 * Created by PhpStorm.
 * User: Jax
 * Date: 2017/4/9
 * Time: 13:12
 */
namespace Admin\Model;
use Think\Model;
class TypeModel extends Model{
    public function GetType($Pid = 0,$Tid = null){
        if($Tid){
            return $this ->  where(array('tid'=> $Tid)) -> select();
        }else{
            return $this ->  where(array('pid'=> $Pid)) -> select();
        }
    }
    public function RemoveType($Tid){
        return $this -> where(array('tid'=>$Tid)) -> delete();
    }
    public function TypeIsChild($Tid){
        return $this -> where(array('pid'=>$Tid)) -> find();
    }
    public function GetTypeOption($Pid = 0,$Layer = 0){
        $Type = $this  -> select();
        $Result = '';
        foreach($Type as $Key => $Val){
            if($Val['pid'] == $Pid){
                $String = str_repeat("|--",$Layer*2);
                $Result .= '<option value='.$Val['tid'].' >'.$String.$Val['title'].'</option>';
                $Result .= self::GetTypeOption($Val['tid'],$Layer+1);
            }
        }
        return $Result;
    }
    public function GetTypeInfo($Tid){
        return $this -> where(array('tid'=>$Tid)) -> find();
    }


}