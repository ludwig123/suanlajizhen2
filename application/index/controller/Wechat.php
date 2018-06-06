<?php
namespace app\index\controller;
use EasyWeChat\Factory;
use app\index\model\Guide;
use think\Db;

class Wechat
{

    public function index()
    {
        $config = [
            'app_id' => 'wx3cf0f39249eb0exx',
            'secret' => 'f1c242f4f28f735d4687abb469072axx',
            
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',
            
            'log' => [
                'level' => 'debug',
                'file' => __DIR__ . '/wechat.log'
            ]
        ];
        
        $app = Factory::officialAccount($config);
        
        $app->server->push(function ($message) {

            $startTime = microtime(true);
            $data = [
            'FromUserName'=>$message['FromUserName'],
            'ToUserName'=>$message['ToUserName'],
            'Content'=> $message['Content'],
            'CreateTime'=> $message['CreateTime'],
            'Time'=> strftimeBejing($message['CreateTime']),
            'MsgId' => $message['MsgId'] 
            ];
            
            $id = Db::name('weixin_text_message')->insertGetId($data);
            
            switch ($message['MsgType']) {
                case 'event':
                    return '收到事件消息';
                    break;
                case 'text':
                    $guide = new Guide($message['FromUserName'], $message['Content']);
                    $dreply = $guide->startTalk();
                    Db::name('weixin_text_message')->where('id', $id)->update(['reply'=>$reply, 'CostTime'=> microtime(true) - $startTime]);
                    return $reply;
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                case 'file':
                    return '收到文件消息';
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }
        });
        
        $response = $app->server->serve();
        
        // 将响应输出
        $response->send(); // Laravel 里请使用：return $response;
    }
}