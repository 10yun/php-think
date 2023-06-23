<?php

namespace shiyun\command\make;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;

class MakeServer extends Command
{
    use TraitCommon;
    protected function configure()
    {
        $this->setName('MakeServer')
            ->addOption('dir', 'd', Option::VALUE_OPTIONAL, '模块')
            ->addOption('name', 'c', Option::VALUE_OPTIONAL, '服务')
            ->setDescription('Say Hello');
    }

    protected function execute(Input $input, Output $output)
    {
        $dir = $input->getOption('dir') ?? '_channel/module';
        $nameInput = $input->getOption('name') ?? 'Xxx';
        if (!str_contains($dir, "/",)) {
            $this->output->writeln('<info> Directory does not exist “/” !</info>');
            return false;
        }

        $className = $this->getClassName($nameInput);
        // 命名空间
        $namespaceArr1 = $this->getNamespaceServer($dir, $nameInput);
        $namespaceClass = trim(implode('\\', $namespaceArr1));

        // 创建目录
        $fileDir = _PATH_PROJECT_ . implode("/", $namespaceArr1);
        if (!is_dir($fileDir)) {
            @mkdir($fileDir, 0755, true);
        }
        // 获取模版内容
        $stubContent = file_get_contents(__DIR__ . '/stubs/service-model.stub');
        // 解析模版内容
        $putContent = str_replace(['{%namespace%}', '{%className%}',], [
            $namespaceClass,
            $className,
        ], $stubContent);
        // 写入模版内容
        // $filePath = "{$fileDir}/$className.php";
        $filePath = "{$fileDir}/model.php";
        file_put_contents($filePath, $putContent);

        $output->writeln(' 写入成功 ' . $filePath);
    }
}
