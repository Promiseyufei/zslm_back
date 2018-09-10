define({ "api": [
  {
    "type": "post",
    "url": "/admin/files/deleteFile",
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
            "field": "fileId",
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
    "url": "/admin/files/updateFile",
    "title": "更新文件",
    "name": "updateFile",
    "group": "Files",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "fileId",
            "description": "<p>文件id</p>"
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
    "url": "/admin/files/uploadFile",
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
    "type": "get",
    "url": "admin/information/deleteAppointProject",
    "title": "删除指定的招生项目",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "projectId",
            "description": "<p>指定招生项目的id</p>"
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
    "filename": "app/Http/Controllers/Admin/Information/StudentProjectController.php",
    "groupTitle": "information",
    "name": "GetAdminInformationDeleteappointproject"
  },
  {
    "type": "get",
    "url": "admin/information/getAllBranchCoach",
    "title": "查看指定总校的所有分校，注意分页",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "totalCoachId",
            "description": "<p>总部id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "pageNum",
            "description": "<p>下标</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"\",\n\"data\": {\n\n         {\n             \"id\":\"xxx\",\n             \"name\":\"xxxxxxxxxxxx\",\n             \"weight\":\"xxxxxxxxxxxx\",\n             \"is_show\":\"xxxx\"\n             \"update_time\":\"xx\"\n         }\n  }\n}",
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
    "filename": "app/Http/Controllers/Admin/Information/CoachOrganizeController.php",
    "groupTitle": "information",
    "name": "GetAdminInformationGetallbranchcoach"
  },
  {
    "type": "get",
    "url": "admin/information/getAllProject",
    "title": "获得指定专业的招生项目（注意需要分页）",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "majorId",
            "description": "<p>专业id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "pageNum",
            "description": "<p>下标</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"\",\n\"data\": {\n\n         {\n             \"id\":\"xxx\",\n             \"name\":\"xxxxxxxxxxxx\",\n             \"weight\":\"xxxxxxxxxxxx\",\n             \"is_show\":\"xxxx\"\n             \"update_time\":\"xx\"\n         }\n  }\n}",
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
    "filename": "app/Http/Controllers/Admin/Information/StudentProjectController.php",
    "groupTitle": "information",
    "name": "GetAdminInformationGetallproject"
  },
  {
    "type": "get",
    "url": "admin/information/selectActivityReception",
    "title": "跳转到前台对应的活动主页",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "activityId",
            "description": "<p>指定活动的id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "重定向到前台对应的活动详情页",
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
          "content": "HTTP/1.1 40x\n{\n  \"code\": \"1\",\n   \"msg\": '跳转失败'\n}\n\n HTTP/1.1 5xx\n{\n  \"code\": \"2\",\n   \"msg\": '请求方式错误'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Information/ActivityController.php",
    "groupTitle": "information",
    "name": "GetAdminInformationSelectactivityreception"
  },
  {
    "type": "get",
    "url": "admin/information/selectCoachReception",
    "title": "跳转到前台对应的辅导机构主页",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "coachId",
            "description": "<p>指定辅导机构的id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "重定向到前台对应的活动详情页",
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
          "content": "HTTP/1.1 40x\n{\n  \"code\": \"1\",\n   \"msg\": '跳转失败'\n}\n\n HTTP/1.1 5xx\n{\n  \"code\": \"2\",\n   \"msg\": '请求方式错误'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Information/CoachOrganizeController.php",
    "groupTitle": "information",
    "name": "GetAdminInformationSelectcoachreception"
  },
  {
    "type": "get",
    "url": "admin/information/selectInfoReception",
    "title": "跳转到前台对应的咨询详情页",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "infoId",
            "description": "<p>指定资讯的id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "重定向到前台对应的活动详情页",
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
          "content": "HTTP/1.1 40x\n{\n  \"code\": \"1\",\n   \"msg\": '跳转失败'\n}\n\n HTTP/1.1 5xx\n{\n  \"code\": \"2\",\n   \"msg\": '请求方式错误'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Information/InformationController.php",
    "groupTitle": "information",
    "name": "GetAdminInformationSelectinforeception"
  },
  {
    "type": "get",
    "url": "admin/information/selectReception",
    "title": "跳转到前台对应的院校专业主页",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "majorId",
            "description": "<p>指定院校专业的id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "重定向到前台对应的院校专业主页",
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
          "content": "HTTP/1.1 40x\n{\n  \"code\": \"1\",\n   \"msg\": '跳转失败'\n}\n\n HTTP/1.1 5xx\n{\n  \"code\": \"2\",\n   \"msg\": '请求方式错误'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Information/MajorController.php",
    "groupTitle": "information",
    "name": "GetAdminInformationSelectreception"
  },
  {
    "type": "post",
    "url": "admin/information/createActivity",
    "title": "新建活动",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "activityName",
            "description": "<p>活动名称</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "activityType",
            "description": "<p>活动类型</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "majorType",
            "description": "<p>专业类型</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "province",
            "description": "<p>活动省市</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "address",
            "description": "<p>活动地址</p>"
          },
          {
            "group": "Parameter",
            "type": "timeInt",
            "optional": false,
            "field": "beginTime",
            "description": "<p>开始时间</p>"
          },
          {
            "group": "Parameter",
            "type": "timeInt",
            "optional": false,
            "field": "endTime",
            "description": "<p>结束时间</p>"
          },
          {
            "group": "Parameter",
            "type": "NUmber",
            "optional": false,
            "field": "signUpState",
            "description": "<p>报名状态</p>"
          },
          {
            "group": "Parameter",
            "type": "FormData",
            "optional": false,
            "field": "activeImg",
            "description": "<p>活动封面图</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<p>主页优化</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "keywords",
            "description": "<p>主页优化</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>主页优化</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "introduce",
            "description": "<p>活动介绍</p>"
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
    "filename": "app/Http/Controllers/Admin/Information/ActivityController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationCreateactivity"
  },
  {
    "type": "post",
    "url": "admin/information/createCoach",
    "title": "创建辅导机构(注意分校/总校的判定)",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "coachName",
            "description": "<p>辅导机构名称</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "provice",
            "description": "<p>所在省市</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "phone",
            "description": "<p>联系方式</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "address",
            "description": "<p>地址</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "webUrl",
            "description": "<p>网址</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "CoachForm",
            "description": "<p>辅导形式(0是总部，１是分校)</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "totalCoachId",
            "description": "<p>辅导总部id(CoachForm为1的情况下，传过来分校的父级id)</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "couponsType",
            "description": "<p>是否支持优惠券(０支持，１不支持)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "backMoneyType",
            "description": "<p>是否支持退款(0支持，１不支持)</p>"
          },
          {
            "group": "Parameter",
            "type": "File",
            "optional": false,
            "field": "coverName",
            "description": "<p>辅导机构的封面图</p>"
          },
          {
            "group": "Parameter",
            "type": "File",
            "optional": false,
            "field": "logoName",
            "description": "<p>辅导机构logo</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<p>页面优化</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "keywords",
            "description": "<p>页面优化</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>页面优化</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"创建成功\"\n}",
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
    "filename": "app/Http/Controllers/Admin/Information/CoachOrganizeController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationCreatecoach"
  },
  {
    "type": "post",
    "url": "admin/information/createCoupon",
    "title": "更新指定优惠券的字段信息",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "couponId",
            "description": "<p>优惠券id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "couponName",
            "description": "<p>优惠券名称</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "couponType",
            "description": "<p>优惠券类型(0:满减型; 1:优惠型)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "context",
            "description": "<p>优惠券内容</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "couponcol",
            "description": "<p>优惠券说明</p>"
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
    "filename": "app/Http/Controllers/Admin/Information/CouponController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationCreatecoupon"
  },
  {
    "type": "post",
    "url": "admin/information/createCoupon",
    "title": "新增优惠券",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "coachId",
            "description": "<p>所属辅导机构id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "couponName",
            "description": "<p>优惠券名称</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "couponType",
            "description": "<p>优惠券类型(0:满减型; 1:优惠型)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "context",
            "description": "<p>优惠券内容</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "couponcol",
            "description": "<p>优惠券说明</p>"
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
    "filename": "app/Http/Controllers/Admin/Information/CouponController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationCreatecoupon"
  },
  {
    "type": "post",
    "url": "admin/information/createInfo",
    "title": "添加资讯",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "infoName",
            "description": "<p>资讯的标题</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "infoType",
            "description": "<p>资讯类型</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "infoFrom",
            "description": "<p>资讯来源</p>"
          },
          {
            "group": "Parameter",
            "type": "File",
            "optional": false,
            "field": "infoImage",
            "description": "<p>资讯封面图</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "infoText",
            "description": "<p>资讯内容</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<p>页面优化</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "keywords",
            "description": "<p>页面优化</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>页面优化</p>"
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
    "filename": "app/Http/Controllers/Admin/Information/InformationController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationCreateinfo"
  },
  {
    "type": "post",
    "url": "admin/information/createMajor",
    "title": "新建院校专业",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "approval",
            "description": "<p>审批年限</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "majorAuth",
            "description": "<p>院校专业认证</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "majorNature",
            "description": "<p>院校性质</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "indexWeb",
            "description": "<p>院校官网</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "majorProvince",
            "description": "<p>所在省市</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "majorAddress",
            "description": "<p>院校地址</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "phone",
            "description": "<p>咨询电话</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "admissionsWeb",
            "description": "<p>招生专题</p>"
          },
          {
            "group": "Parameter",
            "type": "FileData",
            "optional": false,
            "field": "wcImage",
            "description": "<p>院校官方微信公众号</p>"
          },
          {
            "group": "Parameter",
            "type": "FileData",
            "optional": false,
            "field": "wbImage",
            "description": "<p>院校官方新浪微博帐号</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "schoolId",
            "description": "<p>院校关联</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "majorName",
            "description": "<p>专业名称</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "majorType",
            "description": "<p>专业类型</p>"
          },
          {
            "group": "Parameter",
            "type": "FileData",
            "optional": false,
            "field": "magorLogo",
            "description": "<p>院校专业封面图</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<p>页面优化</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "keywords",
            "description": "<p>页面优化</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>页面优化</p>"
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
    "filename": "app/Http/Controllers/Admin/Information/MajorController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationCreatemajor"
  },
  {
    "type": "post",
    "url": "admin/information/createProject",
    "title": "新创建招生项目",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "projectName",
            "description": "<p>招生项目名称</p>"
          },
          {
            "group": "Parameter",
            "type": "Float",
            "optional": false,
            "field": "minCost",
            "description": "<p>招生项目最小费用</p>"
          },
          {
            "group": "Parameter",
            "type": "Float",
            "optional": false,
            "field": "maxCost",
            "description": "<p>招生项目最大费用</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "cost",
            "description": "<p>招生项目费用</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "studentCount",
            "description": "<p>招生名额</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "language",
            "description": "<p>授课语言</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "classSituation",
            "description": "<p>班级情况</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "eductionalSystme",
            "description": "<p>学制</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "canConditions",
            "description": "<p>报考条件</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "scoreDescribe",
            "description": "<p>分数线描述</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "graduationCertificate",
            "description": "<p>毕业证书</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "recruitmentPattern",
            "description": "<p>统招模式</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "enrollmentMode",
            "description": "<p>招生模式</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "professionalDirection",
            "description": "<p>专业方向</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"创建成功\"\n}",
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
    "filename": "app/Http/Controllers/Admin/Information/StudentProjectController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationCreateproject"
  },
  {
    "type": "post",
    "url": "admin/information/deleteActivity",
    "title": "删除指定的活动",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "activityId",
            "description": "<p>指定活动的id</p>"
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
    "filename": "app/Http/Controllers/Admin/Information/ActivityController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationDeleteactivity"
  },
  {
    "type": "post",
    "url": "admin/information/deleteAppointCoach",
    "title": "删除指定的辅导机构(注意删除总校时所有的分校也需要删除)",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "coachId",
            "description": "<p>指定辅导机构的id</p>"
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
    "filename": "app/Http/Controllers/Admin/Information/CoachOrganizeController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationDeleteappointcoach"
  },
  {
    "type": "post",
    "url": "admin/information/deleteAppointInfo",
    "title": "删除指定资讯",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "infoId",
            "description": "<p>指定活动的id</p>"
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
    "filename": "app/Http/Controllers/Admin/Information/InformationController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationDeleteappointinfo"
  },
  {
    "type": "post",
    "url": "admin/information/deleteMajor",
    "title": "删除指定的院校专业",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "majorId",
            "description": "<p>指定院校专业的id</p>"
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
    "filename": "app/Http/Controllers/Admin/Information/MajorController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationDeletemajor"
  },
  {
    "type": "post",
    "url": "admin/information/getActivityPageCount",
    "title": "获取活动列表页分页数据总数",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "conditionArr",
            "description": "<p>筛选条件</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"\",\n\"data\": {\n        count:240\n  }\n}",
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
    "filename": "app/Http/Controllers/Admin/Information/ActivityController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationGetactivitypagecount"
  },
  {
    "type": "post",
    "url": "admin/information/getActivityPageMessage",
    "title": "获取活动列表页分页数据",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "activityNameKeyword",
            "description": "<p>活动名称关键字</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "screenType",
            "description": "<p>筛选方式(0按展示状态；1按推荐状态;2活动状态；3全部)</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "screenState",
            "description": "<p>筛选状态(0展示/推荐；1不展示/不推荐;2全部)</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "activityState",
            "description": "<p>活动状态(0未开始；1进行中;2已结束；3全部)</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "sortType",
            "description": "<p>排序类型(0按权重升序；1按权重降序;2按信息更新时间)</p>"
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
            "field": "pageNumber",
            "description": "<p>跳转页面下标</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"\",\n\"data\": {\n\n         {\n             \"id\":\"xxx\",\n             \"name\":\"活动名称\",\n             \"weight\":\"活动权重\",\n             \"is_show\":\"是否展示\",\n             \"if_recommended\":\"是否推荐\",\n             \"active_type\":\"活动类型\",\n             \"major_type\":\"专业类型\",\n             \"province\":\"所在省市\",\n             \"address\":\"活动地址\",\n             \"begin_time\":\"活动开始时间\",\n             \"end_time\":\"活动结束时间\",\n             \"host_school\":\"活动主办院校\",\n             \"sign_up_state\":\"报名状态\",\n             \"update_time\":\"信息更新时间\"\n         }\n  }\n}",
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
    "filename": "app/Http/Controllers/Admin/Information/ActivityController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationGetactivitypagemessage"
  },
  {
    "type": "post",
    "url": "admin/information/getActivityType",
    "title": "获得活动类型字典",
    "group": "information",
    "success": {
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
    "filename": "app/Http/Controllers/Admin/Information/ActivityController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationGetactivitytype"
  },
  {
    "type": "post",
    "url": "admin/information/getAllActivitys",
    "title": "获得所有的活动",
    "group": "information",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"\",\n\"data\": {\n\n         {\n             \"id\":\"xxx\",\n             \"active_name\":\"xxxxxxxxxxxx\",\n             \"xxx\":\"xxx\"\n         }\n  }\n}",
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
    "filename": "app/Http/Controllers/Admin/Information/ActivityController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationGetallactivitys"
  },
  {
    "type": "post",
    "url": "admin/information/getAllCollege",
    "title": "获得所有的院校专业(在设置相关院校和推荐院校的手动设置时使用)",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "type",
            "description": "<p>在设置相关院校时获取还是在设置推荐院校时获取(0设置相关院校时;1设置推荐院校时)</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "infoId",
            "description": "<p>咨询id(在设置资讯相关院校时需要将指定资讯id发送给后台，默认情况为0)</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"\",\n\"data\": {\n\n         {\n             \"id\":\"xxx\",\n             \"active_name\":\"xxxxxxxxxxxx\",\n             \"xxx\":\"xxx\"\n         }\n  }\n}",
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
    "filename": "app/Http/Controllers/Admin/Information/InformationController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationGetallcollege"
  },
  {
    "type": "post",
    "url": "admin/information/getAllInfo",
    "title": "获得所有的资讯(在设置推荐阅读的手动设置时使用)",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "pageNumber",
            "description": "<p>分页下标</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "pageCount",
            "description": "<p>每页显示数量</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"\",\n\"data\": {\n\n         {\n             \"id\":\"xxx\",\n             \"active_name\":\"xxxxxxxxxxxx\",\n             \"xxx\":\"xxx\"\n         }\n  }\n}",
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
    "filename": "app/Http/Controllers/Admin/Information/InformationController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationGetallinfo"
  },
  {
    "type": "post",
    "url": "admin/information/getAllMajor",
    "title": "获得所有专业字典",
    "group": "information",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"\",\n\"data\": {\n\n         {\n             \"id\":\"xxx\",\n             \"name\":\"xxxxxxxxxxxx\",\n             \"xxx\":\"xxx\"\n         }\n  }\n}",
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
    "filename": "app/Http/Controllers/Admin/Information/ActivityController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationGetallmajor"
  },
  {
    "type": "post",
    "url": "admin/information/getAllSchoolName",
    "title": "获得院校名称字典",
    "group": "information",
    "success": {
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
    "filename": "app/Http/Controllers/Admin/Information/MajorController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationGetallschoolname"
  },
  {
    "type": "post",
    "url": "admin/information/getAppointCoupon",
    "title": "设置指定的辅导机构的优惠券(跳转到优惠券新增页的列表页，注意分页)",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "CoachId",
            "description": "<p>辅导机构的id</p>"
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
            "field": "pageNumber",
            "description": "<p>跳转页面下标</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"\",\n\"data\": {\n\n         {\n             \"id\":\"xxx\",\n             \"name\":\"优惠券名称\",\n             \"type\":\"优惠券类型(0:满减型; 1:优惠型)\",\n             \"context\":\"优惠券内容\",\n             \"zslm_couponcol\":\"优惠券的使用说明\",\n             \"is_enable\":\"优惠券的启用状态(０：已启用　１：已禁用)\"\n         }\n  }\n}",
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
    "filename": "app/Http/Controllers/Admin/Information/CouponController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationGetappointcoupon"
  },
  {
    "type": "post",
    "url": "admin/information/getFractionLineType",
    "title": "获得分数线类型字典",
    "group": "information",
    "success": {
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
    "filename": "app/Http/Controllers/Admin/Information/StudentProjectController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationGetfractionlinetype"
  },
  {
    "type": "post",
    "url": "admin/information/getInfoPageCount",
    "title": "获取资讯列表页分页数据总数",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "conditionArr",
            "description": "<p>筛选条件</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"\",\n\"data\": {\n        count:240\n  }\n}",
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
    "filename": "app/Http/Controllers/Admin/Information/InformationController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationGetinfopagecount"
  },
  {
    "type": "post",
    "url": "admin/information/getInfoPageMsg",
    "title": "咨询列表页分页",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "infoNameKeyword",
            "description": "<p>咨询名称关键字</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "screenType",
            "description": "<p>筛选方式(0按展示状态；1按推荐状态;２咨询类型;3全部)</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "infoType",
            "description": "<p>咨询类型(0全部，非零传输咨询类型id)</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "screenState",
            "description": "<p>筛选状态(0展示/推荐；1不展示/不推荐;2全部)</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "sortType",
            "description": "<p>排序(0按权重升序，1按权重降序，2按更新时间降序(默认))</p>"
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
            "field": "pageNumber",
            "description": "<p>跳转页面下标</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"\",\n\"data\": {\n\n         {\n             \"id\":\"xxx\",\n             \"zx_name\":\"咨询名称\",\n             \"weight\":\"展示权重\",\n             \"is_show\":\"展示状态(0展示；1不展示)\",\n             \"is_recommend\":\"推荐状态(0推荐，1不推荐)\",\n             \"z_type\":\"咨询类型\",\n             \"z_from\":\"咨询来源\",\n             \"update_time\":\"信息更新时间\"\n         }\n  }\n}",
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
    "filename": "app/Http/Controllers/Admin/Information/InformationController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationGetinfopagemsg"
  },
  {
    "type": "post",
    "url": "admin/information/getMajorAuthentication",
    "title": "获得院校专业认证字典",
    "group": "information",
    "success": {
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
    "filename": "app/Http/Controllers/Admin/Information/MajorController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationGetmajorauthentication"
  },
  {
    "type": "post",
    "url": "admin/information/getMajorDirection",
    "title": "获得专业方向字典",
    "group": "information",
    "success": {
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
    "filename": "app/Http/Controllers/Admin/Information/StudentProjectController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationGetmajordirection"
  },
  {
    "type": "post",
    "url": "admin/information/getMajorNature",
    "title": "获得院校性质字典",
    "group": "information",
    "success": {
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
    "filename": "app/Http/Controllers/Admin/Information/MajorController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationGetmajornature"
  },
  {
    "type": "post",
    "url": "admin/information/getMajorPageCount",
    "title": "获取院校专业列表页分页数据总数",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "conditionArr",
            "description": "<p>筛选条件</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"\",\n\"data\": {\n        count:240\n  }\n}",
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
            "description": "<p>这里是失败时返回实例numeric</p>"
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
    "filename": "app/Http/Controllers/Admin/Information/MajorController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationGetmajorpagecount"
  },
  {
    "type": "post",
    "url": "admin/information/getMajorPageMessage",
    "title": "获取院校专业列表页分页数据",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "majorNameKeyword",
            "description": "<p>专业名称关键字</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "screenType",
            "description": "<p>筛选方式(0按展示状态；1按推荐状态;2全部)</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "screenState",
            "description": "<p>筛选状态(0展示/推荐；1不展示/不推荐;2全部)</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "sortType",
            "description": "<p>排序类型(0按权重升序；1按权重降序;2按信息更新时间)</p>"
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
            "field": "pageNumber",
            "description": "<p>跳转页面下标</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"\",\n\"data\": {\n\n         {\n             \"id\":\"xxx\",\n             \"name\":\"xxxxxxxxxxxx\",\n             \"weight\":\"xxxxxxxxxxxx\",\n             \"is_show\":\"xxxxxx\",\n             \"if_recommended\":\"xxxxxxxxxxxx\",\n             \"student_project_count\":\"xxx\",\n             \"update_time\":\"xx\"\n         }\n  }\n}",
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
    "filename": "app/Http/Controllers/Admin/Information/MajorController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationGetmajorpagemessage"
  },
  {
    "type": "post",
    "url": "admin/information/getMajorProvincesAndCities",
    "title": "获得所在省市字典表（注意按省分组）",
    "group": "information",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"\",\n\"data\": {\n\n         {\n             \"id\":\"xxx\",\n             \"father_id\":\"0\"\n             \"name\":\"xx省\",\n             \"citys\":{\n                 {\n                     \"id\":\"xx\",\n                     \"name\":\"xx市\"\n                     \"father_id\":\"xx\"\n                 },\n                 {\n                     \"id\":\"xx\",\n                     \"name\":\"xx市\",\n                     \"father_id\":\"xx\"\n                 }\n             }\n         }\n  }\n}",
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
    "filename": "app/Http/Controllers/Admin/Information/MajorController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationGetmajorprovincesandcities"
  },
  {
    "type": "post",
    "url": "admin/information/getMajorProvincesAndCities",
    "title": "获得活动省市字典",
    "group": "information",
    "success": {
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
    "filename": "app/Http/Controllers/Admin/Information/ActivityController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationGetmajorprovincesandcities"
  },
  {
    "type": "post",
    "url": "admin/information/getMajorType",
    "title": "获得专业类型字典",
    "group": "information",
    "success": {
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
    "filename": "app/Http/Controllers/Admin/Information/ActivityController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationGetmajortype"
  },
  {
    "type": "post",
    "url": "admin/information/getMajorType",
    "title": "获得专业类型字典",
    "group": "information",
    "success": {
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
    "filename": "app/Http/Controllers/Admin/Information/MajorController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationGetmajortype"
  },
  {
    "type": "post",
    "url": "admin/information/getPageCoachCount",
    "title": "获取辅导机构列表页分页数据总数",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "conditionArr",
            "description": "<p>筛选条件</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"\",\n\"data\": {\n        count:240\n  }\n}",
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
    "filename": "app/Http/Controllers/Admin/Information/CoachOrganizeController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationGetpagecoachcount"
  },
  {
    "type": "post",
    "url": "admin/information/getPageCoachOrganize",
    "title": "获取活动列表页分页数据",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "soachNameKeyword",
            "description": "<p>辅导机构名称关键字</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "screenType",
            "description": "<p>筛选方式(0按展示状态；1按推荐状态;2是否支持优惠券；3是否支持退款；4全部)</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "screenState",
            "description": "<p>筛选状态(0展示/推荐/支持优惠券/支持退款；1不展示/不推荐/不支持优惠券/不支持退款;2全部)</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "sortType",
            "description": "<p>排序类型(0按权重升序；1按权重降序;2按信息更新时间)</p>"
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
            "field": "pageNumber",
            "description": "<p>跳转页面下标</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"\",\n\"data\": {\n\n         {\n             \"id\":\"xxx\",\n             \"coach_name\":\"辅导机构名称\",\n             \"weight\":\"辅导机构权重\",\n             \"is_show\":\"是否展示\",\n             \"is_recommend\":\"是否推荐\",\n             \"father_id\":\"辅导结构类别(０是总部，非零为分校)\",\n             \"province\":\"所在省市\",\n             \"phone\":\"联系电话\",\n             \"address\":\"具体地址\",\n             \"web_url\":\"网址\",\n             \"coach_type\":\"辅导形式(0线上，1线下，2线上＋线下)\",\n             \"if_coupons\":\"是否支持优惠券\",\n             \"if_back_money\":\"是否支持退款\",\n             \"update_time\":\"信息更新时间\"\n         }\n  }\n}",
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
    "filename": "app/Http/Controllers/Admin/Information/CoachOrganizeController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationGetpagecoachorganize"
  },
  {
    "type": "post",
    "url": "admin/information/getPageCoupon",
    "title": "优惠券列表页(对于辅导机构)分页",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "soachNameKeyword",
            "description": "<p>辅导机构名称关键字</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "screenType",
            "description": "<p>筛选方式(0按是否支持优惠券；1按机构类型;2是全部)</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "screenState",
            "description": "<p>筛选状态(0支持优惠券/总部；1不支持/分校;2全部)</p>"
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
            "field": "pageNumber",
            "description": "<p>跳转页面下标</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"\",\n\"data\": {\n\n         {\n             \"id\":\"xxx\",\n             \"coach_name\":\"辅导机构名称\",\n             \"father_id\":\"辅导结构类别(０是总部，非零为分校)\",\n             \"if_coupons\":\"优惠券启用状态，是否支持优惠券\",\n             \"coupon_count\":\"优惠券的张数\"\n         }\n  }\n}",
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
    "filename": "app/Http/Controllers/Admin/Information/CouponController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationGetpagecoupon"
  },
  {
    "type": "post",
    "url": "admin/information/getUnifiedRecruitPattern",
    "title": "获得统招模式字典",
    "group": "information",
    "success": {
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
    "filename": "app/Http/Controllers/Admin/Information/StudentProjectController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationGetunifiedrecruitpattern"
  },
  {
    "type": "post",
    "url": "admin/information/sendActivityDynamic",
    "title": "活动作为院校动态更新推送给关注了主办院校的用户（插入消息表，并和用户进行关联，推送到个人中心－院校动态中）/活动作为新消息内容发送给关注了主办院校的用户（插入消息表，并和用户关联，推送到消息中心中）",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "activityId",
            "description": "<p>活动的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "majorId",
            "description": "<p>主办院校id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "newOrDyna",
            "description": "<p>设置类别(0,作为院校动态；1作为新消息)</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"设置成功\"\n}",
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
    "filename": "app/Http/Controllers/Admin/Information/ActivityController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationSendactivitydynamic"
  },
  {
    "type": "post",
    "url": "admin/information/sendInfoDynamic",
    "title": "设置指定资讯作为院校动态更新推送给关注了主办院校的用户（插入消息表，并和用户进行关联，推送到个人中心－院校动态中）/资讯作为新消息内容发送给关注了主办院校的用户（插入消息表，并和用户关联，推送到消息中心中）",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "infoId",
            "description": "<p>活动的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "majorIdArr",
            "description": "<p>相关院校院校id数组</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "newOrDyna",
            "description": "<p>设置类别(0作为院校动态；1作为新消息)</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"设置成功\"\n}",
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
    "filename": "app/Http/Controllers/Admin/Information/InformationController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationSendinfodynamic"
  },
  {
    "type": "post",
    "url": "admin/information/setActivityState",
    "title": "设置活动的状态(权重，展示状态，推荐状态)",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "activityId",
            "description": "<p>指定活动的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "type",
            "description": "<p>要修改的状态类型(0修改权重；１修改展示状态；２修改推荐状态;3修改活动状态)</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "state",
            "description": "<p>要修改的值</p>"
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
    "filename": "app/Http/Controllers/Admin/Information/ActivityController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationSetactivitystate"
  },
  {
    "type": "post",
    "url": "admin/information/setAppointCoachCouponsEnable",
    "title": "设置指定辅导机构的优惠券启用状态",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "coachId",
            "description": "<p>指定辅导机构的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "state",
            "description": "<p>要修改的值(０启用；１禁用)</p>"
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
    "filename": "app/Http/Controllers/Admin/Information/CouponController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationSetappointcoachcouponsenable"
  },
  {
    "type": "post",
    "url": "admin/information/setAppointCoachState",
    "title": "设置辅导机构状态(权重，展示状态，推荐状态)",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "coachId",
            "description": "<p>指定辅导机构的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "type",
            "description": "<p>要修改的状态类型(0修改权重；１修改展示状态；２修改推荐状态)</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "state",
            "description": "<p>要修改的值</p>"
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
    "filename": "app/Http/Controllers/Admin/Information/CoachOrganizeController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationSetappointcoachstate"
  },
  {
    "type": "post",
    "url": "admin/information/setAppointCouponEnable",
    "title": "设置指定优惠券的启用状态",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "couponId",
            "description": "<p>指定优惠券的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "state",
            "description": "<p>要修改的值(０启用；１禁用)</p>"
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
    "filename": "app/Http/Controllers/Admin/Information/CouponController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationSetappointcouponenable"
  },
  {
    "type": "post",
    "url": "admin/information/setAppointInfoState",
    "title": "设置咨询的状态值(权重，展示状态，推荐状态)",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "infoId",
            "description": "<p>指定活动的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "type",
            "description": "<p>要修改的状态类型(0修改权重；１修改展示状态；２修改推荐状态)</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "state",
            "description": "<p>要修改的值</p>"
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
    "filename": "app/Http/Controllers/Admin/Information/InformationController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationSetappointinfostate"
  },
  {
    "type": "post",
    "url": "admin/information/setAppointRelationCollege",
    "title": "设置指定资讯的关联院校",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "infoId",
            "description": "<p>指定院校专业的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "majorIdArr",
            "description": "<p>相关院校id数组</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"设置成功\"\n}",
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
    "filename": "app/Http/Controllers/Admin/Information/InformationController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationSetappointrelationcollege"
  },
  {
    "type": "post",
    "url": "admin/information/setAutomaticRecActivitys",
    "title": "自动设置推荐活动",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "activityId",
            "description": "<p>活动的id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"设置成功\"\n}",
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
    "filename": "app/Http/Controllers/Admin/Information/ActivityController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationSetautomaticrecactivitys"
  },
  {
    "type": "post",
    "url": "admin/information/setAutomaticRecInfos",
    "title": "设置指定资讯的推荐院校专业设置(自动设置)",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "infoId",
            "description": "<p>活动的id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"设置成功\"\n}",
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
    "filename": "app/Http/Controllers/Admin/Information/InformationController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationSetautomaticrecinfos"
  },
  {
    "type": "post",
    "url": "admin/information/setAutomaticRecInfos",
    "title": "设置指定资讯的推阅读设置(自动设置)",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "infoId",
            "description": "<p>活动的id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"设置成功\"\n}",
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
    "filename": "app/Http/Controllers/Admin/Information/InformationController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationSetautomaticrecinfos"
  },
  {
    "type": "post",
    "url": "admin/information/setAutomaticRecMajors",
    "title": "自动设置推荐院校",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "activityId",
            "description": "<p>活动的id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"设置成功\"\n}\n拉取代码本地查看",
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
    "filename": "app/Http/Controllers/Admin/Information/ActivityController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationSetautomaticrecmajors"
  },
  {
    "type": "post",
    "url": "admin/information/setHostMajor",
    "title": "设置主办院校专业",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "activityId",
            "description": "<p>指定院校专业的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "majorId",
            "description": "<p>主办院校id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"设置成功\"\n}",
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
    "filename": "app/Http/Controllers/Admin/Information/ActivityController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationSethostmajor"
  },
  {
    "type": "post",
    "url": "admin/information/setMajorState",
    "title": "设置院校专业的状态(权重，展示状态，推荐状态)",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "majorId",
            "description": "<p>指定院校专业的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "type",
            "description": "<p>要修改的状态类型(0修改权重；１修改展示状态；2修改推荐状态)</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "state",
            "description": "<p>要修改的值</p>"
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
    "filename": "app/Http/Controllers/Admin/Information/MajorController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationSetmajorstate"
  },
  {
    "type": "post",
    "url": "admin/information/setManualInfoRelationCollege",
    "title": "设置指定资讯的推荐院校专业设置(手动设置)",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "infoId",
            "description": "<p>活动的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "majorArr",
            "description": "<p>推荐院校专业id的数组</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"设置成功\"\n}",
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
    "filename": "app/Http/Controllers/Admin/Information/InformationController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationSetmanualinforelationcollege"
  },
  {
    "type": "post",
    "url": "admin/information/setManualRecActivitys",
    "title": "手动设置推荐活动",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "activityId",
            "description": "<p>活动的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "activityArr",
            "description": "<p>推荐活动id的数组</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"设置成功\"\n}",
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
    "filename": "app/Http/Controllers/Admin/Information/ActivityController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationSetmanualrecactivitys"
  },
  {
    "type": "post",
    "url": "admin/information/setManualRecInfos",
    "title": "设置指定资讯的推阅读设置(手动设置)",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "infoId",
            "description": "<p>活动的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "infoArr",
            "description": "<p>推荐阅读资讯id的数组</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"设置成功\"\n}",
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
          "title": "Error-Response:    private function createDirImg($imgName, &$imgHandle) {",
          "content": "HTTP/1.1 40x\n{\n  \"code\": \"1\",\n   \"msg\": '更新失败/参数错误'\n}\n\n HTTP/1.1 5xx\n{\n  \"code\": \"2\",\n   \"msg\": '请求方式错误'\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Admin/Information/InformationController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationSetmanualrecinfos"
  },
  {
    "type": "post",
    "url": "admin/information/setManualRecMajors",
    "title": "手动设置推荐院校",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "activityId",
            "description": "<p>活动的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "majorArr",
            "description": "<p>专业id的数组</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"设置成功\"\n}",
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
    "filename": "app/Http/Controllers/Admin/Information/ActivityController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationSetmanualrecmajors"
  },
  {
    "type": "post",
    "url": "admin/information/setProjectState",
    "title": "设置招生项目的状态(权重，展示状态)",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "projectId",
            "description": "<p>指定招生项目的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "type",
            "description": "<p>要修改的状态类型(0修改权重；１修改展示状态;2修改推荐状态)</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "state",
            "description": "<p>要修改的值</p>"
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
    "filename": "app/Http/Controllers/Admin/Information/StudentProjectController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationSetprojectstate"
  },
  {
    "type": "post",
    "url": "admin/information/updateActivityInformationTime",
    "title": "更新活动信息的更新时间",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "activityId",
            "description": "<p>指定活动的id</p>"
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
    "filename": "app/Http/Controllers/Admin/Information/ActivityController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationUpdateactivityinformationtime"
  },
  {
    "type": "post",
    "url": "admin/information/updateActivityMsg",
    "title": "修改活动的信息",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "activityId",
            "description": "<p>指定活动的id</p>"
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
    "filename": "app/Http/Controllers/Admin/Information/ActivityController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationUpdateactivitymsg"
  },
  {
    "type": "post",
    "url": "admin/information/updateAppointInfoMsg",
    "title": "编辑指定咨询信息",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "infoId",
            "description": "<p>指定资讯的id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "infoName",
            "description": "<p>资讯的标题</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "infoType",
            "description": "<p>资讯类型</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "infoFrom",
            "description": "<p>资讯来源</p>"
          },
          {
            "group": "Parameter",
            "type": "File",
            "optional": false,
            "field": "infoImage",
            "description": "<p>资讯封面图</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "infoText",
            "description": "<p>资讯内容</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<p>页面优化</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "keywords",
            "description": "<p>页面优化</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>页面优化</p>"
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
    "filename": "app/Http/Controllers/Admin/Information/InformationController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationUpdateappointinfomsg"
  },
  {
    "type": "post",
    "url": "admin/information/updateCoachMessage",
    "title": "编辑辅导机构的信息(注意是编辑分校还是总部)",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "coachId",
            "description": "<p>指定辅导机构的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "coachName",
            "description": "<p>指定辅导机构的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "coachType",
            "description": "<p>指定辅导机构的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "provice",
            "description": "<p>指定辅导机构的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "phone",
            "description": "<p>指定辅导机构的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "address",
            "description": "<p>指定辅导机构的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "webUrl",
            "description": "<p>指定辅导机构的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "CoachForm",
            "description": "<p>指定辅导机构的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "totalCoachId",
            "description": "<p>指定辅导机构的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "backMoneyType",
            "description": "<p>指定辅导机构的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "coverName",
            "description": "<p>指定辅导机构的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "logoName",
            "description": "<p>指定辅导机构的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "title",
            "description": "<p>指定辅导机构的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "keywords",
            "description": "<p>指定辅导机构的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "description",
            "description": "<p>指定辅导机构的id</p>"
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
    "filename": "app/Http/Controllers/Admin/Information/CoachOrganizeController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationUpdatecoachmessage"
  },
  {
    "type": "post",
    "url": "admin/information/updateMajorInformationTime",
    "title": "更新院校专业信息的更新时间",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "majorId",
            "description": "<p>指定院校专业的id</p>"
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
    "filename": "app/Http/Controllers/Admin/Information/MajorController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationUpdatemajorinformationtime"
  },
  {
    "type": "post",
    "url": "admin/information/updateMajorMsg",
    "title": "修改院校专业的信息",
    "group": "information",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "majorId",
            "description": "<p>指定院校专业的id</p>"
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
    "filename": "app/Http/Controllers/Admin/Information/MajorController.php",
    "groupTitle": "information",
    "name": "PostAdminInformationUpdatemajormsg"
  },
  {
    "type": "post",
    "url": "admin/information/getPageCouponCount",
    "title": "优惠券列表页(对于辅导机构)分页总数",
    "group": "information_ZslmCoupon",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "conditionArr",
            "description": "<p>筛选条件</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"\",\n\"data\": {\n        count:240\n  }\n}",
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
    "filename": "app/Http/Controllers/Admin/Information/CouponController.php",
    "groupTitle": "information_ZslmCoupon",
    "name": "PostAdminInformationGetpagecouponcount"
  },
  {
    "type": "post",
    "url": "admin/information/updateAppointProjectMsg",
    "title": "编辑指定招生项目信息",
    "group": "information_testbbb",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "projectId",
            "description": "<p>招生项目id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "projectName",
            "description": "<p>招生项目名称</p>"
          },
          {
            "group": "Parameter",
            "type": "Float",
            "optional": false,
            "field": "minCost",
            "description": "<p>招生项目最小费用</p>"
          },
          {
            "group": "Parameter",
            "type": "Float",
            "optional": false,
            "field": "maxCost",
            "description": "<p>招生项目最大费用</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "cost",
            "description": "<p>招生项目费用</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "studentCount",
            "description": "<p>招生名额</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "language",
            "description": "<p>授课语言</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "classSituation",
            "description": "<p>班级情况</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "eductionalSystme",
            "description": "<p>学制</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "canConditions",
            "description": "<p>报考条件</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "scoreDescribe",
            "description": "<p>分数线描述</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "graduationCertificate",
            "description": "<p>毕业证书</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "recruitmentPattern",
            "description": "<p>统招模式</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "enrollmentMode",
            "description": "<p>招生模式</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "professionalDirection",
            "description": "<p>专业方向</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"更新成功\",\n}",
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
    "filename": "app/Http/Controllers/Admin/Information/StudentProjectController.php",
    "groupTitle": "information_testbbb",
    "name": "PostAdminInformationUpdateappointprojectmsg"
  },
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
    "url": "admin/operate/createPageBillboard",
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
    "name": "PostAdminOperateCreatepagebillboard"
  },
  {
    "type": "post",
    "url": "admin/operate/deleteAppoinInformation",
    "title": "删除指定区域上的指定资讯",
    "group": "operate",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "RegionId",
            "description": "<p>指定区域的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "InformationId",
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
    "name": "PostAdminOperateDeleteappoininformation"
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
    "url": "admin/operate/getAppointRegionData",
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
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"\",\n\"data\": {\n         {\n             \"region_name\":\"text\",\n             \"zx_id\":[\n                 {\n                     \"id\":\"xxx\",\n                     \"weight\":\"xxxxxxxxxxxx\",\n                     \"zx_name\":\"front/test/test\",\n                     \"information_type\":\"xxxxxxxxxxxx\",\n                     \"create_time\":\"xxxxxxxxxxxx\"\n                 }\n             ]\n         }\n  }\n}",
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
    "name": "PostAdminOperateGetappointregiondata"
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
            "field": "informationTypeId",
            "description": "<p>资讯类型id(0是总量)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "titleKeyword",
            "description": "<p>标题关键字</p>"
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
            "field": "pageNumber",
            "description": "<p>跳转页面下标</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "sortType",
            "description": "<p>排序类型(0按时间升序；1按时间降序)</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\"code\": 0,\n\"msg\": \"\",\n\"data\": {\n\n         {\n             \"id\":\"xxx\",\n             \"name\":\"xxxxxxxxxxxx\",\n             \"z_type\":\"xxxxxxxxxxxx\",\n             \"create_time\":\"xxxxxxxxxxxx\"\n         }\n  }\n}",
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
            "description": "<p>Banner的id(必需)</p>"
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
