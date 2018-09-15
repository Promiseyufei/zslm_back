# zslm_back_rmfd

#### 项目介绍
专硕联盟网站后端

#### 项目目录架构
项目目录架构
> app
>> Http
>>> Controllers
>>>> Admin         后台接口
>>>>>  Accounts     
>>>>>  Files
>>>>>  Info
>>>>>  News
>>>>>  Operate
>>>>>  Refund
>>>> Auto          其他接口
>>>>>  Share           分享
>>>>>  Sms             短信
>>>>>  ThirdLogin      第三方登录
>>>> Front         前台接口
>>>>>  Activity
>>>>>  Coach
>>>>>  Colleges
>>>>>  Consult
>>>>>  Index
>>>>>  Reward
>>>>>  UserCore
>>>> Login         登录接口
>>>>>  Admin          后台登录接口
>>>>>  Front          前台登录接口
>>> Middleware     中间件
>> libs            第三方类库SDK存放处
>> Models          model接口
> Helpers          自定义公共方法
> routes           路由文件
>> admin.php        后台路由
>> front.php        前台路由
>> login.php        登录路由
>> web.php          路由入口
> api           API存放处






#### 安装教程

1. cd /var/www/html/
2. sudo chmod -R 777 zslm_back_rmfd
3. sudo cp ./.env.example ./.env
4. php artisan key:generate
5. composer install


#### 参与贡献

1. Fork 本项目
2. 新建 Feat_xxx 分支
3. 提交代码
4. 新建 Pull Request

