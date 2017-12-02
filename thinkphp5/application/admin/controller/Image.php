<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use app\common\lib\Upload;
/**
 * 后台图片上传类库
 * Class Image
 * @package app\admin\controller
 */
class Image extends Base
{

    /**
     * 图片上传
     */
    public function upload() {
        //测试数据
        $file = Request::instance()->file('file');
        $info = $file->move('upload');
        if ($info && $info->getPathname()){
            $data = [
                'status' => 1,
                'message' => 'OK',
                'data' => '/'.$info->getPathname(),
            ];

        }else{
            $data = [
                'status' => 0,
                'message' => '图片上传失败',
                'data' => '',
            ];
        }
        echo json_encode($data);

    }

    /**
     * 七牛上传图片
     */
    public function qiniu_upload(){
        try {
            $image = Upload::image();
        }catch (\Exception $e){
            echo json_encode(['status' => 0,'message' => $e->getMessage()]);
        }
        if ($image){
            $data = [
                'status' => 1,
                'message' => 'OK',
                'data' => $image,
            ];

        }else{
            $data = [
                'status' => 0,
                'message' => '图片上传失败',
                'data' => '',
            ];
        }
        echo json_encode($data);
    }


}
