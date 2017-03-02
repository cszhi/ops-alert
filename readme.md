### 运维报警管理平台 OPSAlert



## 安装说明

###一、下载到本地：
```
git clone https://github.com/cszhi/ops-alert.git
```
###二、确保`storage`、`bootstrap/cache`目录和`.env`文件让服务器有写入权限
```
chmod 777 storage/ bootstrap/cache/ .env -R
```
###三、配置 `.env`文件 （拷贝.env.example为.env）
```
……
DB_HOST=127.0.0.1		#数据库ip
DB_DATABASE=homestead	#数据库名称
DB_USERNAME=homestead	#用户名
DB_PASSWORD=secret		#数据库密码
……
```
其它配置保持默认

###四、生成 `key`
```
php artisan key:generate
```

###五、安装初始化数据表
```
php artisan migrate
php artisan db:seed
```

###六、运行队列监听器
####启动队列侦听器
```
php artisan queue:listen
```
这个命令启动后，它将会继续运行直到被手动停止为止。
另外可以使用`Supervisor`进程监控软件，来确保队列侦听器不会停止运行。

####Supervisor 设置
`Ubuntu`下安装`Supervisor`
```
apt-get install supervisor
```
创建并编辑文件`/etc/supervisor/conf.d/laravel-worker.conf`
```
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /data/www/ops-alert/artisan queue:work --sleep=3 --tries=3 --daemon
autostart=true
autorestart=true
user=forge
numprocs=3
redirect_stderr=true
stdout_logfile=/data/www/ops-alert/storage/worker.log
```
>`/data/www/ops-alert`是项目所在目录。
>`numprocs=3`指运行并监控`3`个`queue:work`进程。
>如果修改了`管理-配置`中的任何配置信息，需要重新加载下`Supervisor`：
>```
>supervisorctl reload
>```

##问题:
###一、收不到报警邮件
确保邮件配置中相关配置正确。
检查`storage/worker.log`日志，如果有如下报错，说明没有安装`php-curl`扩展，需要安装下。
```
[Symfony\Component\Debug\Exception\FatalErrorException]  
 Call to undefined function App\curl_init() 
```

###二、收不到微信报警信息
确保微信配置中相关配置正确。
检查`storage/worker.log`日志，根据具体报错信息排查。


===============================
# Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching.

Laravel is accessible, yet powerful, providing powerful tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)