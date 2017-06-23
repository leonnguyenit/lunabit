<?php

namespace Luna\Controllers\System;

use Luna\Core\SystemController;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Database\Schema\Blueprint;

class SetupDB extends SystemController
{
    /**
     * Controller Constructor
     * @param ContainerInterface $ci
     */
    public function __construct(ContainerInterface $ci)
    {
        parent::__construct($ci);
    }

    /**
     * Create Tables Forge
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     */
    public function addTables($request, $response)
    {

        /**
         * Options
         */
        if (!$this->schema->hasTable('options')) {
            $this->schema->create('options', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 200)->unique();
                $table->longText('value');
                $table->boolean('autoload')->default(true);
            });
        }

	    /**
	     * Routes
	     */
	    if (!$this->schema->hasTable('routes')) {
		    $this->schema->create('routes', function (Blueprint $table) {
			    $table->increments('id');
			    $table->string('route', 250);
			    $table->string('method', 10)->default('get');
			    $table->string('controller', 100);
			    $table->string('action', 20)->nullable();
			    $table->string('type', 10)->default('site');
			    $table->unique(['route', 'method']);
		    });


	    }

//        /**
//         * posts
//         */
//        if (!$this->schema->hasTable('posts')) {
//            $this->schema->create('posts', function (Blueprint $table) {
//                $table->increments('id');
//                $table->text('title');
//                $table->string('slug', 250)->unique();
//                $table->text('excerpt')->nullable();
//                $table->longText('content')->nullable();
//                $table->string('post_type', 100)->default('post');
//                $table->string('post_status', 20)->default('publish');
//                $table->timestamp('publish_date')->useCurrent();
//                $table->timestamps();
//            });
//        }
//
//        /**
//         * post_metas
//         */
//        if (!$this->schema->hasTable('post_metas')) {
//            $this->schema->create('post_metas', function (Blueprint $table) {
//                $table->increments('id');
//                $table->integer('post_id')->unsigned();
//                $table->foreign('post_id')->references('id')->on('posts');
//                $table->string('meta_key', 250);
//                $table->longText('meta_value');
//                $table->timestamps();
//                $table->unique(['post_id', 'meta_key']);
//            });
//        }
//
//        /**
//         * tags
//         */
//        if (!$this->schema->hasTable('tags')) {
//            $this->schema->create('tags', function (Blueprint $table) {
//                $table->increments('id');
//                $table->string('title', 200);
//                $table->string('slug', 250);
//                $table->text('description')->nullable();
//                $table->string('post_type', 50);
//                $table->timestamps();
//                $table->unique(['slug', 'post_type']);
//            });
//        }
//
//        /**
//         * posts_tags
//         */
//        if (!$this->schema->hasTable('posts_tags')) {
//            $this->schema->create('posts_tags', function (Blueprint $table) {
//                $table->increments('id');
//                $table->integer('post_id')->unsigned();
//                $table->foreign('post_id')->references('id')->on('posts');
//                $table->integer('tag_id')->unsigned();
//                $table->foreign('tag_id')->references('id')->on('tags');
//                $table->timestamps();
//                $table->unique(['post_id', 'tag_id']);
//            });
//        }
//
//        /**
//         * tags
//         */
//        if (!$this->schema->hasTable('categories')) {
//            $this->schema->create('categories', function (Blueprint $table) {
//                $table->increments('id');
//                $table->string('title', 200);
//                $table->string('slug', 250);
//                $table->text('description')->nullable();
//                $table->string('post_type', 50);
//                $table->integer('weight')->unsigned();
//                $table->integer('parent_id')->unsigned()->default(0);
//                $table->timestamps();
//                $table->unique(['slug', 'post_type']);
//            });
//        }
//
//        /**
//         * posts_categories
//         */
//        if (!$this->schema->hasTable('posts_categories')) {
//            $this->schema->create('posts_categories', function (Blueprint $table) {
//                $table->increments('id');
//                $table->integer('post_id')->unsigned();
//                $table->foreign('post_id')->references('id')->on('posts');
//                $table->integer('category_id')->unsigned();
//                $table->foreign('category_id')->references('id')->on('categories');
//                $table->timestamps();
//                $table->unique(['post_id', 'category_id']);
//            });
//        }



        return $response->write("Database table has been created finish!!!");
    }

    /**
     * Drop all created tables
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response [description]
     */
    public function dropTables($request, $response)
    {
        $this->schema->drop('options');
	    $this->schema->drop('routes');
        $this->schema->drop('posts_tags');
        $this->schema->drop('posts_categories');
        $this->schema->drop('tags');
        $this->schema->drop('categories');
        $this->schema->drop('post_meta');
        $this->schema->drop('posts');
        return $response->write("Database table has been dropped finish!!!");
    }

    /**
     * Default Invoke Controller
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param mixed $args
     * @return HTML
     */
    public function __invoke($request, $response, $args)
    {
        // do nothing
    }
}
