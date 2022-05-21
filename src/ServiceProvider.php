<?php

namespace Larke\Admin\Demo;

use Illuminate\Support\Facades\Artisan;

use Larke\Admin\Extension\Rule;
use Larke\Admin\Extension\ServiceProvider as BaseServiceProvider;
use Larke\Admin\Frontend\Support\Menu;

class ServiceProvider extends BaseServiceProvider
{
    /*
    // 扩展信息
    protected $info = [
        // 扩展包名
        'name' => 'larke/demo',
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
        'version' => '1.3.0',
        // 适配系统版本
        'adaptation' => '^1.3',
        // 依赖扩展[选填]。用 composer.josn 时字段为 required
        'require' => [
            // 'vendor/package' => '1.0.*'
        ],
    ];
    */
    
    /**
     * composer
     */
    public $composer = __DIR__ . '/../composer.json';

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
     * 扩展图标
     */
    protected $icon = __DIR__ . '/../logo.png';
    
    // 包名
    protected $pkgName = "larke/demo";
    
    protected $slug = 'larke-admin.ext.demo';
    
    /**
     * 启动
     */
    public function boot()
    {
        // 扩展注册
        $this->withExtensionFromComposer(
            __CLASS__, 
            $this->composer,
            $this->icon,
            $this->config
        );
        
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
        
        // 路由
        $this->loadRoutesFrom(__DIR__ . '/../resources/route/admin.php');
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
     * 监听器
     */
    public function bootListeners()
    {
        $thiz = $this;
        
        // 安装后
        $this->onInatll(function ($name, $info) use($thiz) {
            if ($name == $thiz->pkgName) {
                $thiz->install();
            }
        });
        
        // 卸载后
        $this->onUninstall(function ($name, $info) use($thiz) {
            if ($name == $thiz->pkgName) {
                $thiz->uninstall();
            }
        });
        
        // 更新后
        $this->onUpgrade(function ($name, $oldInfo, $newInfo) use($thiz) {
            if ($name == $thiz->pkgName) {
                $thiz->upgrade();
            }
        });
        
        // 启用后
        $this->onEnable(function ($name, $info) use($thiz) {
            if ($name == $thiz->pkgName) {
                $thiz->enable();
            }
        });
        
        // 禁用后
        $this->onDisable(function ($name, $info) use($thiz) {
            if ($name == $thiz->pkgName) {
                $thiz->disable();
            }
        });
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
    }
    
    /**
     * 更新后
     */
    protected function upgrade()
    {}
    
    /**
     * 启用后
     */
    protected function enable()
    {
        // 启用权限
        Rule::enable($this->slug);
        
        // 启用菜单
        Menu::enable($this->slug);
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
    }

}
