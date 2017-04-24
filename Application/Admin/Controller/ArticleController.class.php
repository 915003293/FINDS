<?php
/**
 * Created by PhpStorm.
 * User: Jax
 * Date: 2017/4/10
 * Time: 22:09
 */
namespace Admin\Controller;
use Think\Controller;
class ArticleController extends CommonController{
    public function Article(){
        $Model = D('Article');
        $Article = $Model -> GetArticleAll(null,null,'type');
        $Page = $Article['Page'];
        $Article = $Article['Data'];
        foreach($Article as $Key => $Val){
            $Article[$Key]['content'] = htmlspecialchars_decode($Val['content']);
        }
        $this -> assign('Article',$Article);
        $this -> assign('Page',$Page);
        $this -> display();
    }
    public function AddArticle(){
        if(IS_POST){
            $Model = D('Article');
            if($data = $Model -> create()){
                $data['create_time'] = time();
                $data['uid'] = session('uid');
                if($Model -> add($data)){
                    $this -> success("发布文章成功!");
                }else{
                    $this -> error("发布文章失败!");
                }
            }else{
                $this -> error($Model->getError());
            }

        }else{
            if(!$Option = D('Type') -> GetTypeOption()){
                $this -> error('糟糕,获取分类失败!');
            }
            $this -> assign('Option',$Option);
            $this -> display();
        }
    }
    public function RemoveArticle(){
        if(!I('get.aid') or !is_numeric(I('get.aid'))){
            $this -> error("这篇文章不存在!");
        }elseif(D('Article')->RemoveArticle(I('get.aid'))){
            $this -> success("文章删除成功！");
        }else{
            $this -> error("删除文章失败");
        }
    }
    public function EditArticle(){
        $Model = D('Article');
        if(IS_POST){
            if($Data = $Model -> create()){
                if(!I('post.aid')){
                    $this -> error("这篇文章不存在！");
                }elseif(!$Model ->GetArticleOne(I('post.aid'))){
                    $this -> error("这篇文章不存在！");
                }
                if($Model -> save($Data)){
                    $this -> success("编辑文章成功!");
                }else{
                    $this -> error("编辑文章失败!");
                }
            }else{
                $this -> error($Model -> getError());
            }
        }else{
            if(!I('get.aid') or !is_numeric(I('get.aid'))){
                $this -> error('這篇文章不存在！');
            }elseif(!$Article = $Model ->GetArticleOne(I('get.aid'))){
                $this -> error('這篇文章不存在！');
            }elseif(!$Option = D('Type') -> GetTypeOption()){
                $this -> error('糟糕,获取分类失败!');
            }
            $this -> assign('Article',$Article);
            $this -> assign('Option',$Option);
            $this -> display();
        }
    }


}