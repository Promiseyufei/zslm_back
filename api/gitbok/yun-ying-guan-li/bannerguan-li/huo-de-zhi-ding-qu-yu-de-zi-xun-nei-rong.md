POST

```
admin/operate/getIndexBanner
```

## 参数

| 字段 | 类型 | 描述 |
| :--- | :--- | :--- |
| regionId | Number | 指定区域的id |

* [Success-Response:](http://localhost/zslm_back/apidoc/#success-examples-operate-PostAdminOperateGetindexbanner-0_0_0-0)

```
HTTP/1.1 200 OK
{
"code": 0,
"msg": "",
"data": {
         {
             "region_name":"text",
             "zx_id":[
                 {
                     "id":"xxx",
                     "weight":"xxxxxxxxxxxx",
                     "zx_name":"front/test/test",
                     "information_type":"xxxxxxxxxxxx",
                     "create_time":"xxxxxxxxxxxx"
                 }
             ]
         }
  }
}
```

## Error 4xx

| 名称 | 类型 | 描述 |
| :--- | :--- | :--- |
| error | Object\[\] | 这里是失败时返回实例 |

* [Error-Response:](http://localhost/zslm_back/apidoc/#error-examples-operate-PostAdminOperateGetindexbanner-0_0_0-0)

```
HTTP/1.1 40x
{
  "code": "1",
   "msg": '请求失败'
}

 HTTP/1.1 5xx
{
  "code": "2",
   "msg": '请求方式错误'
}
```



