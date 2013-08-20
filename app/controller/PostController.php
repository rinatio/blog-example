<?php

namespace app\controller;

use app\component\Controller;
use app\component\Front;
use app\exception\HttpException;
use app\model\Post;
use app\model\Comment;

/**
 * Class PostController
 * Manage Posts
 *
 * @package app\controller
 */
class PostController extends Controller
{
    /**
     * View post and comments
     *
     * @throws \app\exception\HttpException
     */
    public function actionView()
    {
        $rq = Front::instance()->getRequest();
        $id = $rq->getProperty('id');
        if(!$id) {
            throw new HttpException(400);
        }
        $post = Post::findByAttributes(['id' => $id]);
        if(!$post) {
            throw new HttpException(404);
        }
        $comments = Comment::findAllByAttributes([
            'post_id' => $id
        ]);
        echo $this->render('view', compact('post', 'comments'));
    }

    /**
     * Create a post
     *
     * @throws \app\exception\HttpException
     * @throws \Exception
     */
    public function actionCreate()
    {
        $session = Front::instance()->getSession();
        if(!$session->id) {
            throw new HttpException(403);
        }
        $rq = Front::instance()->getRequest();
        if($rq->isPost()) {
            $model = new Post();
            $model->setAttributes($_POST);
            if($model->validate()) {
                $model->setUserId($session->id);
                if(!$model->save()) {
                    throw new \Exception('Cannot save model');
                }
                $this->redirect('/');
            } else {
                $errors = $model->getErrors();
            }
        }
        echo $this->render('create', compact('errors'));
    }
}
