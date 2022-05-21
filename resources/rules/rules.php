<?php

return [
    'title' => 'Demo数据',
    'url' => '#',
    'method' => 'OPTIONS',
    'slug' => $slug,
    'description' => '示例扩展',
    'children' => [
        [
            'title' => '数据列表',
            'url' => 'demo',
            'method' => 'GET',
            'slug' => 'larke-admin.ext.demo.index',
            'description' => '数据列表',
        ],
        [
            'title' => '数据详情',
            'url' => 'demo/{id}',
            'method' => 'GET',
            'slug' => 'larke-admin.ext.demo.detail',
            'description' => '数据详情',
        ],
        [
            'title' => '删除数据',
            'url' => 'demo/{id}',
            'method' => 'DELETE',
            'slug' => 'larke-admin.ext.demo.delete',
            'description' => '删除某条数据',
        ],
    ],
];
