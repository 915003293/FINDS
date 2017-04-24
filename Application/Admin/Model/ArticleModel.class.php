<?php
/**
 * Created by PhpStorm.
 * User: Jax
 * Date: 2017/4/9
 * Time: 13:12
 */
namespace Admin\Model;
use Think\Model;
class ArticleModel extends Model\RelationModel{
    protected $_link = array(
        'type'=>array(
            'mapping_type'=> self::BELONGS_TO,
            'foreign_key' => 'tid',
            'mapping_name '=>'type',
            'mapping_fields' => 'title',
            'parent_key'=>'tid',
            'as_fields' => 'title:type_title',
        ),
        'user'=>array(
            'mapping_type'=>self::BELONGS_TO ,
            'foreign_key' => 'uid',
            'as_fields' => 'username:username',
        ),
    );
    protected $_validate = array(
        array('title','require','文章标题必须存在！',self::MUST_VALIDATE),
        array('content','require','文章内容必须存在！',self::MUST_VALIDATE),
        array('aid','number','文章ID必须是数字！',self::VALUE_VALIDATE),
        array('tid','number','分类ID必须是数字！',self::VALUE_VALIDATE),
        array('tid','require','必须选择一个分类！',self::MUST_VALIDATE),
    );
    public function GetArticleAll($orderby = null,$limit = null,$relation = null,$condition = null){
        $Data =  Page($this,$limit,$relation,$orderby,$condition);
        foreach($Data['Data'] as $key => $val){
            $Data['Data'][$key]['descript'] = getHtmlString($Data['Data'][$key]['content'],100);
//            $Data['Data'][$key]['content'] = htmlspecialchars_decode($val['content']);
        }
        return $Data;
    }
    public function GetArticleOne($Aid,$relation = 'type'){
        $data = $this -> where(array('aid'=>$Aid)) -> relation($relation) -> find();
        $data['content'] = htmlspecialchars_decode($data['content']);
        return $data;
    }
    public function RemoveArticle($Aid){
        return $this -> where(array('aid'=>$Aid)) -> delete();
    }
    public function articleAddNumber($aid){
        $this -> where(array('aid'=>$aid)) -> setInc('posts',1);
    }
}