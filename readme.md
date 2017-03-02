### 运维报警管理平台 OPSAlert



## 安装说明

###一、下载到本地：
```
git clone https://github.com/cszhi/ops-alert.git
```
###二、确保`storage`、`bootstrap/cache`目录和`.env`文件让服务器有写入权限
```
cd ops-alert
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
执行这个命令后，它将会持续运行直到被手动停止为止。
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

>如果修改了`管理-配置`中的任何配置信息，最好重新加载下`Supervisor`：
>```
>supervisorctl reload
>```

## 使用说明

###邮箱设置
略……

###微信设置
1. 注册[微信企业号](https://qy.weixin.qq.com/)
2. 进入`通讯录`新增成员。其中`帐号`就是等会新增成员要用到的`微信号`。
3. `corpid`和`corpsecret`:进入`设置`-`权限管理`-`管理员`，就可以看到`CorpID`和`Secret`。
4. `agentid`:进入`应用中心`，新建`消息型应用`，创建完后，进入应用，其中`应用ID`就是`agentid`。
5. 在`设置`中，有企业号的二维码，在通讯录中成员扫描该二维码就可以关注该企业号。

###新增成员
`微信号`就是在微信企业号中，新增成员时填写的`帐号`

###新增分组
1. 可选三种报警方式，`微信`、`邮件`和`微信+邮件`
2. 每一个分组对应一个唯一的`TOKEN`，用来调用报警api时识别分组

###报警api

####api地址：
`http://ip:port/alert/$token` 如：`http://1.2.3.4:8000/alert/qdm4DQYnhz7Z387W`

####调用api
get方式：`curl 'http://ip:port/alert/$token?hostname=$hostname&ip=$ip&content=$content'`

post方式：`curl 'http://ip:port/alert/$token' -d hostname=$hostname -d ip=$ip -d content=$content`

```
* hostname: 服务器名称
* ip: 服务器ip地址
* content: 报警内容
```

####调用api实例
脚本检测系统负载，负载高于设定的阈值则调用api报警

```
#!/bin/bash
# Program:
#       check system load
# History:
# 2017/03/03	caishunzhi	First release
PATH=/bin:/sbin:/usr/bin:/usr/sbin:/usr/local/bin:/usr/local/sbin:~/bin
export PATH

DIR=$(cd "$(dirname "$0")"; pwd)
CURL="curl -s --connect-timeout 30"
TOKEN=qdm4DQYnhz7Z387W
API="http://192.168.0.1:8000/alert/$TOKEN"
HOSTNAME=$(hostname)
IP="192.168.0.100"
LOAD_LIMIT=1
>$DIR/content.txt

#系统当前负载高于设定的阈值，将系统负载信息写入content.txt
load(){
	LOAD=$(awk '{print $1}' /proc/loadavg)
	LOADAVG=$(awk '{print $1,$2,$3}' /proc/loadavg)
	TMP=`awk -v num1=$LOAD -v num2=$LOAD_LIMIT 'BEGIN{print(num1>num2)?"1":"0"}'`
	if [ $TMP -eq 1 ];then
		echo "LOAD:$LOADAVG" >$DIR/content.txt
	fi
}

alert(){
    $CURL $API -d hostname="$1" -d ip="$2" -d content="$3"
}

load
#content.txt文件如果不为空时，调用alert函数发送报警
[ -s $DIR/content.txt ] && alert $HOSTNAME $IP "$(cat $DIR/content.txt)"
```

##问题

####一、收不到报警邮件
确保邮件配置中相关配置正确。
检查`storage/worker.log`日志，如果有如下报错:
```
[Symfony\Component\Debug\Exception\FatalErrorException]  
 Call to undefined function App\curl_init() 
```
说明没有安装`php-curl`扩展，需要安装下。

####二、收不到微信报警信息
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