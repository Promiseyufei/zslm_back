define({ "api": [
  {
    "type": "post",
    "url": "/admin/Files/deleteFile",
    "title": "删除文件",
    "name": "deleteFile",
    "group": "Files",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "uploadFile",
            "description": "<p>删除文件的id.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "code",
            "description": "<p>返回程序的状态码 0 表示成功 1表示失败.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>成功就是success.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n     \"code\":0,\n     \"message\":'success'\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "dataError",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"code\":1,\n  \"message\":'文件id缺失（举个例子） or Application error ',\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Files/FilesController.php",
    "groupTitle": "Files"
  },
  {
    "type": "get",
    "url": "/admin/files/getUploadFile?page=1&pageSize=5",
    "title": "获取上传过的文件信息",
    "name": "getUploadFile",
    "group": "Files",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "page",
            "description": "<p>页码.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "pageSize",
            "description": "<p>单个页面请求的数据个数.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "code",
            "description": "<p>返回程序的状态码 0 表示成功 1表示失败.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>成功就是success.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n     \"code\":0,\n     \"message\":'success',\n     \"data\":{\n         array[\n               0 => {\n                  \"id\": 1\n                  \"show_weight\": 1\n                  \"file_name\": \"test\"\n                  \"file_type\": 0\n                  \"file_year\": \"2018\"\n                  \"is_show\": 0\n                  \"create_time\": 11111\n                  }\n         ]\n      }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "dataError",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"code\":1,\n  \"message\":'No data or Application error ',\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Files/FilesController.php",
    "groupTitle": "Files"
  },
  {
    "type": "post",
    "url": "/admin/Files/updateFile",
    "title": "更新文件",
    "name": "updateFile",
    "group": "Files",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "fileName",
            "description": "<p>文件名称.</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "fileType",
            "description": "<p>文件类型</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "fileYear",
            "description": "<p>文件年份</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "fileDescribe",
            "description": "<p>文件描述</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "isShow",
            "description": "<p>文件是否展示</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "code",
            "description": "<p>返回程序的状态码 0 表示成功 1表示失败.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>成功就是success.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n     \"code\":0,\n     \"message\":'success'\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "dataError",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"code\":1,\n  \"message\":'文件名称未填写（举个例子） or Application error ',\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Files/FilesController.php",
    "groupTitle": "Files"
  },
  {
    "type": "post",
    "url": "/admin/Files/uploadFile",
    "title": "上传文件",
    "name": "uploadFile",
    "group": "Files",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "File",
            "optional": false,
            "field": "uploadFile",
            "description": "<p>上传的文件.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "fileName",
            "description": "<p>文件名称.</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "fileType",
            "description": "<p>文件类型</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "fileYear",
            "description": "<p>文件年份</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "fileDescribe",
            "description": "<p>文件描述</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "isShow",
            "description": "<p>文件是否展示</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "code",
            "description": "<p>返回程序的状态码 0 表示成功 1表示失败.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>成功就是success.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n     \"code\":0,\n     \"message\":'success'\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "dataError",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"code\":1,\n  \"message\":'文件名称未填写（举个例子） or Application error ',\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Files/FilesController.php",
    "groupTitle": "Files"
  },
  {
    "type": "post",
    "url": "admin/operate/getIndexBanner",
    "title": "获得一级页面的Banner",
    "group": "operate",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "indexId",
            "description": "<p>一级页面id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "btType",
            "description": "<p>banner的类型　０是ｂａｎｎｅｒ</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"code\": \"0\",\n  \"msg\": \"使用成功\",\n  \"data\":{\n         }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The id of the User was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 200\n{\n  \"code\": \"1\",\n   \"msg\": '响应的报错信息'\n}\n\n HTTP/1.1 200\n{\n  \"code\": \"2\",\n   \"msg\": '数据加载完毕，已经无法加载相应数据'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Operate/BannerController.php",
    "groupTitle": "operate",
    "name": "PostAdminOperateGetindexbanner"
  },
  {
    "type": "post",
    "url": "admin/operate/getIndexListName",
    "title": "获得所有一级页面的名称",
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
    "groupTitle": "operate",
    "name": "PostAdminOperateGetindexlistname"
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
