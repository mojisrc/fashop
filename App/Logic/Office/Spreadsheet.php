<?php
/**
 * 导出excel表
 * $name：excel表的表名
 * $data：要导出excel表的数据，接受一个二维数组
 * $head：excel表的表头，接受一个一维数组
 * $keys：$data中对应表头的键的数组，接受一个一维数组
 * 备注：此函数缺点是，表头（对应列数）不能超过26；
 * 循环不够灵活，一个单元格中不方便存放两个数据库字段的值
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\Logic\Office;
use PhpOffice\PhpSpreadsheet\Spreadsheet as OfficeSpreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Spreadsheet
{
    /**
     * excel表名称
     * @var string
     */
    private $name;
    /**
     * 要导出excel表的数据
     * @var array
     */
    private $data;
    /**
     * excel表的表头
     * @var array
     */
    private $head;
    /**
     * $data中对应表头的键的数组
     * @var array
     */
    private $keys;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getHead(): array
    {
        return $this->head;
    }

    /**
     * @param array $head
     */
    public function setHead(array $head): void
    {
        $this->head = $head;
    }

    /**
     * @return array
     */
    public function getKeys(): array
    {
        return $this->keys;
    }

    /**
     * @param array $keys
     */
    public function setKeys(array $keys): void
    {
        $this->keys = $keys;
    }

    /**
     * @param string $name
     * @param array $data
     * @param array $head
     * @param array $keys
     * @throws \Exception
     */
    public function __construct(string $name, array $data, array $head, array $keys )
    {
        $this->setName($name);
        $this->setData($data);
        $this->setHead($head);
        $this->setKeys($keys);
    }

    /**
     * 导出excel表
     */
    public function outPut()
    {
        $count       = count($this->head); //计算表头数量
        $spreadsheet = new OfficeSpreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();

        for ($i = 65; $i < $count + 65; $i++) {
            //数字转字母从65开始，循环设置表头：
            $sheet->setCellValue(strtoupper(chr($i)) . '1', $this->head[$i - 65]);
        }

        /*--------------开始从数据库提取信息插入Excel表中------------------*/
        //循环设置单元格
        foreach ($this->data as $key => $item) {
            //$key+2,因为第一行是表头，所以写到表格时   从第二行开始写
            for ($i = 65; $i < $count + 65; $i++) {
                //数字转字母从65开始：
                $sheet->setCellValue(strtoupper(chr($i)) . ($key + 2), $item[$this->keys[$i - 65]]);
                $spreadsheet->getActiveSheet()->getColumnDimension(strtoupper(chr($i)))->setWidth(20); //固定列宽
            }
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($this->name.'.xlsx');

        //关闭连接，销毁变量 释放内存 为了防止内存泄露，建议用完手动清理
        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);

        return $this->name.'.xlsx';
    }
}
