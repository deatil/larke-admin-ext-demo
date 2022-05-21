import Layout from '@/layout'

// 日志
const route = {
  path: '/demo/index',
  component: Layout,
  redirect: '/demo/list',
  alwaysShow: true,
  name: 'Demo',
  meta: {
    title: 'Demo',
    icon: 'el-icon-document-add',
    roles: [
      'larke-admin.ext.demo.index',
    ]
  }, 
  sort: 101000,
  children: [
    {
      path: '/demo/list',
      component: () => import('./views/index'),
      name: 'DemoList',
      meta: {
        title: 'DemoList',
        icon: 'el-icon-document-add',
        roles: [
          'larke-admin.ext.demo.index'
        ]
      }
    },

  ]
}

export default route