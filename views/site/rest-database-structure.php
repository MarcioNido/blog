<?php

/* @var $this yii\web\View */

$this->title = 'REST Database Structure';
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
                
                <h2>REST Database Structure</h2>
                <p>For this tutorial we will use the same database structure used in the Yii2 Framework Tutorial, the calendar example. So if you already have it you can use that.</p>
                <p>Otherwise, I will give here the MySQL database structure. Remember that the application is database engine independent, so please feel free to use the same structure in your preferred database engine.</p>
                <pre>
                <code class="sql">
# Users table                    
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `active` smallint(1) NOT NULL DEFAULT '1',
  `access_token` varchar(100) DEFAULT NULL,
  `auth_key` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `idx_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

# Categories table
CREATE TABLE `cal_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `active` int(1) DEFAULT '1',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

# Events table
CREATE TABLE `cal_event` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `description` varchar(500) NOT NULL,
  `active` int(1) DEFAULT '1',
  `done` int(1) DEFAULT '0',
  PRIMARY KEY (`event_id`),
  KEY `idx-cal_event-user_id` (`user_id`),
  KEY `idx-cal_event-category_id` (`category_id`),
  CONSTRAINT `fk-cal_event-category_id` FOREIGN KEY (`category_id`) REFERENCES `cal_category` (`category_id`) ON DELETE CASCADE,
  CONSTRAINT `fk-cal_event-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

                </code>
                </pre>
              
            </div>
        </div>

    </div>
</div>

<script language="javascript">
//    SyntaxHighlighter.all();
</script>
