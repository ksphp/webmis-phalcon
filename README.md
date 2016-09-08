WebMIS
=================

MVC framework based on the development of multi users, multi access solutions, integration of CodeMirror, TinyMCE, Chart, Jquery and other plug-ins!

Phalcon Framework
=================

Phalcon is an open source web framework delivered as a C extension for the PHP language providing high performance and lower resource consumption.

install Phalcon
-----------

##### Linux/Unix/Mac

https://phalconphp.com/en/download

##### Windows

https://phalconphp.com/en/download/windows

Add the extension to your php.ini:
-----------

##### CentOS
vi /etc/php.d/phalcon.ini

##### Ubunut
vi /etc/php5/mods-available/phalcon.ini
ln -s /etc/php5/mods-available/phalcon.ini /etc/php5/fpm/conf.d/phalcon.ini


Download Phalcon-WebMIS
-----------

    Project Download：https://github.com/ksphp/phalcon-webmis
    Official Docs：https://docs.phalconphp.com/zh/latest/index.html

### Linux/Unix/Mac

##### Svn 方式
svn co https://github.com/ksphp/phalcon-webmis/trunk webmis-phalcon

##### Git 方式
git clone https://github.com/ksphp/phalcon-webmis.git webmis-phalcon


Configure VirtualHost
-----------

### Nginx

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


