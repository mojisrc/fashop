<?php
/**
 * Created by PhpStorm.
 * User: Apple
 * Date: 2018/11/1 0001
 * Time: 14:41
 */

namespace App\WebSocket;

use EasySwoole\Socket\AbstractInterface\ParserInterface;
use EasySwoole\Socket\Client;
use EasySwoole\Socket\Bean\{
    Caller,
    Response
};

use App\Websocket\Test;

class WebSocketParser implements ParserInterface
{
    /**
     * decode
     * @param  string         $raw    客户端消息
     * @param  Client         $client Socket Client 对象
     * @return Caller         Socket 调用对象
     */
    public function decode($raw, $client) : ? Caller
    {
        $data = json_decode($raw, true);

        // new 调用者对象
        $caller =  new Caller();
        // 设置被调用的类 这里会将ws消息中的 class 参数解析为具体想访问的控制器
        // 如果更喜欢 event 方式 可以自定义 event 和具体的类的 map 即可
        // 注 目前 easyswoole 3.0.4 版本及以下 不支持直接传递 class string 可以通过这种方式
        $class = '\\App\\WebSocket\\'. ucfirst($data['class'] ?? 'Test');
        $caller->setControllerClass($class);

        // 提供一个事件风格的写法
        // $eventMap = [
        //     'test' => Test::class,
        //     'index' => Index::class
        // ];
        // $caller->setControllerClass($eventMap[$jsonObject->event] ?? Test::class);

        // 设置被调用的方法
        $caller->setAction($data['action'] ?? 'index');
        // 设置被调用的Args
        $caller->setArgs(is_array($data['content']) ? $data['content'] : []);
        return $caller;
    }
    /**
     * encode
     * @param  Response $response Socket Response 对象
     * @param  Client   $client   Socket Client 对象
     * @return string             发送给客户端的消息
     */
    public function encode(Response $response, $client) : ? string
    {
        // 这里返回响应给客户端的信息
        // 这里应当只做统一的encode操作 具体的状态等应当由 Controller处理
        return $response->getMessage();
    }
}
