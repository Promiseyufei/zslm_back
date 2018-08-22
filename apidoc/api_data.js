define({ "api": [
  {
    "type": "post",
    "url": "admin/operate/addAppoinInformations",
    "title": "向指定区域添加相关咨讯",
    "group": "operate",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "informArr",
            "description": "<p>需要添加的资讯id数组</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "appointId",
            "description": "<p>指定区域的id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"添加成功\"\n}",
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
          "content": "HTTP/1.1 40x\n{\n  \"code\": \"1\",\n   \"msg\": 'xxxxxx'\n}\n\n HTTP/1.1 5xx\n{\n  \"code\": \"2\",\n   \"msg\": '请求方式错误'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Operate/OperateIndexController.php",
    "groupTitle": "operate",
    "name": "PostAdminOperateAddappoininformations"
  },
  {
    "type": "post",
    "url": "admin/operate/createBannerAd",
    "title": "新增页面上的广告",
    "group": "operate",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "imgName",
            "description": "<p>图片名称</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "imgAlt",
            "description": "<p>图片alt</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "reUrl",
            "description": "<p>点击跳转的路由</p>"
          },
          {
            "group": "Parameter",
            "type": "file",
            "optional": false,
            "field": "img",
            "description": "<p>图片</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "urlId",
            "description": "<p>页面的id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"上传成功\"\n}",
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
          "content": "HTTP/1.1 40x\n{\n  \"code\": \"1\",\n   \"msg\": 'xxxxxx'\n}\n\n HTTP/1.1 5xx\n{\n  \"code\": \"2\",\n   \"msg\": '请求方式错误'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Operate/BillboardController.php",
    "groupTitle": "operate",
    "name": "PostAdminOperateCreatebannerad"
  },
  {
    "type": "post",
    "url": "admin/operate/createBannerAd",
    "title": "新增一级页面上的banner",
    "group": "operate",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "imgName",
            "description": "<p>图片名称</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "imgAlt",
            "description": "<p>图片alt</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "reUrl",
            "description": "<p>点击跳转的路由</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "img",
            "description": "<p>图片</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "urlId",
            "description": "<p>一级页面的id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"上传成功\"\n}",
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
          "content": "HTTP/1.1 40x\n{\n  \"code\": \"1\",\n   \"msg\": 'xxxxxx'\n}\n\n HTTP/1.1 5xx\n{\n  \"code\": \"2\",\n   \"msg\": '请求方式错误'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Operate/BannerController.php",
    "groupTitle": "operate",
    "name": "PostAdminOperateCreatebannerad"
  },
  {
    "type": "post",
    "url": "admin/operate/deleteAppoIninInformation",
    "title": "删除指定区域上的指定资讯",
    "group": "operate",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "ininInformationId",
            "description": "<p>要删除的资讯的id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"删除成功\"\n}",
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
          "content": "HTTP/1.1 40x\n{\n  \"code\": \"1\",\n   \"msg\": 'xxxxxx'\n}\n\n HTTP/1.1 5xx\n{\n  \"code\": \"2\",\n   \"msg\": '请求方式错误'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Operate/OperateIndexController.php",
    "groupTitle": "operate",
    "name": "PostAdminOperateDeleteappoinininformation"
  },
  {
    "type": "post",
    "url": "admin/operate/deleteBannerAd",
    "title": "删除页面上的指定广告",
    "group": "operate",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "btId",
            "description": "<p>要删除的Billboard的id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"删除成功\"\n}",
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
          "content": "HTTP/1.1 40x\n{\n  \"code\": \"1\",\n   \"msg\": 'xxxxxx'\n}\n\n HTTP/1.1 5xx\n{\n  \"code\": \"2\",\n   \"msg\": '请求方式错误'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Operate/BillboardController.php",
    "groupTitle": "operate",
    "name": "PostAdminOperateDeletebannerad"
  },
  {
    "type": "post",
    "url": "admin/operate/deleteBannerAd",
    "title": "删除一级页面上的Banner",
    "group": "operate",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "btId",
            "description": "<p>要删除的Banner的id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"删除成功\"\n}",
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
          "content": "HTTP/1.1 40x\n{\n  \"code\": \"1\",\n   \"msg\": 'xxxxxx'\n}\n\n HTTP/1.1 5xx\n{\n  \"code\": \"2\",\n   \"msg\": '请求方式错误'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Operate/BannerController.php",
    "groupTitle": "operate",
    "name": "PostAdminOperateDeletebannerad"
  },
  {
    "type": "post",
    "url": "admin/operate/getAllPageListName",
    "title": "获得所有页面的名称",
    "group": "operate",
    "description": "<p>在广告位管理页面调用，获得顶部各页的名称，不需要传递参数</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "obj",
            "description": "<p>页面名称json</p>"
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
          "content": "HTTP/1.1 40x\n{\n  \"code\": \"1\",\n   \"msg\": '请求失败'\n}\n\n HTTP/1.1 5xx\n{\n  \"code\": \"2\",\n   \"msg\": '请求方式错误'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Operate/BillboardController.php",
    "groupTitle": "operate",
    "name": "PostAdminOperateGetallpagelistname"
  },
  {
    "type": "post",
    "url": "admin/operate/getAppointPageBillboard",
    "title": "获得指定页面的广告",
    "group": "operate",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "pageId",
            "description": "<p>页面id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "btType",
            "description": "<p>banner-Or-Billboard的类型　０是banner类型，1是广告类型,这里应该传入1</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"\",\n\"data\": {\n\n         {\n             \"id\":\"xxx\",\n             \"img\":\"xxxxxxxxxxxx\",\n             \"img_alt\":\"front/test/test\",\n             \"re_rul\":\"xxxxxxxxxxxx\",\n             \"re_alt\":\"xxxxxxxxxxxx\",\n             \"show_weight\":\"xxxxxxxxxxxx\",\n             \"create_time\":\"xxxxxxxxxxxx\"\n         }\n  }\n}",
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
          "content": "HTTP/1.1 40x\n{\n  \"code\": \"1\",\n   \"msg\": '请求失败'\n}\n\n HTTP/1.1 5xx\n{\n  \"code\": \"2\",\n   \"msg\": '请求方式错误'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Operate/BillboardController.php",
    "groupTitle": "operate",
    "name": "PostAdminOperateGetappointpagebillboard"
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
            "description": "<p>banner的类型　０是banner类型，1是广告类型</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"\",\n\"data\": {\n\n         {\n             \"id\":\"xxx\",\n             \"img\":\"xxxxxxxxxxxx\",\n             \"img_alt\":\"front/test/test\",\n             \"re_rul\":\"xxxxxxxxxxxx\",\n             \"re_alt\":\"xxxxxxxxxxxx\",\n             \"show_weight\":\"xxxxxxxxxxxx\",\n             \"create_time\":\"xxxxxxxxxxxx\"\n         }\n  }\n}",
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
          "content": "HTTP/1.1 40x\n{\n  \"code\": \"1\",\n   \"msg\": '请求失败'\n}\n\n HTTP/1.1 5xx\n{\n  \"code\": \"2\",\n   \"msg\": '请求方式错误'\n}",
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
    "url": "admin/operate/getIndexBanner",
    "title": "获得指定区域的资讯内容",
    "group": "operate",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "regionId",
            "description": "<p>指定区域的id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"\",\n\"data\": {\n\n         {\n             \"id\":\"xxx\",\n             \"show_weight\":\"xxxxxxxxxxxx\",\n             \"title\":\"front/test/test\",\n             \"information_type\":\"xxxxxxxxxxxx\",\n             \"create_time\":\"xxxxxxxxxxxx\"\n         }\n  }\n}",
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
          "content": "HTTP/1.1 40x\n{\n  \"code\": \"1\",\n   \"msg\": '请求失败'\n}\n\n HTTP/1.1 5xx\n{\n  \"code\": \"2\",\n   \"msg\": '请求方式错误'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Operate/OperateIndexController.php",
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
          "content": "HTTP/1.1 40x\n{\n  \"code\": \"1\",\n   \"msg\": '请求失败'\n}\n\n HTTP/1.1 5xx\n{\n  \"code\": \"2\",\n   \"msg\": '请求方式错误'\n}",
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
    "type": "post",
    "url": "admin/operate/getInformationType",
    "title": "获取所有资讯类型",
    "group": "operate",
    "description": "<p>在资讯频道首页推荐-添加列表页面调用，获得所有资讯的类型，不需要传递参数</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "obj",
            "description": "<p>资讯类型名称</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"\",\n\"data\": {\n\n         {\n             \"id\":\"xxx\",\n             \"name\":\"xxxxxxxxxxxx\"\n         }\n  }\n}",
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
          "content": "HTTP/1.1 40x\n{\n  \"code\": \"1\",\n   \"msg\": '请求失败'\n}\n\n HTTP/1.1 5xx\n{\n  \"code\": \"2\",\n   \"msg\": '请求方式错误'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Operate/OperateIndexController.php",
    "groupTitle": "operate",
    "name": "PostAdminOperateGetinformationtype"
  },
  {
    "type": "post",
    "url": "admin/operate/getInformPagingData",
    "title": "获取咨询列表添加分页数据",
    "group": "operate",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "pageNumber",
            "description": "<p>跳转页面下标</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "pageCount",
            "description": "<p>页面显示行数</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "sortType",
            "description": "<p>排序方式</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"\",\n\"data\": {\n\n         {\n             \"id\":\"xxx\",\n             \"name\":\"xxxxxxxxxxxx\",\n             \"information_type\":\"xxxxxxxxxxxx\",\n             \"create_time\":\"xxxxxxxxxxxx\"\n         }\n  }\n}",
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
          "content": "HTTP/1.1 40x\n{\n  \"code\": \"1\",\n   \"msg\": '请求失败'\n}\n\n HTTP/1.1 5xx\n{\n  \"code\": \"2\",\n   \"msg\": '请求方式错误'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Operate/OperateIndexController.php",
    "groupTitle": "operate",
    "name": "PostAdminOperateGetinformpagingdata"
  },
  {
    "type": "post",
    "url": "admin/operate/getPagingCount",
    "title": "获得不同类别的分享总数",
    "group": "operate",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "type",
            "description": "<p>分享类别</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"\",\n\"data\": {\n     5\n  }\n}",
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
          "content": "HTTP/1.1 40x\n{\n  \"code\": \"1\",\n   \"msg\": '请求失败'\n}\n\n HTTP/1.1 5xx\n{\n  \"code\": \"2\",\n   \"msg\": '请求方式错误'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Operate/ShareAdminController.php",
    "groupTitle": "operate",
    "name": "PostAdminOperateGetpagingcount"
  },
  {
    "type": "post",
    "url": "admin/operate/getPagingData",
    "title": "获取分页数据",
    "group": "operate",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "pageNumber",
            "description": "<p>跳转页面下标</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "pageCount",
            "description": "<p>页面显示行数</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "sortType",
            "description": "<p>排序类型(按总浏览量０;按总引流（分享次数）１;按微信分享次数２;按微博分享次数３;按微信浏览量４;按微博浏览量５)</p>"
          },
          {
            "group": "Parameter",
            "type": "NUmber",
            "optional": false,
            "field": "riseOrDrop",
            "description": "<p>排序方式(0升序；1降序)</p>"
          },
          {
            "group": "Parameter",
            "type": "NUmber",
            "optional": false,
            "field": "contentType",
            "description": "<p>内容类型(0院校专业主页；1活动详情；2资讯详情；3总量)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "titleKeyword",
            "description": "<p>标题关键字</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"\",\n\"data\": {\n\n         {\n             \"id\":\"xxx\",\n             \"name\":\"xxxxxxxxxxxx\",\n             \"wx_count\":\"xxxxxxxxxxxx\",\n             \"wb_count\":\"xxxxxxxxxxxx\",\n             \"wx_browse\":\"xxxxxxxxxxxx\",\n             \"wb_browse\":\"xxxxxxxxxxxx\"\n         }\n  }\n}",
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
          "content": "HTTP/1.1 40x\n{\n  \"code\": \"1\",\n   \"msg\": '请求失败'\n}\n\n HTTP/1.1 5xx\n{\n  \"code\": \"2\",\n   \"msg\": '请求方式错误'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Operate/ShareAdminController.php",
    "groupTitle": "operate",
    "name": "PostAdminOperateGetpagingdata"
  },
  {
    "type": "post",
    "url": "admin/operate/selectAppointInformData",
    "title": "获得咨询列表添加页查询的指定数据",
    "group": "operate",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "informationTypeId",
            "description": "<p>资讯类型id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "titleKeyword",
            "description": "<p>标题关键字</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"\",\n\"data\": {\n\n         {\n             \"id\":\"xxx\",\n             \"name\":\"xxxxxxxxxxxx\",\n             \"information_type\":\"xxxxxxxxxxxx\",\n             \"create_time\":\"xxxxxxxxxxxx\"\n         }\n  }\n}",
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
          "content": "HTTP/1.1 40x\n{\n  \"code\": \"1\",\n   \"msg\": '请求失败'\n}\n\n HTTP/1.1 5xx\n{\n  \"code\": \"2\",\n   \"msg\": '请求方式错误'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Operate/OperateIndexController.php",
    "groupTitle": "operate",
    "name": "PostAdminOperateSelectappointinformdata"
  },
  {
    "type": "post",
    "url": "admin/operate/setAppoinInformationWeight",
    "title": "设置指定资讯的权重",
    "group": "operate",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "informationId",
            "description": "<p>指定资讯的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "weight",
            "description": "<p>要修改的权重，默认为0</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"更新成功\"\n}",
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
          "content": "HTTP/1.1 40x\n{\n  \"code\": \"1\",\n   \"msg\": '更新失败/参数错误'\n}\n\n HTTP/1.1 5xx\n{\n  \"code\": \"2\",\n   \"msg\": '请求方式错误'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Operate/OperateIndexController.php",
    "groupTitle": "operate",
    "name": "PostAdminOperateSetappoininformationweight"
  },
  {
    "type": "post",
    "url": "admin/operate/setAppointRegionName",
    "title": "修改指定区域的名称",
    "group": "operate",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "regionId",
            "description": "<p>指定区域的id,0是区域一;1是区域二</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "regionName",
            "description": "<p>要修改的名称</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"更新成功\"\n}",
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
          "content": "HTTP/1.1 40x\n{\n  \"code\": \"1\",\n   \"msg\": '更新失败/参数错误'\n}\n\n HTTP/1.1 5xx\n{\n  \"code\": \"2\",\n   \"msg\": '请求方式错误'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Operate/OperateIndexController.php",
    "groupTitle": "operate",
    "name": "PostAdminOperateSetappointregionname"
  },
  {
    "type": "post",
    "url": "admin/operate/setBillboardMessage",
    "title": "修改页面上指定广告的信息",
    "group": "operate",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "btName",
            "description": "<p>图片名称</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "btImgAlt",
            "description": "<p>图片alt</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "reUrl",
            "description": "<p>点击跳转的路由</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "btId",
            "description": "<p>Billboard的id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"更新成功\"\n}",
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
          "content": "HTTP/1.1 40x\n{\n  \"code\": \"1\",\n   \"msg\": 'xxxxxx'\n}\n\n HTTP/1.1 5xx\n{\n  \"code\": \"2\",\n   \"msg\": '请求方式错误'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Operate/BillboardController.php",
    "groupTitle": "operate",
    "name": "PostAdminOperateSetbillboardmessage"
  },
  {
    "type": "post",
    "url": "admin/operate/setBillboardWeight",
    "title": "设置页面上广告的权重",
    "group": "operate",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "billboardId",
            "description": "<p>指定广告的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "weight",
            "description": "<p>要修改的权重，默认为0</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"更新成功\"\n}",
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
          "content": "HTTP/1.1 40x\n{\n  \"code\": \"1\",\n   \"msg\": '更新失败/参数错误'\n}\n\n HTTP/1.1 5xx\n{\n  \"code\": \"2\",\n   \"msg\": '请求方式错误'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Operate/BillboardController.php",
    "groupTitle": "operate",
    "name": "PostAdminOperateSetbillboardweight"
  },
  {
    "type": "post",
    "url": "admin/operate/setBtMessage",
    "title": "修改一级页面上指定banner的信息",
    "group": "operate",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "btName",
            "description": "<p>图片名称</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "btImgAlt",
            "description": "<p>图片alt</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "reUrl",
            "description": "<p>点击跳转的路由</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "btId",
            "description": "<p>Banner的id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"更新成功\"\n}",
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
          "content": "HTTP/1.1 40x\n{\n  \"code\": \"1\",\n   \"msg\": 'xxxxxx'\n}\n\n HTTP/1.1 5xx\n{\n  \"code\": \"2\",\n   \"msg\": '请求方式错误'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Operate/BannerController.php",
    "groupTitle": "operate",
    "name": "PostAdminOperateSetbtmessage"
  },
  {
    "type": "post",
    "url": "admin/operate/setBtWeight",
    "title": "设置一级页面上banner的权重",
    "group": "operate",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "bannerAdId",
            "description": "<p>指定banner的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "weight",
            "description": "<p>要修改的权重，默认为0</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"更新成功\"\n}",
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
          "content": "HTTP/1.1 40x\n{\n  \"code\": \"1\",\n   \"msg\": '更新失败/参数错误'\n}\n\n HTTP/1.1 5xx\n{\n  \"code\": \"2\",\n   \"msg\": '请求方式错误'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Operate/BannerController.php",
    "groupTitle": "operate",
    "name": "PostAdminOperateSetbtweight"
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
