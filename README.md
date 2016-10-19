## WebMIS
WEBMIS is in the development of many years finishing and development of the front-end plug-ins, integrated Jquery, CodeMirror, TinyMCE, Chart and other plug-ins! Features Font Icon, automatically loaded CSS or JS, prompt box, HTML5 video playback, graphics, form validation, editor, file upload and other commonly used functions.

## WebMIS-Phalcon
Multi user, multi privilege open source solution based on Phalcon framework! Provide the overall website development system, solve the problems of background management and the two development.

## WebMIS Document

* [Official Website](https://ksphp.github.io/)
* [WebMIS Document](https://ksphp.github.io/docs/WebMIS/)
* [Phalcon Document](https://docs.phalconphp.com/zh/latest/index.html)


# Install Phalcon framework
https://phalconphp.com/zh/download

### Add to PHP extension
extension=phalcon.so    // Add to INI file
```bash
# CentOS
vi /etc/php.d/phalcon.ini

# Ubunut
vi /etc/php5/mods-available/phalcon.ini
ln -s /etc/php5/mods-available/phalcon.ini /etc/php5/fpm/conf.d/phalcon.ini
```

### Unable to compile C solution (Aliyun cloud ECS, Tencent cloud CVM)
```bash
# Error
gcc: internal compiler error: Killed (program cc1)

# Add SWAP file
dd if=/dev/zero of=/var/swapfile bs=1M count=2048

# Create SWAP file
mkswap /var/swapfile

# Activate SWAP file
swapon /var/swapfile

# View SWAP
free -m

# Add to fstab file
echo "/var/swapfile swap swap defaults 0 0" >>/etc/fstab

```

# Download webmis-phalcon project
```bash
# Svn mode
svn co https://github.com/ksphp/webmis-phalcon/trunk webmis-phalcon
# Git mode
git clone --depth=1 https://github.com/ksphp/webmis-phalcon.git webmis-phalcon
```

# Configuration
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
    location /data/ {
        rewrite ^/data/(.*)$ /data/index.php?_url=/$1;
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

# Installation wizard
```bash
http://phalcon.ksphp.cn/install
```
Note: remember to delete the directory after the installation is complete!
