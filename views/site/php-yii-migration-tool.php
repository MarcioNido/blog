<?php

/* @var $this yii\web\View */

$this->title = 'Yii2 Migration Tool';
use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'Yii2 Project', 'url' => array('site/php-yii')];
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="js/styles/googlecode.css">
<script src="js/highlight.pack.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
        
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
                
                <h2>Yii2 Migration Tool</h2>
                <p>One important feature of Yii is migration. Using migration tool facilitates system updates but also can make your application database independent. So let's see how to create the users table using the migration tool.</p>
                <p>Migrations are created using the command line tool yii migrate/create name, so for the creation of the user table, go to the root folder of the application @app, in our case /app/basic-calendar and type:</p>                

                <pre>
<code class='bash'>
php yii migrate/create create_user_table                        
</code>
                </pre>                
                
                <p>This will create a class similar to this:</p>
                <pre>
                    <code class='php'>
&l&lt;?php

use yii\db\Migration;

/**
 * Handles the creation for table `user`.
 */
class m161017_174848_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
    }
}                        
</code>
                </pre>                

                <p>The up method is executed when you are applying a migration to a database and the down method if you want to revert the migration.</p>
                <p>So, now we complete the class with the fields we need for the user table. It will be something like this:</p>                

                <pre>


<code class='php'>
&lt;?php

use yii\db\Migration;

/**
 * Handles the creation for table `user`.
 */
class m161017_174848_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'user_id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'username' => $this->string(30)->notNull(),
            'password' => $this->string(100)->notNull(),
            'active' => $this->smallInteger(1)->defaultValue(1)->notNull(),
            'access_token' => $this->string(100)->null(),
            'auth_key' => $this->string(100)->null(),
        ]);
        
        $this->createIndex('idx_username', 'user', 'username', true);
        
        $this->insert('user', array(
            'name' => 'ADMIN',
            'username' => 'ADMIN',
            'password' => '$2y$13$PB4Xp0.T5489SKKf7ex2GepYozFgRMcIXSZTrDktdn4xAt5jVlmvS',
            'active' => 1,
            'access_token' => null,
            'auth_key' => '9CEQD9h51DASTja10X1zCaGDCPyp9Lnv',
        ));
        
        $this->insert('user', array(
            'name' => 'DEMO',
            'username' => 'DEMO',
            'password' => '$2y$13$w7CANhQM7k46yUWco6tg2uv6y/RsJb5aBPI/DNwzBbj.MT1PrpLkO',
            'active' => 1,
            'access_token' => null,
            'auth_key' => 'qN38K8lRV7nVmrJPhkcVpUmsceLqoeKN',
        ));
        
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
    }
}                        
</code>
                </pre>  
                
                <p>Notice that here we are also creating the ADMIN and DEMO users. A complete list of methods you can use to manipulate the database can be found here: <a target="_blank" href='http://www.yiiframework.com/doc-2.0/guide-db-migrations.html#db-accessing-methods'>http://www.yiiframework.com/doc-2.0/guide-db-migrations.html#db-accessing-methods</a></p>
                
                <p>Now, to apply the migration to the database, just go to the application root folder @app or in our case /app/basic-calendar/ and execute the command:</p>
                <pre>
<code class='bash'>
php yii migrate                        
</code>
                </pre>
                <p>And then, apply the same migration to the test database. For this execute the yii script that is inside codeception/bin folder like this:</p>
                <pre>
<code class='bash'>
php test/codeception/bin/yii migrate
</code>
                </pre>    
                <p>That's it. Check your databases. You will see that yii created a table called migration to control the migrations and the user table, already with ADMIN and DEMO users. And it can be used with any database engine that Yii supports.</p>                

            </div> 
        </div>
    </div>
</div>
