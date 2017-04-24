<?php
/**
 * Created by PhpStorm.
 * User: Jax
 * Date: 2017/3/17
 * Time: 21:12
 */
namespace Admin\Model;
use Think\Model\RelationModel;
use Think\Think;

class UserModel extends RelationModel{
    protected $_link = array(
        'auth_group' => array(
            'mapping_type'=>self::MANY_TO_MANY,
            'foreign_key'=>'uid',
            'relation_foreign_key' => 'group_id',
            'relation_table'=>'__AUTH_GROUP_ACCESS__',
            'mapping_name' => 'group',
        )
    );
    public function GetUserData($Uid = null,$ShowNumber = null, $PageName = 'p'){
            return  $Uid ? array('Data' => $Data = $this -> where(array('uid' => $Uid)) -> find())  : Page($this,3);
    }
    public function SetUserIng($Uid = null, $Ing = null){
        if( !InIng($Ing) ){
            return false;
        }else{
            return $this -> where( is_numeric($Uid) ? array('uid'=>$Uid) : array('uid'=> array('in',$Uid)) ) -> save(array('status'=>$Ing));
        }
    }
    public function Remove($Uid = null){
            return $this -> where( is_numeric($Uid) ? array('uid'=>$Uid) : array('uid'=> array('in',$Uid)) ) -> delete();
    }
    public function  GetUserGroup($Id = null, $Field = null){
        return $this
            -> table(C('DB_PREFIX').'auth_group_access')
            -> where(array('uid'=>$Id))
            ->field($Field)
            ->join('right join '.C('DB_PREFIX').'auth_group ON '.C('DB_PREFIX').'auth_group_access.group_id = '.C('DB_PREFIX').'auth_group.id')
            -> select();
    }
}