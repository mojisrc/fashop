<?php
/**
 * Created by PhpStorm.
 * User: Apple
 * Date: 2018/11/1 0001
 * Time: 14:47
 */

namespace App\WebSocket;

class WebSocketEvent
{
    /**
     * 握手事件
     * @param  swoole_http_request $request swoole http request
     * @param  swoole_http_response $response swoole http response
     * @return bool                         是否通过握手
     */
    public function onHandShake(\swoole_http_request $request, \swoole_http_response $response)
    {
        // 通过自定义握手 和 RFC ws 握手验证
        if ($this->customHandShake($request, $response) && $this->secWebsocketAccept($request, $response)) {
            // 接受握手 还需要101状态码以切换状态
            $response->status(101);
            var_dump('shake success at fd :' . $request->fd);
            $response->end();
            return true;
        }

        $response->end();
        return false;
    }

    /**
     * 关闭事件
     * @param  swoole_server $server    swoole server
     * @param  int           $fd        fd
     * @param  int           $reactorId 线程id
     * @return void
     */
    public function onClose(\swoole_server $server, int $fd, int $reactorId)
    {
        // 判断连接是否为 WebSocket 客户端 详情 参见 https://wiki.swoole.com/wiki/page/490.html
        $connection = $server->connection_info($fd);

        // 判断连接是否为 server 主动关闭 参见 https://wiki.swoole.com/wiki/page/p-event/onClose.html
        $reactorId < 0 ? '主动' : '被动';
    }

    /**
     * 自定义握手事件
     * 在这里自定义验证规则
     * @param  swoole_http_request $request swoole http request
     * @param  swoole_http_response $response swoole http response
     * @return bool                         是否通过握手
     */
    protected function customHandShake(\swoole_http_request $request, \swoole_http_response $response): bool
    {
        $headers = $request->header;
        $cookie = $request->cookie;

        // if (如果不满足我某些自定义的需求条件，返回false，握手失败) {
        //    return false;
        // }
        return true;
    }

    /**
     * RFC规范中的WebSocket握手验证过程
     * @param  swoole_http_request $request swoole http request
     * @param  swoole_http_response $response swoole http response
     * @return bool                           是否通过验证
     */
    protected function secWebsocketAccept(\swoole_http_request $request, \swoole_http_response $response): bool
    {
        // ws rfc 规范中约定的验证过程
        if (!isset($request->header['sec-websocket-key'])) {
            // 需要 Sec-WebSocket-Key 如果没有拒绝握手
            var_dump('shake fai1 3');
            return false;
        }
        if (0 === preg_match('#^[+/0-9A-Za-z]{21}[AQgw]==$#', $request->header['sec-websocket-key'])
            || 16 !== strlen(base64_decode($request->header['sec-websocket-key']))
        ) {
            //不接受握手
            var_dump('shake fai1 4');
            return false;
        }

        $key = base64_encode(sha1($request->header['sec-websocket-key'] . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11', true));
        $headers = array(
            'Upgrade'               => 'websocket',
            'Connection'            => 'Upgrade',
            'Sec-WebSocket-Accept'  => $key,
            'Sec-WebSocket-Version' => '13',
            'KeepAlive'             => 'off',
        );

        if (isset($request->header['sec-websocket-protocol'])) {
            $headers['Sec-WebSocket-Protocol'] = $request->header['sec-websocket-protocol'];
        }

        // 发送验证后的header
        foreach ($headers as $key => $val) {
            $response->header($key, $val);
        }
        return true;
    }
}
