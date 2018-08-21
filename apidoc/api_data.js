define({ "api": [
  {
    "type": "post",
    "url": "admin/operate/getIndexListName",
    "title": "获得所有一级页面的名称",
    "name": "thumbup",
    "group": "operate",
    "description": "<p>在频道横幅页面调用，获得顶部各列表页的名称，不需要传递参数</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "obj",
            "description": "<p>一级页面名称</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"\",\n\"data\": {\n\n         {\n             \"id\":\"xxx\",\n             \"name\":\"xxxxxxxxxxxx\",\n             \"url\":\"front/test/test\"\n         }\n  }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Object[]",
            "optional": false,
            "field": "error",
            "description": "<p>这里是失败时返回实例</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 40x\n{\n  \"code\": \"1\",\n   \"msg\": '请求失败'\n}\n\n HTTP/1.1 200\n{\n  \"code\": \"2\",\n   \"msg\": '请求方式错误'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Operate/BannerController.php",
    "groupTitle": "operate"
  },
  {
    "type": "get",
    "url": "index.php?i=",
    "title": "测试一",
    "group": "test",
    "version": "0.0.1",
    "description": "<p>这是第一个测试</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>登录token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求样例",
          "content": "/index.php?i=8888",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "type",
            "description": "<p>类型 0：上行 1：下行</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "请求成功数据",
        "content": "{\n   \"status\": \"1\",\n   \"data\": {\n              \"first\": 1,\n              \"last\": 3,\n   },\n   \"msg\": \"操作成功\"\n}",
        "type": "json"
      },
      {
        "title": "失败返回样例:",
        "content": "{\"code\":\"0\",\"msg\":\"修改成功\"}",
        "type": "json"
      }
    ],
    "filename": "app/Http/Controllers/Admin/Accounts/AccountsController.php",
    "groupTitle": "test",
    "name": "GetIndexPhpI"
  }
] });
