<?php

namespace app\controller;

use app\component\Controller;
use app\model\Post;

/**
 * Class DefaultController
 * A controller to run on root path
 *
 * @package app\controller
 */
class DefaultController extends Controller
{
    /**
     * Show post list
     */
    public function actionIndex()
    {
        $posts = Post::findAll();
        echo $this->render('index', compact('posts'));
    }
}
