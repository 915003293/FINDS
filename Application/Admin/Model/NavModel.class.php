<?php
/**
 * Created by PhpStorm.
 * User: Jax
 * Date: 2017/4/12
 * Time: 16:31
 */
namespace Admin\Model;
use Think\Model;
class NavModel extends Model{
    public function GetNavList($Nid,$Order){
        if($Nid){
            return $this -> order('orderby '.$Order) -> where(array('nid'=>$Nid)) -> find();
        }else{
            return $this -> order('orderby '.$Order) -> select();
        }
    }
}