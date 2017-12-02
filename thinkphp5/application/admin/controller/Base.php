<?php
namespace app\admin\controller;
use think\Controller;

/**
 * 后台基础类库
 * Class Base
 * @package app\admin\controller
 */
class Base extends Controller {
    /**
     * 页数
     * @var string
     */
    public $page = '';
    /**
     * 每页数量
     * @var string
     */
    public $size = '';
    /**
     * 查询条件的起始值
     * @var int
     */
    public $from = 0;
    /**
     * 定义model
     * @var string
     */
    public $model = '';
    /**
     * 初始化
     */
    public function _initialize() {
        //判定用户是否登陆
        $isLogin = $this->isLogin();
        if (!$isLogin){
            $this->redirect('login/index');
        }

    }

    /**
     * 判断用户是否登陆
     * @return bool
     */
    public function isLogin() {
        //获取session
        $user = session(config('adminsession.session_user') , '' , config('adminsession.session_scope'));

        if ($user ){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 获取分页 page size 内容
     * @param $data
     */
    public function getPageAndSize($data){
        $this->page = !empty($data['page']) ? $data['page'] : 1;
        $this->size = !empty($data['size']) ? $data['page'] : config('paginate.list_rows');
        $this->from = ($this->page - 1) * $this->size;
    }

    /**
     * 公共的删除方法
     */
    public function delete($id = 0){

        if (!intval($id)){
            return $this->result('', 0 , 'ID不合法');
        }
        $model = $this->model ? $this->model : request()->controller();
        try{
            $getid = model($model)->get($id);
        }catch (\Exception $e){
            return $this->result('', 0 , $e->getMessage());
        }
        if (!$getid){
            return $this->result('', 0, '数据不存在');
        }
        try{
            $res = model($model)->save(['status' => -1], ['id' => $id]);
        }catch (\Exception $e){
            return $this->result('', 0 , $e->getMessage());
        }
        if ($res){
            return $this->result(['jump_url' => $_SERVER['HTTP_REFERER']], 1, 'ok');
        }else{
            return $this->result('', 0, '删除失败');
        }
    }

    /**
     * 公共的修改状态方法
     */
    public function status(){
        $data = input('param.');
        // validate 校验
        $model = $this->model ? $this->model : request()->controller();
        try{
            $getid = model($model)->get($data['id']);
        }catch (\Exception $e){
            return $this->result('', 0 , $e->getMessage());
        }
        if (!$getid){
            return $this->result('', 0, '数据不存在');
        }
        try{
            $res = model($model)->save(['status' => $data['status']], ['id' => $data['id']]);
        }catch (\Exception $e){
            return $this->result('', 0 , $e->getMessage());
        }
        if ($res){
            return $this->result(['jump_url' => $_SERVER['HTTP_REFERER']], 1, 'ok');
        }else{
            return $this->result('', 0, '修改失败');
        }
    }
}
