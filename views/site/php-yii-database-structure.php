<?php

/* @var $this yii\web\View */

$this->title = 'Database Structure';
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
                
                <h2>MySQL Database Structure</h2>

<pre>
<code class="language-sql">
### USER TABLE ### 
CREATE TABLE `blog_user` (
	`user_id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NULL DEFAULT NULL COLLATE 'latin1_general_ci',
	`username` VARCHAR(30) NULL DEFAULT NULL COLLATE 'latin1_general_ci',
	`passw` VARCHAR(100) NULL DEFAULT NULL COLLATE 'latin1_general_ci',
	`active` ENUM('Y','N') NULL DEFAULT 'Y' COLLATE 'latin1_general_ci',
	`access_token` VARCHAR(100) NULL DEFAULT NULL COLLATE 'latin1_general_ci',
	`auth_key` VARCHAR(100) NULL DEFAULT NULL COLLATE 'latin1_general_ci',
	PRIMARY KEY (`user_id`),
	UNIQUE INDEX `login` (`username`)
)
COMMENT='user table for calendar'
COLLATE='latin1_general_ci'
ENGINE=InnoDB
;


### CATEGORY TABLE ###
CREATE TABLE `cal_category` (
	`category_id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(30) NOT NULL COLLATE 'latin1_general_ci',
	`active` ENUM('Y','N') NOT NULL DEFAULT 'Y' COLLATE 'latin1_general_ci',
	PRIMARY KEY (`category_id`)
)
COMMENT='Event categories'
COLLATE='latin1_general_ci'
ENGINE=InnoDB
;



### EVENT TABLE ### 
CREATE TABLE `cal_event` (
	`event_id` INT(11) NOT NULL AUTO_INCREMENT,
	`user_id` INT(11) NOT NULL,
	`category_id` INT(11) NOT NULL,
	`date` DATE NOT NULL,
	`time` TIME NOT NULL,
	`status` ENUM('ACTIVE','DONE','CANCELED') NOT NULL DEFAULT 'ACTIVE' COLLATE 'latin1_general_ci',
	PRIMARY KEY (`event_id`),
	INDEX `user_id` (`user_id`),
	INDEX `category_id` (`category_id`),
	CONSTRAINT `FK_cal_event_blog_user` FOREIGN KEY (`user_id`) REFERENCES `blog_user` (`user_id`),
	CONSTRAINT `FK_cal_event_cal_category` FOREIGN KEY (`category_id`) REFERENCES `cal_category` (`category_id`)
)
COMMENT='Calendar events'
COLLATE='latin1_general_ci'
ENGINE=InnoDB
;


</code>
</pre>                
                


            </div>
        </div>



    </div>
</div>

<script language="javascript">
//    SyntaxHighlighter.all();
</script>
