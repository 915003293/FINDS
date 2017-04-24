<?php
/**
 * Created by PhpStorm.
 * User: Jax
 * Date: 2017/4/1
 * Time: 22:21
 */
namespace Plugin\Validate;
class ValidatePlugin {
    public $Info = array(
      'sign' => 'Validate',
      'title' => '极验证插件',
      'description' => '次世代验证码插件',
      'version' => '1.0',
      'author' => '封建',
	  'hook' =>	array(
		  'Login',
		  'Validate',
	  )
    );
	public function Install(){
		if(RegRule('validate',"Admin/Admin/Index/Plugin/Validate")){
			return true;
		}else{
			return false;
		}
	}
	public function Validate(){
		$Address = U(('Admin/Index/GetValidate/Plugin/Validate'));
		echo  <<<Validate
		<style>
			body {
				margin: 50px 0;
				text-align: center;
			}
			#embed-captcha {
				width: 300px;
				margin: 0 auto;
			}
    	</style>
    	<div id="embed-captcha"></div>
    	<p id="wait" class="show">正在加载验证码......</p>
    	<p id="notice" class="hide">请先完成验证</p>
		<script src="http://static.geetest.com/static/tools/gt.js"></script>
		<script>
			var handlerEmbed = function (captchaObj) {
				$("form").submit(function (e) {
					var validate = captchaObj.getValidate();
					if (!validate) {
						layer.open({
							type:0,
							title:'提示',
							content:'请移动滑块，完成验证！',
							icon:2
						});
						e.preventDefault();
					}else{
						console.log($("form").submit());
					}

				});
				// 将验证码加到id为captcha的元素里，同时会有三个input的值：geetest_challenge, geetest_validate, geetest_seccode
				captchaObj.appendTo("#embed-captcha");
				captchaObj.onReady(function () {
					$("#wait")[0].className = "hide";
				});
				// 更多接口参考：http://www.geetest.com/install/sections/idx-client-sdk.html
			};
			$.ajax({
				// 获取id，challenge，success（是否启用failback）
				url: "{$Address}", // 加随机数防止缓存
				type: "get",
				dataType: "json",
				success: function (data) {
					console.log(data);
					// 使用initGeetest接口
					// 参数1：配置参数
					// 参数2：回调，回调的第一个参数验证码对象，之后可以使用它做appendTo之类的事件
					initGeetest({
						gt: data.gt,
						challenge: data.challenge,
						new_captcha: data.new_captcha,
						product: "embed", // 产品形式，包括：float，embed，popup。注意只对PC版验证码有效
						offline: !data.success // 表示用户后台检测极验服务器是否宕机，一般不需要关注
						// 更多配置参数请参见：http://www.geetest.com/install/sections/idx-client-sdk.html#config
					}, handlerEmbed);
				}
			});
		</script>
Validate;
	}
	public function Login(){
		session_start();
		$Config = json_decode(ReadPluginConfig('Validate'),JSON_OBJECT_AS_ARRAY);
		$ExtendsClass = GetPluginExtendLibClassName('Validate','GeetestLib');
		$GtSdk = new $ExtendsClass($Config['id'], $Config['key']);
		$data = array(
			'user_id' => $_SESSION['user_id'], # 网站用户id
			'client_type' => "web", # web:电脑上的浏览器；h5:手机上的浏览器，包括移动应用内完全内置的web_view；native：通过原生SDK植入APP应用的方式
			'ip_address' => "127.0.0.1" # 请在此处传输用户请求验证时所携带的IP
		);
		if ($_SESSION['gtserver'] == 1) {   //服务器正常
			$result = $GtSdk->success_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'], $data);
			if (!$result) {
				exit("验证码错误！");
			}
		}else{  //服务器宕机,走failback模式
			if (!$GtSdk->fail_validate($_POST['geetest_challenge'],$_POST['geetest_validate'],$_POST['geetest_seccode'])) {
				exit("验证码错误！");
			}
		}
	}
	public function UnLoad(){
		if(UnRule('validate')){
			return true;
		}else{
			return false;
		}
	}
}