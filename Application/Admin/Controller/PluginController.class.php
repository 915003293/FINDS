<?php
/**
 * Created by PhpStorm.
 * User: Jax
 * Date: 2017/4/1
 * Time: 21:47
 */
namespace Admin\Controller;
use Think\Controller;
class PluginController extends CommonController{
    public function Plugin(){
        $Plugin = D('Plugin');
        $PluginList = $Plugin -> GetPluginList();
        $this -> assign('PluginList',$PluginList);
        $this -> display();
    }
    public function Install(){
        if(IS_POST){
            $Config = array(
                'maxSize' => '51200',
                'replace' => true,
                'exts' => 'zip',
                'rootPath' => FILE_PACH,
            );
            $File = new \Think\Upload($Config);
            $Info = $File -> uploadOne($_FILES['file']);
            $I = 0;
            $Data = array();
            if($Info){
                /* 安装业务步骤
                 * 1.解压插件包
                 * 2.检查插件目录
                 * 3.检查是否有后台与前台访问
                 * 4.检查插件文件是否存在与命名规范性
                 * 5.检查插件install方法
                 * 6.执行插件install方法，让插件完成初始化
                 * 7.检查过滤插件内无实现的hook钩子方法
                 * 8.交集过滤掉插件与钩子表内数据
                 * 9.挂钩注册到钩子表
                 * 10.注册到插件表
                 */
                if(!$ZipHandle = zip_open(FILE_PACH.$Info['savepath'].$Info['savename'])){
                    $this -> error('打开插件失败,请检查是否有该目录的读写权限!');
                }
                $Data['sign'] = '';
                $Data['Index'] = 0;
                $Data['Admin'] = 0;
                while($FileHandle = zip_read($ZipHandle)){
                    if($I==0){
                        $Data['sign'] = substr(zip_entry_name($FileHandle),0,-1);
                        if(!$Data['sign']){
                            $this -> error("插件创建失败，获取不到插件标识");
                        }
                        if(file_exists(PLUGIN_PACH.$Data['sign'])){
                            $this -> error("插件已存在，或与其他插件名冲突，如需继续安装，请删除冲突插件！");
                        }
                        if(!mkdir(PLUGIN_PACH.$Data['sign'])){
                            $this -> error("创建插件目录失败，请检查".PLUGIN_PACH.'目录是否有读写权限!');
                        }
                        $I++;
                        continue;
                    }
                    $FileName  = substr(zip_entry_name($FileHandle),strlen($Data['sign'])+1);
                    if($FileName == 'Controller/IndexController.class.php'){
                        $Data['Index'] = true;
                    }
                    if($FileName == 'Controller/AdminController.class.php'){
                        $Data['Admin'] = true;
                    }
                    if(IsPlugin($FileName)){
                        $Data['Status'] = true;
                    }
                    if(IsDir($FileName)){
                        if(!mkdir(PLUGIN_PACH.$Data['sign'].'/'.$FileName)){
                            $this -> error("插件安装失败，创建".PLUGIN_PACH.$Data['sign'].'/'.$FileName.'目录失败，请检查目录读写权限!');
                        }
                    }else{
                        $FileContent = zip_entry_read($FileHandle,99999);
                        if(!file_put_contents(PLUGIN_PACH.$Data['sign'].'/'.$FileName,$FileContent)){
                            $this -> error("插件安装失败，创建".PLUGIN_PACH.$Data['sign'].'/'.$FileName.'文件失败，请检查目录读写权限!');
                        }
                    }
                    zip_entry_close($FileHandle);
                }
                zip_close($ZipHandle);
//                if(!Unzip(FILE_PACH.$Info['savepath'].$Info['savename'],PLUGIN_PACH,$ErrorCode)){
//                    switch($ErrorCode){
//                        case 10001:
//                            $this -> error("解压插件目录时出错!");
//                            break;
//                        case 10002:
//                            $this -> error("解压插件文件时出错!");
//                            break;
//                        default:
//                            $this -> error("未知错误!");
//                    }
//                }
                if($Data['Status']){
                    $ClassName =  GetPluginClassName($Data['sign']);
                    $Plugin = new $ClassName;
                    $Model = D("Plugin");
                    if(!method_exists($Plugin,'Install')){
                        CleanPlugin($Data['sign']);
                        $this -> error("插件没有Install方法");
                    }
                    if(!$Plugin -> Install()){
                        CleanPlugin($Data['sign']);
                        $this -> error("插件执行Install方法失败!");
                    }
                    $Hook = $Plugin -> Info['hook'];
                    if(!$Hook = CheckPluginHook($Hook,$Data['sign'])){
                        CleanPlugin($Data['sign']);
                        $this -> error("插件至少需要挂一个钩子！");
                    }
                    if(!$Model -> RegHook($Hook,$Data['sign'])){
                        CleanPlugin($Data['sign']);
                        $this -> error("注册钩子失败...!");
                    }
                    if(!$Model -> RegPlugin($Data['sign'],$Data['Admin'],$Data['Index'])){
                        $this -> error("注册插件到插件表失败!");
                    }else{
                        $this -> success("恭喜插件安装成功！");
                    }
                }else{
                    CleanPlugin($Data['sign']);
                    $this -> error("插件安装失败，插件找不到插件文件，请注意插件首字母大写!");
                }
            }else{
                $this -> error($File -> getError());
            }
        }else{
            $this -> display();
        }
    }
    public function RemovePlugin(){
        $Plugin = D('Plugin');
        $PluginId = IS_POST ? I('get.id') : I('get.id');
        if(!$PluginId){
            $this -> error('插件ID不存在!');
        }
        if(IS_POST){
            if(!IsStringNumber($PluginId)){
                $this -> error("插件ID不是数字!");
            }
        }else{
            if(!is_numeric($PluginId)){
                $this -> error("插件ID不是数字!");
            }
        }
        if(!$Sign = $Plugin -> GetPluginInfo($PluginId)){
            $this -> error("从插件表中找不到该插件！");
        }
        $ClassName = GetPluginClassName($Sign);
        $Object = new $ClassName;
        if(!$Object -> UnLoad()){
            $this -> error("执行插件内的Unload方法失败！");
        }
       if(!$Plugin -> RemoveHookPlugin($Sign)){
            $this -> error("在hook表，卸载钩子失败！");
       }
       if($Plugin -> RemovePlugin($PluginId)){
            CleanPlugin($Sign);
            $this -> success('删除成功！');
       }else{
            $this -> error('删除失败！');
       }
    }
    public function SetStatus(){
        $Plugin = D('Plugin');
        $Rules = array(
            array('id','require','插件ID必须存在!',1),
            array('id','number','插件ID必须是数字!',1),
            array('status',array(0,1),'状态值范围异常!',1,'in'),
        );
        if($Data = $Plugin -> validate($Rules) -> create(I('get.'))){
            if($Plugin -> SetStatus($Data)){
                $this -> success('操作成功！');
            }else{
                $this -> error('操作失败！');
            }
        }else{
            $this -> error($Plugin -> getError());
        }

    }
    public function Hook(){
        $Plugin = D('Plugin');
        $HookList = $Plugin -> GetHookList();
        $this -> assign('HookList',$HookList);
        $this -> display();
    }
}