<?php


namespace App\HttpController\Server;
use ezswoole\Db;

class Data extends Server
{
	public function info(){
		$db = Db::name('Address')->getDb();
		$result = $db->rawQuery("select * from INFORMATION_SCHEMA.Columns
where 
	table_name = 'fa_{$this->get['name']}'  
	and table_schema='fashopv2'");
		$string = '<pre>protected $dbFields = [';
		foreach($result as $row){
			$type = $this->getDbFieldType($row['DATA_TYPE']);
			$string.="'{$row['COLUMN_NAME']}' => ['{$type}'],\n";
		}
		$string.='];</pre>';
		$this->response()->write($string);
	}
	public function getDbFieldType(string $DATA_TYPE ):string{
		if(strstr($DATA_TYPE,'int')){
			return 'int';
		}else if(strstr($DATA_TYPE,'char') || $DATA_TYPE === 'text' || $DATA_TYPE === 'json'){
			return 'text';
		}else if(in_array($DATA_TYPE,['decimal','float','double'])){
			return 'double';
		}else{
			return 'text';
		}
	}
}

?>