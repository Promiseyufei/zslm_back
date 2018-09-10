### 描述

在频道横幅页面调用，获得顶部各列表页的名称，不需要传递参数

### 请求方式

`POST`

### 访问路径

```
admin/operate/getIndexListName
```

## 参数列表

| 字段 | 类型 | 描述 |
| :--- | :--- | :--- |
|  |  |  |

## Success-Response

```
HTTP/1.1 200 OK
{
"code": 0,
"msg": "",
"data": {

         {
             "id":"xxx",
             "name":"xxxxxxxxxxxx",
             "url":"front/test/test"
         }
  }
}
```

## Error-Response

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



