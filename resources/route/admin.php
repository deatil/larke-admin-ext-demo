<?php

use Larke\Admin\Facade\Extension;

Extension::routes(function ($router) {
    $router
        ->namespace('Larke\\Admin\\Demo\\Controller')
        ->group(function ($router) {
            // 日志
            $router->get('/demo', 'Demo@index')
                ->name('larke-admin.demo.index');
            
            $router->get('/demo/{id}', 'Demo@detail')
                ->name('larke-admin.demo.detail')
                ->where('id', '[A-Za-z0-9]+');
            
            $router->delete('/demo/{id}', 'Demo@delete')
                ->name('larke-admin.demo.delete')
                ->where('id', '[A-Za-z0-9]+');
        });
});