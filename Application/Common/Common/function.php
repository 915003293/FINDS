<?php
/**
 * Created by PhpStorm.
 * User: 封建
 * Date: 2017/3/17
 * Time: 22:07
 */

////////////////////常规验证
//文章是否有配图
function isImg($string = null){
    if(preg_match("/<img.*>/",$string,$tmpString)){
        return $tmpString[0];
    }else{
        return false;
    }
}
//获取字符串内的src地址
function getSrc($string = null){
    if(preg_match("/src=\"(.*)\"/",$string,$tmpString)){
        return $tmpString[1];
    }else{
        return false;
    }
}
//截取html代码中的字符串
function getHtmlString($html = null,$lenght = 0){
    $string = strip_tags(htmlspecialchars_decode($html));
    $string = preg_replace("/&[a-z A-Z]+;/",'',$string);
    $string = preg_replace("/[\r \n \t]/",'',$string);
    $option  = mb_strlen($html) > $lenght ? '......':'';
    return mb_substr($string,0,$lenght,'utf-8').$option;
}
//是否是目录
function IsDir($String = null){
    if(substr_count($String,'.')==0){
        return true;
    }else{
        return false;
    }
}
//是否是1,2,3,4这种只带逗号的数字
function IsStringNumber($String = null){
    if(!$String){ return false; }
    if(is_array($String)){ $String = implode(',',$String); }
    $Tmp = str_ireplace(',','',$String);
    return  is_numeric($Tmp) ? $String : false ;
}
////////////////////常规验证

///////////////////文件操作
//移除目录下的所有文件
function RemoveDirAllFile($Pach = null){
    $FileList = glob($Pach.'/*');
    foreach($FileList as $Key => $Val){
        if(is_dir($Val)){
            RemoveDirAllFile($Val);
            rmdir($Val);
        }else{
            unlink($Val);
        }
    }
}
//解压zip文件
function Unzip($FilePach = null, $UnPach = null ,&$ErrorCode = null){
    if(!$ZipHandle = zip_open($FilePach)){
        $ErrorMsg = '1000';
        return false;
    }
    while($FileHandle = zip_read($ZipHandle)){
        $FileName  =zip_entry_name($FileHandle);
        if(IsDir($FileName)){
            if(!mkdir($UnPach.'/'.$FileName)){
                $ErrorCode = 10001;
                return false;
            }
        }else{
            $FileContent = zip_entry_read($FileHandle,99999999);
            if(!file_put_contents($UnPach.'/'.$FileName,$FileContent)){
                $ErrorCode = 10002;
                return false;
            }
        }
        zip_entry_close($FileHandle);
    }
    zip_close($ZipHandle);
    return true;
}
function writeConfig($name = null,$data = array()){
    if(!$data or !is_array($data)){
        return false;
    }
    $content = "<?php\r\n";
    $content .= "\treturn array(\r\n";
    foreach($data as $key => $val){
        if($val){
           $content .="\t\t'{$key}' => '{$val}',\r\n";
        }
    }
    $content .= "\t);";
    return file_put_contents($name,$content);
}
///////////////////文件操作

//////////////////插件操作
//清理安装失败的插件
function CleanPlugin($Sign = null){
    if(!$Sign){return false;}
    $Pach = GetPluginPach($Sign);
    RemoveDirAllFile($Pach);
    if(rmdir($Pach)){
        return true;
    }else{
        return false;
    }
}
//获取插件类名
function GetPluginClassName($Name){
    return "Plugin\\{$Name}\\{$Name}Plugin";
}
//获取插件的扩展类名
//sign 插件标识
//name 扩展类名
function GetPluginExtendLibClassName($Sign,$Name){
    return "Plugin\\{$Sign}\\Lib\\{$Name}";
}
//获取插件路径
function GetPluginPach($Sign){
    return PLUGIN_PACH .$Sign.'/';
}
//检测是否是插件文件
function IsPlugin($String = null){
    return preg_match("/^[A-Z]+[a-z]*Plugin.class.php$/",$String);
}
//检查过滤掉插件内无实现方法的钩子
function CheckPluginHook($Hook = array(),$Sign = null){
    if($Sign == null or $Hook == null or !is_array($Hook)){
        return false;
    }
    $ClassName = GetPluginClassName($Sign);
    if(!$ClassName){
        return false;
    }
    $Object = new $ClassName;
    foreach($Hook as $Key => $Val){
        if(!method_exists($Object,$Val)){
            unset($Hook[$Key]);
        }
    }
    return $Hook;
}
//注册节点
function RegRule($RuleName,$RuleLink){
    $RuleName = addslashes($RuleName);
    $RuleLink = addslashes($RuleLink);
    if(!$RuleLink or !$RuleLink){
        return false;
    }
    if(!IsRule($RuleLink)){
        return false;
    }
    $Sql = "SELECT * FROM ".C('DB_PREFIX')."auth_rule WHERE(`name` = '{$RuleLink}')";
    if($Info = M()->query($Sql)){
        return false;
    }
    $Sql = "SELECT * FROM ".C('DB_PREFIX')."auth_rule WHERE(`title` = '插件后台')";
    if(!$Info = M()->query($Sql)){
        return false;
    }
    $Pid = $Info[0]['id'];
    $Sql = "INSERT INTO " .C('DB_PREFIX')."auth_rule(`pid`,`name`,`title`) values($Pid,'{$RuleLink}','{$RuleName}');";
    if(!M()->execute($Sql)){
        return false;
    }
    return true;
}
//卸载节点
function UnRule($Tile){
    $Tile = addslashes($Tile);
    return M() -> execute("DELETE FROM  ".C('DB_PREFIX')."auth_rule WHERE(`title`='{$Tile}')");
}
//读取插件配置
function ReadPluginConfig($Sign){
    $Sign = addslashes($Sign);
    $Config = M() -> query("SELECT * FROM ".C('DB_PREFIX')."plugin_config WHERE(sign = '{$Sign}')");
    if($Config){
        $Config = $Config[0]['config'];
    }
    return $Config;
}
//写插件配置
function WritePluginConfig($Sign,$Config){
    $Sign = addslashes($Sign);
    $Config = json_encode($Config);
    if(!$Config){return false;}
    return M()->execute("UPDATE ".C('DB_PREFIX')."plugin_config SET config = '{$Config}' WHERE(sign = '{$Sign}')");
}
//////////////////插件操作


function InIng($Ing){
    $Array = array(
        0,//启用状态
        1,//封禁状态
    );
    return in_array($Ing,$Array);
}
function emptyEx($String){
    if($String!==''){
        return true;
    }else{
        return false;
    }
}

//自动验证
function IsStringNumberEx(){
    $String =  IS_POST ?  I('post.id') : I('get.id') ;
    if(!$String){ return false; }
    if(is_array($String)){
        $String = implode(',',$String);
        $String = str_ireplace(',','',$String);
    }
    return  is_numeric($String) ? $String : false ;
}
function IsRule($String){
    $Array = explode('/',$String);
    return count($Array) == 3  or count($Array) == 5 ? true : false;
}
//自动验证

/**
 * 分页函数支持关联模型
 * by封建
 *
 */
function Page ($Model = null, $ShowNumber = null,$Relation = false,$Orderby = false,$where = null, $PageName = 'p'){
    $Count = $Relation ? $Model -> relation($Relation) -> where($where) -> count() : $Model -> where($where) -> count();
    $ShowNumber = $ShowNumber  ? $ShowNumber : 5 ;
    $_GET[$PageName] = ($_GET[$PageName]) ? ($_GET[$PageName] > ceil($Count/$ShowNumber) ? ceil($Count/$ShowNumber) : $_GET[$PageName]) : 0;
    $Data = $Relation ? $Model -> where($where) -> order($Orderby) -> relation($Relation)  -> page($_GET[$PageName].','.$ShowNumber) ->  select() : $Model -> order($Orderby) -> where($where) -> page($_GET[$PageName].','.$ShowNumber) ->  select();
    $Page = new \Think\Page($Count,$ShowNumber);
    return array('Data' => $Data,'Page' => $Page->show()) ;
}
//获取层级化后的权限节点
function GetRuletree($Data = null, $Pid = 0, $Checkbox = null)
{
    $result = '<ul>';
    foreach ($Data as $Key => $Val) {
        if ($Val['pid'] == $Pid) {
            $result .= '<li>';
            $result.= "<div class='" .($Val['status'] ? 'block' : 'blockban' )."'>";
            $result.= "<i  class='glyphicon glyphicon-minus'></i>";
            if($Checkbox and $Val['status']){
                $result.= $Checkbox ? " <input name='rules[]' class='checkbox1' type='checkbox' value='{$Val['id']}' />"  : '' ;
            }
            $result.= "{$Val['title']}";
            $result.= "<i class='glyphicon glyphicon-link'></i>";
            $result.= "{$Val['name']} ";
            if(!$Checkbox){
                $result.= "<a class='label label-danger'href='".U('Admin/User/RemoveRule',array('id'=>$Val['id']))."'"."<i class='glyphicon glyphicon-remove'></i>刪除</a> ";
                $result.= "<a class='label label-primary'href='".U('Admin/User/EditRule',array('id'=>$Val['id']))."'"."<i class='glyphicon glyphicon-check'>编辑</a> ";
                $result.= $Val['status'] ? "<a href='".U('Admin/User/EditStatusRule',array('id'=>$Val['id'],'status'=>'0'))."'"."class='label label-warning'><i class='glyphicon glyphicon-ban-circle'></i>禁止</a> " : "<a href='".U('Admin/User/EditStatusRule',array('id'=>$Val['id'],'status'=>'1'))."'"."class='label label-success'><i class='glyphicon glyphicon-ban-circle'></i>开启</a> ";
//                $result.= "<a class='label label-info'href='".U('Admin/User/Addrule',array('id'=>$Val['id']))."'"."<i class='glyphicon glyphicon-check'>增加子节点</a> ";
            }
            $result.= "</div>";
            unset($Data[$Key]);
            $result .= '<ol>' . GetRuletree($Data, $Val['id'],$Checkbox) . '</ol>';
            $result .= '</li>';
        }
    }
    $result .= "</ul>";
    return $result;
}
//获取层次化后的规则列表
function GetRuleSelect($Data = null, $Pid = 0, $I = 0){
    $result = null;
    foreach($Data as $Key => $Val){
        if($Val['pid'] == $Pid){
            if($I != 0){
                $Nbsp = str_repeat('&nbsp;',$I*4);
            }
            $result .= "<option value='".$Val['id']."'>".$Nbsp.$Val['title']."</option>";
            unset($Data[$Key]);
            $result .=GetRuleSelect($Data,$Val['id'],$I+1);
        }
    }
    return $result;
}
function GetNavList($Data = null, $Pid = 0, $I = 0){
    $MaxNumber = 1;
    $result = null;
    foreach($Data as $Key => $Val){
        if($Val['pid'] == $Pid){
            $Class = '';
            $Child = IsChild($Data,$Val['id']);
            if($Val['name'] == MODULE_NAME.'/' . CONTROLLER_NAME . '/' . ACTION_NAME){
                $Class .='NavActive ';
            }
            if($I < $MaxNumber){
                if($Child){
                    $Child = true;
                    $Class .='parent ';
                    $Option = "<span data-toggle='collapse' href='#sub-item-".$Val['id']."' class='icon pull-right'><em class='glyphicon glyphicon-s glyphicon-plus glyphicon-minus'></em></span>";
                }
            }
            $result .= "<li class='{$Class}' />";
            if($Val['name']==''){
                $result .= '<a><span class="glyphicon '.$Val['icon'].'"></span> ';
            }else{
                $result .= '<a href="'.U($Val['name']).'"><span class="glyphicon '.$Val['icon'].'"></span> ';
            }
            $result .= $Val['title'];
            if($Child){
                $result .=$Option;
            }
            $result .= "</a>";
            if($I < $MaxNumber){
                unset($Data[$Key]);
                if( $Child = GetNavList($Data,$Val['id'],$I+1)){
                    $result .="<ul class='children collapse in' id='sub-item-" .$Val['id'] . "' >" . $Child . "</ul>";
                }
            }
            $result .= '</li>';
        }
    }
    return $result;
}
function IsChild($Data = null, $Id = null){
    foreach($Data as $Key => $Val){
        if($Val['pid'] == $Id ){
            return true;
        }
    }
    return false;
}
function IsLogin(){
    if(session('uid')){
        return true;
    }else{
        return false;
    }
}
function GetNowPostion($NavData = null ,$Index = null ,$Postion = null){
//    if($NavData[$Index]['name']){
//        $Postion .= "<a href='".U($NavData[$Index]['name'])."'>".$NavData[$Index]['title']."</a>"."|";
//    }else{
//        $Postion .= "<a>".$NavData[$Index]['title']."</a>"."|";
//    }
    $Postion .= "<a>".$NavData[$Index]['title']."</a>"."|";
    if($NavData[$Index]['pid'] != 0){
        $Postion .= GetNowPostion($NavData,ArraySearch($NavData,'id',$NavData[$Index]['pid']));
    }
    return $Postion;
}
function ArraySearch($Array = array(), $Name = null, $String){
    foreach($Array as $Key => $Val){
        if($Val[$Name] == $String){
            return $Key;
        }
    }
    return -1;
}