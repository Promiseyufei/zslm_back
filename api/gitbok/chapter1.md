# API接口格式范例

### 描述

> 这是一个范例哈哈哈哈啦啦啦～～～

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



