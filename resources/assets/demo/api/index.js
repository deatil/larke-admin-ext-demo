import request from '@/utils/request'

export function getList(params) {
  return request({
    url: '/demo',
    method: 'get',
    params
  })
}

export function getDetail(id) {
  return request({
    url: `/demo/${id}`,
    method: 'get'
  })
}

export function deleteData(id) {
  return request({
    url: `/demo/${id}`,
    method: 'delete'
  })
}
