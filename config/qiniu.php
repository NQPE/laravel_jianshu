<?php
/**
 * 七牛云的配置文件
 */
return [

    'bucketName' => env('QINIU_BUCKETNAME', ''),

    'accessKey' => env('QINIU_ACCESSKEY', ''),

    'secretKey' => env('QINIU_SECRETKEY', ''),

    'host_url'=>env('QINIU_HOST_URL', ''),

    'driver'=>env('QINIU_DRIVER', 'qiniu'),

];
