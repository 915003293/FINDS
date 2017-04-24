<?php
/**
 * Created by PhpStorm.
 * User: Jax
 * Date: 2017/3/17
 * Time: 16:36
 */
namespace Admin\Controller;
use Think\Controller;
use Think\Think;

class UserController extends CommonController
{
    public function  Login(){

    }
    //用户
    public function User()
    {
        $UserData =  Page(D('User'),2,true);
       // $UserData = D('User')->GetUserDAta(null, 3);
        $this->assign('UserData', $UserData['Data']);
        $this->assign('Page', $UserData['Page']);
        $this->display();
    }

    public function EditUser()
    {
        $User = D('User');
        if (IS_POST) {
            $Rules = array(
                array('uid','require','用户ID必须存在!',1),
                array('uid','number','用户ID必须是数字',1),
                array('status',array(0,1),'状态值得范围不正确',0,'in'),
                array('status','number','状态值只能是数字',0),
                array('username','require','用户名必须填写',1),
            );
            if($Data = $User -> validate($Rules) -> create()){
                if($Data['password']==''){
                    unset ($Data['password']);
                }else{
                    $Data['password'] = sha1(MD5($Data['password'].'find'));
                }
                if($User -> save($Data)){
                    $this -> success("修改成功！");
                }else{
                    $this -> error("修改失败！");
                }
            }else{
                $this -> error($User -> getError());
            }
        } else {
            $Data = $User->GetUserData(I('get.Uid'));
            if (empty($Data['Data'])) {
                $this->error('木有找到这个用户！');
            }
            $Group = $User -> table('find_auth_group') -> select();
            $GroupId = $User -> GetUserGroup(I('get.Uid'),'id');
            $Gids  = null;
            foreach($GroupId as $Key => $Val){
                $Gids.= $Val['id'].',';
            }
            $Gids = substr($Gids,0,-1);
            $this->assign('UserData', $Data['Data']);
            $this->assign('Group',$Group);
            $this->assign('GroupJson',json_encode($Group));
            $this->assign('Gids',$Gids);
            $this->display();
        }
    }

    public function RemoveUserGroup(){
        $Model = M('auth_group_access');
        if(I('post.uid')==''){
            $this -> error("UID不能为空！");
        }elseif(!is_numeric(I('post.uid'))){
            $this -> error("UID只能为数值！");
        }elseif(I('post.gid')==''){
            $this -> error("GID不能为空！");
        }elseif(!is_numeric(I('post.gid'))){
            $this -> error("GID只能为数字！");
        }elseif(!$Model -> table(C('DB_PREFIX').'user') -> where(array('uid'=>I('post.uid'))) ->count()){
            $this -> error("没有这个用户！");
        }elseif($Model -> where('uid = '.I('post.uid').' and group_id = '.I('post.gid')) -> delete()){
            $this -> success('删除成功！');
        }else{
            $this -> error('删除失败');
        }
    }
    public function AddUserGroup(){
        $Model = M('auth_group_access');
        if(I('post.uid')==''){
            $this -> error("UID不能为空！");
        }elseif(!is_numeric(I('post.uid'))){
            $this -> error("UID只能为数值！");
        }elseif(I('post.gid')==''){
            $this -> error("GID不能为空！");
        }elseif(!is_numeric(I('post.gid'))){
            $this -> error("GID只能为数字！");
        }elseif(!$Model -> table(C('DB_PREFIX').'user') -> where(array('uid'=>I('post.uid'))) ->count()){
            $this -> error("没有这个用户！");
        }elseif(!$Model -> table(C('DB_PREFIX').'auth_group') -> where(array('id'=>I('post.gid'))) -> count()){
            $this -> error("没有找到这个用户组！");
        }elseif($Model -> where(array('uid'=>I('post.uid'),'group_id'=>I('post.gid'))) -> count()){
            $this -> error('这个用户已经在这个用户组里了！');
        }elseif($Model -> add(array('uid'=>I('post.uid'),'group_id'=>I('post.gid') ))){
            $this -> success('添加成功！');
        }else{
            $this -> error('添加失败！');
        }
    }
    public function AddUser()
    {
        $User = M('User');
        if (IS_POST) {
            if (!trim(I('post.username'))) {
                $this->error('账号不得为空！');
            } elseif (!trim(I('post.password'))) {
                $this->error('密码不得为空');
            } else {
                $data = $User->create();
                if (!$data) {
                    $this->error('创建数据失败!');
                } else {
                    $data['password'] = SHA1(MD5($data['password'].'find'));
                    if ($User->add($data)) {
                        $this->success('操作成功！');
                    } else {
                        $this->error('操作失败！');
                    }
                }
            }
        } else {
            $this->display();
        }
    }

    public function Handle()
    {
        $Uid = IS_POST ? IsStringNumber(I('post.Uid')) : I('get.Uid');
        $Type = IS_POST ? I('post.Type') : I('get.Type');
        if (is_numeric($Uid) or IsStringNumber($Uid) and $Type) {
            $User = D('User');
            switch ($Type) {
                case 'EditIng' :
                    $Ing = IS_POST ? I('post.Ing') : I('get.Ing');
                    if ($User->SetUserIng($Uid, $Ing)) {
                        $this->success('操作成功！');
                    } else {
                        $this->error('操作失败!');
                    }
                    break;
                case 'Remove':
                    if ($User->Remove($Uid)) {
                        $this->success('操作成功！');
                    } else {
                        $this->success('操作成功！');
                    }
                    break;
                default:
                    $this->error('不支持此操作！');
                    break;
            }
        } else {
            $this->error('参数错误!');
        }
    }

    //用户组
    public function Group()
    {
        if (IS_POST) {
        } else {
            $Group = D('Group');
            $this->assign('Group', $Group->GetGroup());
            $this->display();
        }
    }

    public function AddGroup()
    {
        if(IS_POST){
            if(!I('post.title')){
                $this -> error("请输入用户组名称");
            }else{
                if(M('auth_group') -> add(array('title'=>I('post.title')))){
                    $this -> success("增加成功！");
                }else{
                    $this -> error("增加失败！");
                }
            }
        }else{
            $this -> display();
        }
    }
    public function AllotRule(){
        if(IS_POST){
            $Group = M('auth_group');
            if(!I('post.rules')){
                $this -> error("权限id不存在！");
            }elseif(I('post.id')==''){
                $this -> error("用户组id不存在！");
            }elseif(!$rules = IsStringNumber(I('post.rules'))){
                $this -> error("权限id只能是数值");
            }elseif(!$id = is_numeric(I('post.id'))){
                $this -> error("用户组id只能是数值");
            }
            if($Group -> save(array('id'=>I('post.id'),'rules'=>implode(',',I('post.rules'))))){
                $this -> success("修改成功！");
            }else{
                $this -> success("修改失败！");
            }
        }
    }
    public function EditGroup()
    {
        $Group = M('auth_group');
        if (IS_POST) {
            $Rules = array(
                array('id','require','用户组id不存在！',1),
                array('id','number','用户组id只能是数值',1),
                array('title','require','用户组名称不能为空',1),
                array('status',array(0,1),'用户组状态值不再正常范围！',0,'in'),
            );
            if($Data = $Group -> validate($Rules) -> create(I('post.'))){
                $Data = $Group -> save($Data);
                if($Data){
                    $this -> success("编辑成功！");
                }else{
                    $this -> error("编辑失败！");
                }
            }else{
                $this -> error($Group -> getError() );
            }

        } else {
            $Rules = array(
                array('id','require','用户组id不存在！',1),
                array('id','number','用户组id只能是数值',1),
            );
            if($Data = $Group -> validate($Rules) -> create(I('get.'))){
                $Data = $Group -> where($Data) -> find();
                if($Data){
                    $auth=new \Think\Auth();
                    $RulesId = $auth->GetGroupInfo($Data['id']);
                    $RulesId = $RulesId['rules'];
                    $this -> assign('RulesId',$RulesId);
                    $this -> assign('Group',$Data);
                    $this -> assign('Rule',GetRuletree($Group -> table(C('DB_PREFIX').'auth_rule') -> select(),0,true));
                    $this->display();
                }else{
                    $this -> error("这个用户组不存在！");
                }
            }else{
                $this -> error($Group -> getError() );
            }
        }
    }

    public function EditIngGroup()
    {
        $rules = array(
            array('status', 'require', '状态值不存在!', 1),
            array('id', 'IsStringNumberEx', '用户组id必须是数字!', 1, 'function'),
            array('status', 'number', '状态值必须是数字!', 1),
            array('status', array(0, 1), '状态值范围错误!', 1, 'in'),
        );
        $Group = D('Group');
        if (IS_POST) {
            $Data = I('post.');
            $Data['id'] = implode(',', $Data['id']);
        } else {
            $Data = I('get.');
            $rules[] = array('id', 'require', '用户组id不存在!', 1);
        }
        if ($Group->validate($rules)->create($Data)) {
            if (IS_POST) {
                $Data['id'] = array('in', $Data['id']);
            }
            if ($Group->save($Data)) {
                $this->success('操作成功');
            } else {
                $this->success('操作失败');
            }
        } else {
            $this->error($Group->getError());
        }
    }

    public function RemoveGroup()
    {
        $rules = array(
            array('id', 'require', '用户组id不存在！', 1),
            array('id', 'IsStringNumberEx', '用户组id必须是数字！', 1, 'function')
        );
        if (IS_POST) {
            $Data['id'] = array('in', implode(',', I('post.id')));
        } else {
            $Data = I('get.');
        }
        $Group = D('Group');
        if ($Group->validate($rules)) {
            if ($Group->where($Data)->delete()) {
                $this->success("删除成功！");
            } else {
                $this->error('删除失败！');
            }
        } else {
            $this->error($Group->getError());
        }
    }
    //规则
    public function Rule()
    {
        $Rule = M('auth_rule');
        $Data = Page($Rule,9999,false,'orderby desc,id asc');
        $Data = $Data['Data'];
        $this -> assign('Rule',GetRuletree($Data));
        $this -> display();
    }
    public function RemoveRule(){
        $Rule = M('auth_rule');
            $rules = array(
                array('id','number','规则id必须是数字',2),
                array('id','require','规则id必需存在',1),
            );
            if($Rule -> validate($rules) -> create($_GET)){
                if($Rule -> where(array('id'=>I('get.id'))) -> delete()){
                    $this -> success("删除成功");
                }else{
                    $this -> error("删除失败");
                }
            }else{
                $this -> error($Rule -> getError());
            }
    }
    //编辑权限的状态 1启用 2禁用
    public function EditStatusRule(){
        $Rule = M('auth_rule');
        $Rules = array(
            array('id','emptyEx','节点id不存在!',1,'function'),
            array('status','emptyEx','节点状态不存在',1,'function'),
            array('id','number','节点id必须是数字',1),
            array('status','number','节点状态必须是数值',1),
            array('status',array(0,1),'节点状态不再正常范围',1,'in'),
        );
        if($Data = $Rule -> validate($Rules) -> create(I('get.'))){
            if($Rule  -> save($Data)){
                $this -> success("修改成功");
            }else{
                $this -> error("修改失败");
            }
        }else{
            $this -> error($Rule -> getError());
        }
    }
    //编辑权限
    public function EditRule(){
        $Rule = M('auth_rule');
        if(IS_POST){
            $Rules = array(
                array('id','emptyEx','权限id必须存在！',1,'function'),
                array('id','number','权限id必须是数字！',1),
                array('status','number','权限状态必须是数字',0),
                array('status',array(0,1),'权限状态的值不再正常范围！',1,'in'),
            );
            if($Data = $Rule -> validate($Rules) -> create()){
                if($Rule -> save($Data)){
                    $this -> success("编辑成功！");
                }else{
                    $this -> error("编辑失败！");
                }
            }else{
                $this -> error($Rule->getError());
            }
        }else{
            $Rules = array(
                array('id','number','规则id必须是数字',1),
            );
            if($Data = $Rule -> validate($Rules) -> create($_GET)){
                $Data = $Rule -> where($Data) -> find();
                if($Data){
                    $this -> assign("Rule",$Data);
                    $this -> display();
                }else{
                    $this-> error("这条规则不存在！");
                }
            }else{
                $this -> error($Rule -> getError());
            }
        }
    }
    public function AddRule(){
        $Rule = M('auth_rule');
        if(IS_POST){
            $Rules = array(
              array('title','require','必须填写节点名称',1),
              array('name','require','必须填写节点链接',1),
              array('pid','require','必须选择一个父节点',1),
              array('pid','number','父节点ID必须是数值',1),
              array('name','IsRule','节点链接格式不对',1,'function'),
              array('name','','这个节点已经存在了',1,'unique'),
              array('status',array(0,1),'状态值范围不正常！',2,'in'),
            );
            if(I('nav')){
                unset($Rules[1]);
                unset($Rules[4]);
                unset($Rules[5]);
                if(I('name')){
                    $_POST['name'] = '';
                }
            }
            if($Data = $Rule -> validate($Rules) -> create()){
                if($Rule -> add($Data)){
                    $this -> success("新增节点成功！");
                }else{
                    $this -> error("新增节点失败！");
                }
            }else{
                $this -> error($Rule -> getError());
            }
        }else{
            $Data = $Rule -> select();
            $this -> assign('RuleList',GetRuleSelect($Data,0));
            $this -> display();
        }
    }
}