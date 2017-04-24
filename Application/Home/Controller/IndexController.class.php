<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
        $article = D('Admin/Article')->GetArticleAll('posts desc',5,'user');
        $this -> assign('article',$article);
        $this  -> display();
    }
    public function article(){
        $Model = D('Admin/Article');
        $article = $Model -> GetArticleOne(I('aid'),'user');
        if(!$article){$this -> error("这篇文章不存在!");}
        $Model -> articleAddNumber(I('aid'));
        $this -> assign("article",$article);
        $this -> display();
    }
    public function showClassify(){
        $Model = D('Admin/Article');
        $articleId = is_numeric(I('get.tid'))  ? max(1,I('get.tid')) : max(1,I('get.tid'));
        $article = $Model ->GetArticleAll(null,5,'user',"tid={$articleId}");
        $this -> assign("article",$article);
        $this -> display();
    }
}