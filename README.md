## WebMIS
webmis是多年开发中整理并开发的前端插件，整合了Jquery、CodeMirror、TinyMCE、Chart等插件！功能有字体图标、自动加载CSS或JS、提示框、HTML5视频播放、图表、表单验证、编辑器、文件上传等常用功能。

## WebMIS-Phalcon
基于Phalcon框架开发的多用户、多权限开源解决方案！提供整体网站开发体系、解决后台管理和二次开发问题。

* [官方网站](https://ksphp.github.io/)
* [WebMIS文档](https://ksphp.github.io/docs/WebMIS/)
* [Phalcon文档](https://docs.phalconphp.com/zh/latest/index.html)

## 一、安装Phalcon框架
https://phalconphp.com/zh/download

### 添加到PHP扩展
extension=phalcon.so // 添加到INI文件
```bash
# CentOS
vi /etc/php.d/phalcon.ini

# Ubunut
vi /etc/php5/mods-available/phalcon.ini
ln -s /etc/php5/mods-available/phalcon.ini /etc/php5/fpm/conf.d/phalcon.ini
```

### 无法编译C的解决方法(阿里云ECS、腾讯云CVM)
```bash
# 编译时内存不足导致
gcc: internal compiler error: Killed (program cc1)

# 增加SWAP文件
dd if=/dev/zero of=/var/swapfile bs=1M count=2048

# 创建SWAP文件
mkswap /var/swapfile

# 激活SWAP文件
swapon /var/swapfile

# 查看SWAP
free -m

# 添加到fstab文件中让系统引导时自动启动
echo "/var/swapfile swap swap defaults 0 0" >>/etc/fstab

```

## 二、下载webmis-phalcon项目
```bash
# Svn 方式
svn co https://github.com/ksphp/webmis-phalcon/trunk webmis-phalcon
# Git 方式
git clone --depth=1 https://github.com/ksphp/webmis-phalcon.git webmis-phalcon
```

## 三、配置环境
### 1) Apache
```bash
[...]
    AllowOverride All
    Require all granted
    Options Indexes FollowSymLinks
[...]
```

### 1) Nginx
```bash
server {
    listen       80;
    server_name  phalcon.ksphp.cn;
    set $root_path '/home/www/webmis-phalcon/public';
    root $root_path;
    index index.php index.html;

    try_files $uri $uri/ @rewrite;
    location @rewrite {
        rewrite ^/(.*)$ /index.php?_url=/$1;
    }
    location /m/ {
        rewrite ^/m/(.*)$ /m/index.php?_url=/$1;
    }
    location /admin/ {
        rewrite ^/admin/(.*)$ /admin/index.php?_url=/$1;
    }
    location /app/ {
        rewrite ^/app/(.*)$ /app/index.php?_url=/$1;
    }
    location ~* ^/(webmis|upload)/(.+)$ {
        root $root_path;
    }
 
    #error_page  404              /404.html;

    # redirect server error pages to the static page /50x.html
    #
    error_page   500 502 503 504  /50x.html;
    location = /50x.html {
        root   /usr/share/nginx/html;
    }

    # pass the PHP scripts to FastCGI server listening on 127.0.0.1:9000
    #
    location ~ \.php$ {
            fastcgi_pass   127.0.0.1:9000;
            #fastcgi_pass   unix:/run/php-fpm/php-fpm.sock;
            fastcgi_index  index.php;
            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
            include        fastcgi_params;
        }
    # deny access to .htaccess files, if Apache's document root
    # concurs with nginx's one
    #
    location ~ /\.ht {
        deny  all;
    }
}
```

## 四、安装向导
```bash
http://phalcon.ksphp.cn/install
```
注意：安装完成后记得删除该目录！
