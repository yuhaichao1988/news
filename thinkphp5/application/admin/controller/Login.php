<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;
use app\common\lib\IAuth;
class Login extends Base
{

    public function _initialize(){

    }

    public function index() {
        $isLogin = $this->isLogin();
        if ($isLogin){
            return $this->redirect('index/index');
        }else{
            return $this->fetch();
        }

    }

    /**
     * 登录相关操作
     */
    public function check(){
        //判定是否是POST提交
        if(request()->ispost()) {
            $data=input('post.');
            //判定验证码是否正确
            if (!captcha_check($_POST['code'])) {
                $this->error('验证码不正确，请重新输入');
            }else{
                //判断输入是否合法 判定
                //validate 判定
                try{
                //验证用户名是否存在
                $user = model('AdminUser')->get(['username' => $data['username']]);
                }catch (\Exception $e) {
                    $this->error($e->getMessage());
                }

                if (!$user || $user->status != config('admincode.status_normal')){
                    $this->error('用户不存在');
                }

                //验证密码是否正确
                if (IAuth::SetPassword($data['password']) != $user['password']){
                    $this->error('用户密码错误');
                }

                //1.如果成功需要更新数据库
                $udata = [
                    'last_login_time' => time(),
                    'last_login_ip' => request()->ip(),
                ];

                try{
                model('AdminUser')->save($udata , ['id' => $user['id']]);
                }catch (\Exception $e) {
                    $this->error($e->getMessage());
                }
                //保存session
                session(config('adminsession.session_user') , $user , config('adminsession.session_scope'));
                $this->success('登陆成功', 'index/index');
            }
        }else{
            $this->error('参数不合法');
        }

    }

    public function logout() {
        session(null, config('adminsession.session_scope'));
//        $this->success('退出成功', 'login/index');
        $this->redirect('login/index');
    }
}
