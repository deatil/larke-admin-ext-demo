<?php

namespace Larke\Admin\Demo;

use Log;
use Illuminate\Support\Facades\Artisan;

use Larke\Admin\Extension\Rule;
use Larke\Admin\Extension\Menu;
use Larke\Admin\Extension\ServiceProvider as BaseServiceProvider;

use function Larke\Admin\register_install_hook;
use function Larke\Admin\register_uninstall_hook;
use function Larke\Admin\register_upgrade_hook;
use function Larke\Admin\register_enable_hook;
use function Larke\Admin\register_disable_hook;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * composer
     */
    public $composer = __DIR__ . '/../composer.json';
    
    /**
     * 扩展图标
     */
    protected $icon = __DIR__ . '/../logo.png';
    
    // 包名
    protected $pkg = "larke/demo";
    
    protected $slug = 'larke-admin.ext.demo';

    /**
     * 配置[选填]
     */
    protected $config = [
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
     * 启动
     */
    public function boot()
    {
        // 扩展注册
        $this->addExtension(
            name:     __CLASS__, 
            composer: $this->composer,
            icon:     $this->icon,
            config:   $this->config,
        );
    }
    
    /**
     * 在扩展安装、扩展卸载等操作时有效
     */
    public function action()
    {
        register_install_hook($this->pkg, [$this, 'install']);
        register_uninstall_hook($this->pkg, [$this, 'uninstall']);
        register_upgrade_hook($this->pkg, [$this, 'upgrade']);
        register_enable_hook($this->pkg, [$this, 'enable']);
        register_disable_hook($this->pkg, [$this, 'disable']);
    }
    
    /**
     * 开始，只有启用后加载
     */
    public function start()
    {
        $this->commands([
            Command\Demo::class,
        ]);
        
        // 路由
        $this->loadRoutesFrom(__DIR__ . '/../resources/route/admin.php');
        
        Log::info("ext demo start");
    }
    
    /**
     * 推送
     */
    protected function assetsPublishes()
    {
        $this->publishes([
            __DIR__.'/../resources/assets/demo' => public_path('extension/demo'),
        ], 'larke-demo-assets');
        
        Artisan::call('vendor:publish', [
            '--tag' => 'larke-demo-assets',
            '--force' => true,
        ]);
    }
    
    /**
     * 安装后
     */
    protected function install()
    {
        $slug = $this->slug;
        
        $rules = include __DIR__ . '/../resources/rules/rules.php';
        
        // 添加权限
        Rule::create($rules);
        
        // 添加菜单
        Menu::create($rules);

        $this->assetsPublishes();
        
        Log::info("ext demo install");
    }
    
    /**
     * 卸载后
     */
    protected function uninstall()
    {
        // 删除权限
        Rule::delete($this->slug);
        
        // 删除菜单
        Menu::delete($this->slug);
        
        Log::info("ext demo uninstall");
    }
    
    /**
     * 更新后
     */
    protected function upgrade()
    {
        
        Log::info("ext demo upgrade");
    }
    
    /**
     * 启用后
     */
    protected function enable()
    {
        // 启用权限
        Rule::enable($this->slug);
        
        // 启用菜单
        Menu::enable($this->slug);
        
        Log::info("ext demo enable");
    }
    
    /**
     * 禁用后
     */
    protected function disable()
    {
        // 禁用权限
        Rule::disable($this->slug);
        
        // 禁用菜单
        Menu::disable($this->slug);
        
        Log::info("ext demo disable");
    }

}
