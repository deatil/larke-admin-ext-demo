<?php

declare (strict_types = 1);

namespace Larke\Admin\Demo\Controller;

use Illuminate\Http\Request;

use Larke\Admin\Http\Controller as BaseController;

/**
 * Demo 控制器
 *
 * @title Demo 控制器
 * @desc Demo 控制器
 * @order 9900
 * @auth true
 * @slug larke-admin.ext.demo
 *
 * @create 2022-2-15
 * @author deatil
 */
class Demo extends BaseController
{
    /**
     * 列表
     *
     * @title 数据列表
     * @desc 数据列表
     * @order 9901
     * @auth true
     * @parent larke-admin.ext.demo
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        $start = (int) $request->input('start', 0);
        $limit = (int) $request->input('limit', 10);
        
        $start = max($start, 0);
        $limit = max($limit, 1);
        
        $order = $this->formatOrderBy($request->input('order', 'create_time__ASC'));
        
        $searchword = $request->input('searchword', '');

        $wheres = [];
        
        $startTime = $this->formatDate($request->input('start_time'));
        $endTime = $this->formatDate($request->input('end_time'));
        $status = $this->switchStatus($request->input('status'));
        
        $total = 30; 
        $list = []; 
        
        for ($i = 1; $i <= $limit; $i ++) {
            $list[] = [
                'id' => ($start + $i),
                'title' => 'title' . ($start + $i),
                'desc' => 'desc' . ($start + $i),
                'status' => 1,
                'time' => time(),
            ];
        }
        
        return $this->success(__('获取成功'), [
            'start' => $start,
            'limit' => $limit,
            'total' => $total,
            'list' => $list,
        ]);
    }
    
    /**
     * 详情
     *
     * @title 数据详情
     * @desc 数据详情
     * @order 9902
     * @auth true
     * @parent larke-admin.ext.demo
     *
     * @param string $id
     * @return Response
     */
    public function detail(string $id)
    {
        if (empty($id)) {
            return $this->error(__('数据ID不能为空'));
        }
        
        $info = [
            'id' => 123,
            'title' => 'title' . date('YmdHis'),
            'desc' => 'desc' . date('YmdHis'),
            'time' => time(),
        ];
        if (empty($info)) {
            return $this->error(__('数据不存在'));
        }
        
        return $this->success(__('获取成功'), $info);
    }
    
    /**
     * 删除
     *
     * @title 数据删除
     * @desc 数据删除
     * @order 9903
     * @auth true
     * @parent larke-admin.ext.demo
     *
     * @param string $id
     * @return Response
     */
    public function delete(string $id)
    {
        if (empty($id)) {
            return $this->error(__('数据ID不能为空'));
        }
        
        return $this->success(__('数据删除成功'));
    }
    
}