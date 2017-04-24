<?php
/**
 * Created by PhpStorm.
 * User: Jax
 * Date: 2017/3/20
 * Time: 13:14
 */
namespace Admin\Model;
use Think\Model;
class GroupModel extends Model{
    protected $tableName = 'auth_group';
    public function GetGroup( $Gid = null){
        return $Gid ? $this -> where(array('gid'=>$Gid)) -> find() : Page($this);
    }

}