<?php

declare(strict_types=1);

namespace shiyun\route\annotation;

use shiyun\route\annotation\common\RouteAbstract;
use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_PARAMETER | Attribute::IS_REPEATABLE)]
class RoutePost extends RouteAbstract
{
    protected array $attrMust = ['path'];
    protected string|array $methods = ['POST', 'OPTIONS'];
    /**
     * @param string|array $path 路由路径 使用"/"开始则忽略控制器分组路径
     */
    public function __construct(
        public string|array $path = '',
        public string       $name = '',
        public array        $params = [],
        public ?array       $pattern = null,
    ) {
        // 解析参数
        $this->paresArgs(func_get_args(), 'path');
    }
}
