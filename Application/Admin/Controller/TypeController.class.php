<?php
/**
 * Created by PhpStorm.
 * User: Jax
 * Date: 2017/4/7
 * Time: 15:19
 */
namespace Admin\Controller;
class TypeController extends CommonController{
    public function Type(){
        $Model = D("Type");
        if(IS_AJAX){
            if(!I('get.id')){
                $this -> error("亲，您在开玩笑吗？没有爸爸那里来的儿子！");
            }elseif(!is_numeric(I('get.id'))){
                $this -> error("这次严肃点,分类ID必须是数字！");
            }else{
                $Layer = max(I('get.layer'),0);
                $this -> assign('Layer',$Layer+1);
                $this -> assign('Type',$Model -> GetType(I('get.id')));
                $this -> assign('pid',I('get.id'));
                $this -> success($this -> fetch('SubType'));
            }
        }else{
            $Data = Page($Model,10,false,"tid asc",'pid = 0');
            $Option = $Model -> GetTypeOption();
            $Type = $Data['Data'];
            $Page = $Data['Page'];
            $this -> assign('Type',$Type);
            $this -> assign('Page',$Page);
            $this -> assign('Option',$Option);
            $this -> display();
        }
    }
    public function  RemoveType(){
        $Model = D("Type");
        if(!I('post.tid')){
            $this -> error("分类ID必须存在");
        }elseif(!is_numeric(I('post.tid'))){
            $this -> error("分类ID必须是数字");
        }
        if($Model -> TypeIsChild(I('post.tid'))){
            $this -> error("这个分类下还有子分类，所以不能删除！");
        }
        if($Model -> RemoveType(I('post.tid'))){
            $this -> success("删除成功!");
        }else{
            $this -> error("删除失败！");
        }
    }
    public function TypeAdd(){
        $Model = D("Type");
        if(IS_POST){
            $Rules = array(
                array('title','require','分类名必须存在'),
                array('pid','require','上级分类必须存在'),
                array('pid','number','上级分类ID必须是数字'),
                array('orderby','number','排序必须是数字',0),
            );
            if($Data = $Model -> validate($Rules) -> create()){
                if($Model -> add($Data)){
                    $this -> success("新增分类成功!");
                }else{
                    $this -> error("新增分类失败!");
                }
            }else{
                $this -> error($Model -> getError());
            }
        }else{
            $Option = $Model -> GetTypeOption();
            $this -> assign('Option',$Option);
            exit($this -> fetch());
        }
    }
    public function EditType(){
        $Model = D('Type');
        if(IS_POST){
            $Rules = array(
                array('tid','require','分类ID必须存在'),
                array('tid','number','分类ID必须是数字'),
                array('title','require','分类名必须存在'),
                array('pid','require','上级分类必须存在'),
                array('pid','number','上级分类ID必须是数字'),
                array('orderby','number','排序必须是数字',0),
                array('status','number','分类状态必须是数字'),
                array('status',array(0,1),'站点状态只能是开启或关闭',0,'in'),
            );
            if($Data = $Model -> validate($Rules) -> create()){
                if($Data['pid'] == $Data['tid']){
                    $this -> error(":p 父分类不能是自己");
                }
                if($Model -> save($Data)){
                    $this -> success("修改分类成功!");
                }else{
                    $this -> error("修改分类失败!");
                }
            }else{
                $this -> error($Model -> getError());
            }
        }else{
            if(I('get.id')==''){
                $this -> error('分类ID不存在');
            }else{
                if(!$TypeInfo = $Model -> GetTypeInfo(I('get.id'))){
                    $this -> error("这个分类不存在！");
                }else{
                    $Option = $Model -> GetTypeOption();
                    $this -> assign('Option',$Option);
                    $this -> assign('TypeInfo',$TypeInfo);
                    $this -> success($this -> fetch());
                }
            }

        }
    }
}