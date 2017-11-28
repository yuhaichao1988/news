<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/21
 * Time: 19:36
 */
namespace app\common\Model;
use think\Model;
use app\common\Model\Base;
class News extends Base {
    /**
     * 后台自动化分页
     * @param array $data
     * @return array
     */
    public function getNews($data = []){
        $data['status'] = [
            'neq' ,config('admincode.status_delete')
        ];
        $order = ['id' => 'desc'];
        $result = $this->where($data)->order($order)->paginate();

        return $result;
    }

    /**
     * 根据条件获取列表数据
     * @param array $param
     */
    public function  getNesByCondition($condition = [], $from = 0, $size = 5){
        $condition['status'] = ['neq', config('admincode.status_delete')];
        $order = ['id' => 'desc'];

        $result = $this->where($condition)->order($order)->limit($from, $size)->select();
//        echo $this->getLastSql();
        return $result;
    }

    /**
     * 根据条件吗获取列表有效数据总数量
     * @param array $param
     * @return int|string
     */
    public function  getNesCountByCondition($condition = []){
        $condition['status'] = ['neq', config('admincode.status_delete')];
        $result = $this->where($condition)->count();
//        echo $this->getLastSql();
        return $result;
    }

}