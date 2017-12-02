<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/6
 * Time: 20:05
 */
namespace app\common\lib;
require VENDOR_PATH.'qiniu/php-sdk/autoload.php';
//引入鉴权类
use Qiniu\Auth;
//引入上传类
use Qiniu\Storage\UploadManager;

/**
 * 七牛图片基础类库
 * Class Upload
 * @package app\common\lib
 */
class Upload {
    /**
     * 图片上传
     */
    public static function image(){
//        halt($_FILES['file']);
        if (empty($_FILES['file']['tmp_name'])){
            exception('您提交的图片数据不合法！', 404);
        }
        //要上传的临时文件
        $file = $_FILES['file']['tmp_name'];
        /*$ext = explode('.',$_FILES['file']['name']);
        $ext = $ext[1];*/
        $pathinfo = pathinfo($_FILES['file']['tmp_name']);
        $ext = $pathinfo['extension'];
        $config = config('qiniu');

        //构建一个鉴权
        $auth = new Auth($config['ak'],$config['sk']);
        //生成上传token
        $token = $auth->uploadToken($config['bucket']);
        //要保存的文件名
        $key = date('Y')."/".date('m')."/".substr(md5($file), 0, 5).date('Ymdhis').rand(0,9999).'.'.$ext;
        //初始化一个UploadManager类
        $UploadMgr = new UploadManager();
        list($ret, $err ) = $UploadMgr->putFile($token, $key , $file);
        if ($err !== null){
            return null;
        }else{
            return $config['image_url'].'/'.$key;
        }
//        halt($res);

    }

}
