<?php
/**
 * Created by PhpStorm.
 * User: Jax
 * Date: 2017/4/14
 * Time: 19:36
 */
namespace Install\Controller;
use Think\Controller;
class InstallController extends Controller {
    public function install(){
        if(file_exists("Application/Install/install.lock")){
           $this -> error("你已经成功了FIND系统，如需重复安装，请删掉install.lock文件!",U('Home/Index/index'));
        }
       if(IS_POST){
           if(!I('dbhost')){
               $this -> error("请填写数据库地址!");
           }elseif(!I('dbuser')){
               $this -> error("请填写数据库用户名!");
           }elseif(!I('dbport')){
               $this -> error("请填写数据库端口!");
           }elseif(!I('dbname')){
               $this -> error("请填写数据库名!");
           }elseif(!I('dbprefix')){
               $this -> error("请填写数据表前缀!");
           }
           $this -> createTable();
           $this -> writeConfig();
           touch("Application/Install/install.lock");
           $_GET['step'] = 4;
           $this -> display('step4');
       }else{
           switch($_GET['step']){
               case 1:
                   $this -> step1();
                   break;
               case 2:
                   $this -> stop2();
                   break;
               case 3:
                   $this -> stop3();
                   break;
               default:
                   $this -> step1();
           }
       }
    }
    public function step1(){
        $this -> display('step1');
    }
    public function stop2(){
        session('install',null);
        $i = 1;
        $ii = 0;
        $info1 = array(
            array(
                'name'=>'操作系统',
                'excellent'=>'LINUX',
                'least'=>'无',
                'now'=>PHP_OS,
                'yes'=>'yes',
            ),
            array(
                'name'=>'PHP',
                'excellent'=>'>5.3.0',
                'least'=>'5.3.0',
                'now'=>PHP_VERSION,
                'yes'=>'no',
            ),
            array(
                'name'=>'MYSQL',
                'excellent'=>'>5.0.0',
                'least'=>'5.0.0',
                'now'=>mysql_get_server_info(),
                'yes'=>'no',
            ),
            array(
                'name'=>'附件上传',
                'excellent'=>'>5M',
                'least'=>'2M',
                'now'=>ini_get('upload_max_filesize'),
                'yes'=>'no',
            ),
            array(
                'name'=>'SESSION',
                'excellent'=>'开启',
                'least'=>'开启',
                'now'=>isset($_SESSION) ? '开启': '关闭',
                'yes'=>'no',
            ),
        );
        $info2 = array(
            array(
                'name'=>'../',
                'write'=>false,
                'read'=>false,
                'yes'=>'no',
            ),
            array(
                'name'=>'./',
                'write'=>false,
                'read'=>false,
                'yes'=>'no',
            ),
            array(
                'name'=>'./Application/',
                'write'=>false,
                'read'=>false,
                'yes'=>'no',
            ),
            array(
                'name'=>'./Public/',
                'write'=>false,
                'read'=>false,
                'yes'=>'no',
            ),
            array(
                'name'=>'./Application/Plugin/',
                'write'=>false,
                'read'=>false,
                'yes'=>'no',
            ),
            array(
                'name'=>'./Application/File/',
                'write'=>false,
                'read'=>false,
            ),
            array(
                'name'=>'./Application/Install/',
                'write'=>false,
                'read'=>false,
                'yes'=>'no',
            ),
        );
        foreach($info1 as $key => $val){
                if($val['now'] >= $val['least'] ){
                    $info1[$key]['yes'] = 'yes';
                    $i++;
                }
        }
        foreach($info2 as $key => $val){
            if(is_writable($val['name'])){
                $info2[$key]['write'] = true;
            }
            if(is_readable($val['name'])){
                $info2[$key]['read'] = true;
            }
            if($info2[$key]['write'] and $info2[$key]['read']){
                $info2[$key]['yes'] = 'yes';
                $ii++;
            }
            clearstatcache();
        }
        if($i == count($info1) and $ii == count($info2) ){
            session('install',true);
        }
        $this -> assign('info1',$info1);
        $this -> assign('info2',$info2);
        $this -> display('step2');
    }
    public function stop3(){
        $this -> checkInstall();
        $this -> display('step3');
    }
    public function stop4(){
        $this -> checkInstall();
        session('install',null);
        $this -> display('step4');
    }
    public function checkInstall(){
        if(!session('install') or session('install')==false){
            $this -> error("未通过环境监测",U('Install/Install/install',array('step'=>1)));
        }
    }
    public function createTable(){
        $link = @mysqli_connect(I('dbhost'),I('dbuser'),I('dbpwd'),null,I('dbport'));
        if(mysqli_connect_errno()!=0){
            switch(mysqli_connect_errno()){
                case 1045:
                    $this -> error("数据库用户名或密码错误!");
                    break;
                default:
                    $this -> error(iconv('gbk','utf-8',mysqli_connect_error()));
            }
        }else{
            if(!mysqli_select_db($link,I('dbname'))){
                @mysqli_query($link,'CREATE DATABASE IF NOT EXISTS `'.I('dbname').'`');
                if(mysqli_errno($link)!=0){
                    $this -> error(mysqli_error($link));
                }else{
                    mysqli_select_db($link,I('dbname'));
                }
            }
            if(file_exists('Public/Install/data/sql.sql')){
                $sql = file_get_contents('Public/Install/data/sql.sql');
                $sql = preg_replace('/find_/',I('dbprefix'),$sql);
                foreach(preg_split('/;\n+/',$sql) as $key => $val){
                    if($val !=''){
                        @mysqli_query($link,$val);
                        if(mysqli_errno($link)!=0){
                            $this -> error(mysqli_error($link));
                        }
                    }
                }
            }else{
                $this -> error("安装程序缺少sql文件!");
            }
        }
    }
    public function writeConfig(){
        $data = array(
            'DB_TYPE'   => 'mysql', // 数据库类型
            'DB_HOST'   => I('dbhost'), // 服务器地址
            'DB_NAME'   => I('dbname'), // 数据库名
            'DB_USER'   => I('dbuser'), // 用户名
            'DB_PWD'    => I('dbpwd'), // 密码
            'DB_PORT'   => I('dbport'), // 端口
            'DB_PREFIX' => I('dbprefix'), // 数据库表前缀
            'DB_CHARSET'=> 'utf8', // 字符集
        );
        writeConfig(APP_PATH."/Common/Conf/db.php",$data);
    }
}