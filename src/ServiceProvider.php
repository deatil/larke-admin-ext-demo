<?php

namespace Larke\Admin\Demo;

use Illuminate\Support\Facades\Event;

use Larke\Admin\Event as AdminEvent;
use Larke\Admin\Facade\Extension;
use Larke\Admin\Extension\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public $info = [
        // 扩展包名
        'name' => 'demo/demo',
        // 扩展名称
        'title' => '示例扩展',
        // 扩展描述
        'description' => '示例扩展描述',
        // 扩展关键字
        'keywords' => [
            'Demo',
            'Larke',
            'Admin',
            'LarkeAdmin',
        ],
        // 扩展主页
        'homepage' => 'http://github.com/deatil',
        // 作者
        'authors' => [
            [
                'name' => 'deatil', 
                'email' => 'deatil@github.com', 
                'homepage' => 'http://github.com/deatil', 
            ],
        ],
        // 版本号
        'version' => '1.1.0',
        // 适配系统版本
        'adaptation' => '1.1.*',
        // 依赖扩展[选填]
        'require' => [
            // 'vendor/package' => '1.0.*'
        ],
    ];
    
    // 配置[选填]
    public $config = [
        [
            'name' => 'atext',
            'title' => '文本',
            'type' => 'text',
            'value' => '文本',
            'require' => '1',
            'description' => '设置内容文本',
        ],
        [
            'name' => 'atextarea',
            'title' => '文本框',
            'type' => 'textarea',
            'value' => '文本框',
            'require' => '1',
            'description' => '设置内容文本框',
        ],
        [
            'name' => 'aradio',
            'title' => '单选',
            'type' => 'radio',
            'options' => [
                '1' => '单选1',
                '2' => '单选2',
                '3' => '单选3',
            ],
            'value' => '1',
            'require' => '1',
            'description' => '设置内容单选',
        ],
        [
            'name' => 'acheckbox',
            'title' => '多选',
            'type' => 'checkbox',
            'options' => [
                '1' => '多选1',
                '2' => '多选2',
                '3' => '多选3',
            ],
            'value' => '1',
            'require' => '1',
            'description' => '设置内容多选',
        ],
        [
            'name' => 'aselect',
            'title' => '下拉',
            'type' => 'select',
            'options' => [
                '1' => '下拉1',
                '2' => '下拉2',
                '3' => '下拉3',
            ],
            'value' => '1',
            'require' => '1', // 1-必填
            'description' => '设置内容下拉',
        ],
        [
            'name' => 'aswitch',
            'title' => '开关',
            'type' => 'switch',
            'value' => '1',
            'require' => '1',
            'description' => '设置内容开关',
        ],
    ];
    
    /**
     * 扩展图标
     */
    public $icon = __DIR__ . '/../logo.png';
    
    /**
     * 启动
     */
    public function boot()
    {
        Extension::extend($this->info['name'], __CLASS__);
        
        // 事件
        $this->bootListeners();
    }
    
    /**
     * 开始，只有启用后加载
     */
    public function start()
    {
        $this->commands([
            Command\Demo::class,
        ]);
    }
    
    /**
     * 监听器
     */
    public function bootListeners()
    {
        $thiz = $this;
        
        // 安装后
        Event::listen(function (AdminEvent\ExtensionInstall $event) use($thiz) {
            $name = $event->name;
            $info = $event->info;
            
            if ($name == $thiz->info["name"]) {
                
            }
        });
        
        // 卸载后
        Event::listen(function (AdminEvent\ExtensionUninstall $event) use($thiz) {
            $name = $event->name;
            $info = $event->info;
            
            if ($name == $thiz->info["name"]) {
                
            }
        });
        
        // 更新后
        Event::listen(function (AdminEvent\ExtensionUpgrade $event) use($thiz) {
            $name = $event->name;
            $oldInfo = $event->oldInfo;
            $newInfo = $event->newInfo;
            
            if ($name == $thiz->info["name"]) {
                
            }
        });
        
        // 启用后
        Event::listen(function (AdminEvent\ExtensionEnable $event) use($thiz) {
            $name = $event->name;
            $info = $event->info;
            
            if ($name == $thiz->info["name"]) {
                
            }
        });
        
        // 禁用后
        Event::listen(function (AdminEvent\ExtensionDisable $event) use($thiz) {
            $name = $event->name;
            $info = $event->info;
            
            if ($name == $thiz->info["name"]) {
                
            }
        });
    }
}
