<?php

/* @var $this yii\web\View */

$this->title = 'REST Pretty URL';
use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'REST Project', 'url' => array('site/rest')];
$this->params['breadcrumbs'][] = $this->title;
?>

<link rel="stylesheet" href="js/styles/googlecode.css">
<script src="js/highlight.pack.js"></script>
<script>hljs.initHighlightingOnLoad();</script>

        
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
                
                <h2>REST Pretty URL</h2>
                <p>For our API to work we will need to configure the URL Manager and make some changes to our server and development environment.</p>
                <p>First, we need to configure the URL Manager component in @app/config/web.php:</p>
                <pre>
                    <code>
'urlManager' => [
    'enablePrettyUrl' => true,
    'enableStrictParsing' => true,
    'showScriptName' => true,
    'rules' => [
        ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/category'],
    ],
],
</code>
                </pre>

                <p>Note that the rules property of the Url Manager component uses the class yii\rest\UrlRule for the Category Controller. This will automatically create the default access for the categories resource, like GET /categories to list the categories, POST /categories to create a new category, etc.</p>
                <p>Now we need to create a new domain in Nginx and point it to the web folder of our application. I created the domain api.dev. For that, edit the file /etc/nginx/sites-enabled/app.conf and add the following:</p>
                
                <pre>
                    <code>
server {
   charset utf-8;
   client_max_body_size 128M;
   sendfile off;

   listen 80; ## listen for ipv4
   #listen [::]:80 default_server ipv6only=on; ## listen for ipv6

   server_name api.dev;
   root        /app/rest-api/web;
   index       index.php;

   access_log  /app/vagrant/nginx/log/api-access.log;
   error_log   /app/vagrant/nginx/log/api-error.log;

   location / {
       # Redirect everything that isn't a real file to index.php
       try_files $uri $uri/ /index.php$is_args$args;
   }

   # uncomment to avoid processing of calls to non-existing static files by Yii
   #location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
   #    try_files $uri =404;
   #}
   #error_page 404 /404.html;

   location ~ \.php$ {
       include fastcgi_params;
       fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
       #fastcgi_pass   127.0.0.1:9000;
       fastcgi_pass unix:/var/run/php5-fpm.sock;
       try_files $uri =404;
   }

   location ~ /\.(ht|svn|git) {
       deny all;
   }
}                        
</code>
                </pre>
              
                <p>And restart Nginx with sudo nginx -s reload.</p>
                <p>Now only create the new entry in your client machine /etc/hosts file to point to the server:</p>
                <pre>
                    <code>
## vagrant-hostmanager-start id: 3f3eda2c-b412-4ef9-ad3b-db60f496db2c
192.168.83.137  y2aa
192.168.83.137  y2aa-frontend.dev
192.168.83.137  y2aa-backend.dev
192.168.83.137  apps.dev
192.168.83.137  api.dev
## vagrant-hostmanager-end                        
</code>
                </pre>
                
                <p>Now we can already access our categories resource using the API:</p>
                <pre>
                    <code>
curl -i -H "Accept:application/json" "http://api.dev/v1/categories"
HTTP/1.1 200 OK
Server: nginx/1.4.6 (Ubuntu)
Date: Wed, 19 Oct 2016 14:55:54 GMT
Content-Type: application/json; charset=UTF-8
Transfer-Encoding: chunked
Connection: keep-alive
X-Powered-By: PHP/5.5.9-1ubuntu4.20
X-Pagination-Total-Count: 3
X-Pagination-Page-Count: 1
X-Pagination-Current-Page: 1
X-Pagination-Per-Page: 20
Link: &lt;http://api.dev/v1/categories?page=1&gt;; rel=self

[{"category_id":1,"name":"General","active":1},{"category_id":2,"name":"Work","active":1},{"category_id":3,"name":"Personal","active":1}]
</code>
                </pre>
                
                
                
            </div>
        </div>

    </div>
</div>
