<?php
namespace app\admin\controller;
use think\Controller;

class News extends Base
{

    public function index() {
        $data = input('param.');
        $query = http_build_query($data);

//        halt($data);
        $whereData = [];
        if( !empty($data['start_time']) && !empty($data['end_time']) && $data['end_time'] > $data['start_time'] ) {
            $whereData['create_time'] = [
                ['gt', strtotime($data['start_time'])],
                ['lt', strtotime($data['end_time'])],
            ];
        }
        if( !empty($data['catid']) ) {
            $whereData['catid'] = intval($data['catid']);
        }
        if( !empty($data['title']) ) {
            $whereData['title'] = ['like','%'.$data['title'].'%'];
        }
        //获取数据 把数据填充到模板
        //模式一
 /*       try{
            $news = model('News')->getNews();
        }catch (\Exception $e){
            return $this->result('', 0, '查询信息失败', 'json');
        }*/
        //模式二
        //找到page size from  limit from size
        $this->getPageAndSize($data);
//        halt($news);

        try{
            $news = model('News')->getNesByCondition($whereData, $this->from, $this->size);
        }catch (\Exception $e){
            return $this->result('', 0, '查询信息失败', 'json');
        }
        //获取有效数据总数量
        try{
            $pageTotal = model('News')->getNesCountByCondition($whereData);
        }catch (\Exception $e){
            return $this->result('', 0, '查询信息失败', 'json');
        }
        //根据总条数及每页条数获取有多少页
        $pageTotal = ceil($pageTotal/$this->size);
        return $this->fetch('',[
            'cats' => config('cat.lists'),
            'news' => $news,
            'pageTotal' => $pageTotal,
            'curr' => $this->page,
            'start_time' => !empty($data['start_time']) ? $data['start_time'] : '',
            'end_time' => !empty($data['end_time']) ? $data['end_time'] : '',
            'catid' => !empty($data['catid']) ? $data['catid'] : '',
            'title' => !empty($data['title']) ? $data['title'] : '',
            'query' => $query,
        ]);
    }
    public function add() {
        if (request()->isPost()){
            $data = input('post.');

            //对数据进行校验 validate机制校验
            try{
                $id = model('News')->add($data);
            }catch (\Exception $e){
                return $this->result('', 0, '新增信息失败', 'json');
            }
            if ($id) {
                return $this->result(['jump_url' => url('news/index')], 1, 'OK');
            }else{
                return $this->result(['jump_url' => url('news/add')], 0, 'error');
            }

        }else{
            return $this->fetch('', ['cats' => config('cat.lists')]);
        }

    }


}
