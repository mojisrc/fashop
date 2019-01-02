<?php

/*
 *导出excel
 * 使用示例：
 * 在控制器上方引用：
 * use App\Utils\Excel;
 * use App\Utils\Code;
 * 在控制器方法里：
         try{
             $excel = new Excel($this->response());
             $excel->outPut('测试导出',$list,$head,$keys);
         } catch( \Exception $e ){
             $this->send( Code::server_error, [], $e->getMessage() );
         }
 *
 */

namespace App\Utils;

class Excel
{
    private $response;

    /**
     * @param string $response
     * @throws \Exception
     */
    public function __construct($response)
    {
        $this->response = $response;
    }

    /**
     * @param string $name 表名称
     * @param array $data  要导出excel表的数据
     * @param array $head  表头
     * @param array $keys  表头的键的数组
     * @throws \Exception
     */
    public function outPut(string $name, array $data, array $head, array $keys)
    {
        if (count($data) > 2000) {
            throw new \Exception("最多支持导出两千条数据");
        }
        if (count($head) > 26) {
            throw new \Exception("最多支持导出26个字段");
        }
        if (count($keys) > 26) {
            throw new \Exception("最多支持导出26个字段");
        }
        if (count($head) != count($keys)) {
            throw new \Exception("表头和表头键必须匹配");
        }

        $spreadsheet_logic = new \App\Logic\Office\Spreadsheet($name, $data, $head, $keys);
        $file_name         = $spreadsheet_logic->outPut();

        //生成文件后，使用response输出
        $this->response->write(file_get_contents($file_name));
        $this->response->withHeader('Content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');//告诉浏览器输出07Excel文件
        $this->response->withHeader('Content-Disposition', 'attachment;filename=' . $file_name);//告诉浏览器输出浏览器名称
        $this->response->withHeader('Cache-Control', 'max-age=0');//禁止缓存
        $this->response->end();
        unlink($file_name);
    }
}