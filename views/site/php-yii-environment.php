<?php

/* @var $this yii\web\View */

$this->title = 'Yii2 Development Environment Setup';
use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'Yii2 Project', 'url' => array('site/php-yii')];
$this->params['breadcrumbs'][] = $this->title;


// SyntaxHighlighter - http://alexgorbatchev.com/SyntaxHighlighter/manual/installation.html
//$this->registerJsFile('js/sh/shCore.js');
//$this->registerJsFile('js/sh/shBrushSql.js');
//$this->registerCssFile('css/sh/shCore.css');
//$this->registerCssFile('css/sh/shThemeDefault.css');
///////////////////////////////////////////////////////////////////////////////////////////


?>


<link rel="stylesheet" href="js/styles/googlecode.css">
<script src="js/highlight.pack.js"></script>
<script>hljs.initHighlightingOnLoad();</script>

        
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
                
                <h2>Yii2 Development Environment Setup</h2>
                <p>Before creating the project, we have to setup the development environment. There are many ways of doing that, and I will show here the way I do. To work with Yii2 we will need to have a web server, composer, codeception, database (MySql, Postgree, etc.), and of course an IDE.</p>
                <p>For that, there are many options, like XAMPP, WAMP, etc. But what I have been using now is <a href="http://www.vagrantup.com" target="_blank">Vagrant</a>. Vagrant makes it very easy to create a complete development environment. It uses <a href="https://www.virtualbox.org/" target="_blank">VirtualBox</a>, wich we need to install too, and create a virtual machine. You have many different boxes ready for use or you can create your own and save it for further use.</p>
                <p>Installing Virtualbox and Vagrant is very simple, just follow the instructions on the links above. But then you will have to install and configure composer, codeception, php, etc.</p>
                <p>So, the easiest way I found is to install VirtualBox and Vagrant, but do not create any vagrant boxes yet. Once you have installed both softwares, follow this link here: <a href="https://github.com/yiisoft/yii2-app-advanced/blob/master/docs/guide/start-installation.md#installing-using-vagrant" target="_blank">Yii2 Advanced Template Installation</a>.</p>
                <p>This way, you will have your environment with almost everything you will need: composer, codeception, nginx, php, mysql. And will have your new Yii2 project created as well.</p>
                <p>What is great using Vagrant is that you have a "Synced Folder" of your project inside your virtual server, so any changes made to the code can be tested instantly.</p>
                <p>The only thing I had to add to this environment was X-Debug and configure it to use remote debug, so I am able to integrate with NetBeans and debug the code.</p>
                <p>So, after the installation is complete, we can access the server via ssh using:</p>
                <pre>
                    <code class="bash hljs">
vagrant ssh
                    </code>
                </pre>
                <p>You have to be inside the base folder of your application to run this command. Once in the server console, run the following commands to install X-Debug:</p>
                <pre>
                    <code class="bash hljs">
sudo apt-get install php5-dev php-pear
sudo pecl install xdebug
                    </code>
                </pre>
                
                <p>Open file <code>/etc/php5/fpm/php.ini</code> and add the following line:</p>
                <pre>
                <code class="bash hljs">
zend_extension="/usr/lib/php5/20121212/xdebug.so"
                </code>
                </pre>

                <p>And restart the service:</p>
                <pre>
                    <code class="bash hljs">
sudo service php5-fpm restart                        
                    </code>
                </pre>

                <p>Ok, now we have X-Debug installed with our php, but we still have to configure it to run remotely, so add the following configuration to your <code>/etc/php5/fpm/php.ini</code> file:</p>
                <pre>
                    <code class="bash hljs">
xdebug.remote_autostart=off
xdebug.remote_enable=on
xdebug.remote_handler=dbgp
xdebug.remote_mode=req
xdebug.remote_host=192.168.83.1 # Your client machine IP
xdebug.remote_port=9000          
                    </code>
                </pre>

                <p>If you will work with only one project in this environment, it is ready. But what I did here was to change some configuration so I can use this environment for all my projects. </p>
                <p>Vagrant creates a file in the root folder of the application called Vagrantfile. What I did was edit this file, added a new domain in the domains section and changed the sync folder configuration like this:</p>
                <pre>
                    <code class="bash hljs">
domains = {
  frontend: 'y2aa-frontend.dev',
  backend:  'y2aa-backend.dev',
  apps: 'apps.dev',
}

...

# sync: folder '../' (host machine) -> folder '/app' (guest machine)
config.vm.synced_folder '../', '/app', owner: 'vagrant', group: 'vagrant'
                    </code>
                </pre>
                
                <p>Before the change, Vagrant sync folder was yii2-app-advanced wich was inside my apps folder. So I changed to sync all my apps. Then I had to add the apps.dev in the hosts configuration. In Mac (I'm using a Mac Mini with 8Gb wich I am very happy with now), this can be done editing the file /etc/hosts and adding the virtual server IP and the domain. The installation above had already created the domains y2aa, y2aa-frontend.dev, y2aa-backend.dev, I just added apps.dev:</p>
                <pre>
                    <code class="bash hljs">
## vagrant-hostmanager-start id: 3f3eda2c-b412-4ef9-ad3b-db60f496db2c
192.168.83.137  y2aa
192.168.83.137  y2aa-frontend.dev
192.168.83.137  y2aa-backend.dev
192.168.83.137  apps.dev
## vagrant-hostmanager-end
                    </code>
                </pre>
                
                <p>The last step is to tell nginx how to deal with the new domain. For that we access the server using "vagrant ssh", edit the file "/etc/nginx/sites-enabled/app.conf" and add the section below in the end of the file:</p>
                <pre>
                    <code class="bash hljs">
server {
   charset utf-8;
   client_max_body_size 128M;
   sendfile off;

   listen 80; ## listen for ipv4
   #listen [::]:80 default_server ipv6only=on; ## listen for ipv6

   server_name apps.dev;
   root        /app/;
   index       index.php;

   access_log  /app/vagrant/nginx/log/apps-access.log;
   error_log   /app/vagrant/nginx/log/apps-error.log;

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
                
                
                <p>Restart nginx with "sudo service nginx restart". That's it. Now we have a complete development environment ready to run. As I use NetBeans everything worked perfectly and I am able to debug from the IDE. If you use a different IDE, maybe there are some other configurations, but will probably work just fine. We also have composer, codeception, MySql, all ready to use. To access via browser from the client machine, we can use the domains y2aa-frontend.dev for the frontend, y2aa-backend.dev for the backend and apps.dev and the relative path of all the other projects.</p>
                
            </div>
        </div>

    </div>
</div>

<script language="javascript">
//    SyntaxHighlighter.all();
</script>
