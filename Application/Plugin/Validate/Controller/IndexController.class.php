<?php
namespace Plugin\Validate\Controller;
use Admin\Controller\PluginController;

class IndexController extends \Think\Controller{
    public function GetValidate(){
//        define("CAPTCHA_ID", "9cfcbd31f9fc1f290114ec8f89c3b15c");
//        define("PRIVATE_KEY", "f116ff6db82bc24e5fd866cd0b70a47e");
        $Config = json_decode(ReadPluginConfig('Validate'),JSON_OBJECT_AS_ARRAY);
        $ExtendsClass = GetPluginExtendLibClassName('Validate','GeetestLib');
        $GtSdk = new $ExtendsClass($Config['id'], $Config['key']);
        session_start();
        $user_id = "test";
        $data = array(
            'user_id' => "test", # 网站用户id
            'client_type' => "web", # web:电脑上的浏览器；h5:手机上的浏览器，包括移动应用内完全内置的web_view；native：通过原生SDK植入APP应用的方式
            'ip_address' => "127.0.0.1" # 请在此处传输用户请求验证时所携带的IP
        );
        $status = $GtSdk->pre_process($data, 1);
        $_SESSION['gtserver'] = $status;
        $_SESSION['user_id'] = $user_id;
        echo $GtSdk->get_response_str();
    }
}