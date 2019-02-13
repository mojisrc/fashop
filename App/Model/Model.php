<?php

namespace App\Model;

/**
 * Class Model
 * @package App\Model
 * @method mixed|static init()
 * @method mixed|static column(string $name)
 * @method mixed|static value(string $name)
 * @method mixed|static field($field)
 * @method mixed|static select()
 * @method mixed|static count()
 */
class Model extends \ezswoole\Model
{
	protected $returnType = 'Array';
}
