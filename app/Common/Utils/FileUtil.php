<?php
namespace App\Common\Utils;

use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

/**
 *
 * 文件处理类
 * Created by PhpStorm.
 * User: Levi
 * Date: 2017/7/10
 * Time: 17:28
 */
class FileUtil
{
    /**
     * @param $files    array:2 [▼
     * "file1" => UploadedFile {#175 ▶}
     * "file2" => UploadedFile {#179 ▶}
     * ]
     * @param string $path 存储的文件夹路径
     */
    public static function saveFile($files, $path = 'upload/')
    {
//        dd($files);
        $files = is_array($files) ? $files : array($files);
        $resfiles = array();
        $timepath = date("Y-m-d");
        $path = $path . $timepath;
//        dd(config('filesystems.default'));
        foreach ($files as $k => $file) {
            if (!$file->isValid()) {
                $resfiles[$k] = false;
                continue;
            }
            //判断上传图片是否重复
            $md5 = md5_file($file->getRealPath());
            $retFile = self::isFileRepeat($md5);
            if ($retFile) {
                $resfiles[$k] = $retFile;
                continue;
            }
            //图片存储在本地磁盘
            $filepath = Storage::putFile(
                $path, $file
            );
            //图片存储信息写入数据库
            $retFile = self::saveFileToDb($filepath, $md5, $file, config('filesystems.default'));
            $resfiles[$k] = $retFile;
        }
        return $resfiles;
    }

    /**
     * 判断file文件是否已经存在
     * @param $md5
     * @return mix 存在就返回重复的那个文件
     */
    public static function isFileRepeat($md5)
    {
        $count = File::where('md5', $md5)->count();
        if ($count > 0) {
            $resFile = File::where('md5', $md5)->first();
            return $resFile;
        }
        return false;
    }

    private static function saveFileToDb($path, $md5, $file, $driver)
    {
        $data['path'] = $path;
        $data['filename'] = substr(strrchr($path, '/'), 1);
        $data['md5'] = $md5;
        $data['mimeType'] = $file->getClientMimeType();
        $data['ext'] = $file->getClientOriginalExtension();
        $data['size'] = $file->getClientSize();
        $data['driver'] = $driver;
        $res = File::create($data);
        return $res;
    }

    /**
     * 上传文件到七牛云服务器上
     * @param $files
     * @param string $path
     */
    public static function saveFileQiNiu($files, $path = 'upload/images/')
    {
        //初始化七牛云所需类
        $upManager = new UploadManager();
        $auth = new Auth(config('qiniu.accessKey'), config('qiniu.secretKey'));
        $token = $auth->uploadToken(config('qiniu.bucketName'));
        //开始处理上传逻辑
        $files = is_array($files) ? $files : array($files);
        $resfiles = array();
        $timepath = date("Y-m-d");
        $path = $path . $timepath;
        foreach ($files as $k => $file) {
            if (!$file->isValid()) {
                $resfiles[$k] = false;
                continue;
            }
            //判断上传图片是否重复
            $md5 = md5_file($file->getRealPath());
            $retFile = self::isFileRepeat($md5);
            if ($retFile) {
                $resfiles[$k] = $retFile;
                continue;
            }
            //上传图片到七牛云
            $filename = $path . '/' . substr($md5, 0, 10) . '.' . $file->getClientOriginalExtension();
            $ret = $upManager->putFile($token, $filename, $file->getRealPath());
            $filepath = $ret[0]['key'];
            //图片存储信息写入数据库
            $retFile = self::saveFileToDb($filepath, $md5, $file, config('qiniu.driver'));
            $resfiles[$k] = $retFile;
        }

        return $resfiles;
    }

    /**
     * 通过file数据库id 得到文件的完整路径
     * @param $id
     * @return string
     */
    public static function getPathCompleteById($id){
        $file=File::find($id);
        return self::getPathComplete($file);
    }


    /**
     * 得到完整的file路径 包括hosturl
     * @param $file File model
     */
    public static function getPathComplete($file)
    {
        $local=$file->driver;
        $path=$file->path;
        $host=self::getHostUrl($local);
        return $host.$path;
    }

    public static function getHostUrl($local){
        $host='';
        switch($local){
            case 'local':
                $host=asset('/');
                break;
            case 'qiniu':
                $host=config('qiniu.host_url');
                break;
            default:
                $host=asset('/');
                break;
        }

        return $host;
    }
}