<?php
/**
 * Created by PhpStorm.
 * User: Jax
 * Date: 2017/4/19
 * Time: 16:45
 */
namespace Home\Model;
use Think\Model;
class NavModel extends Model{
    public function getNav(){
        return $this  -> select();
    }
}