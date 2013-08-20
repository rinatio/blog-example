<?php

namespace app\controller;

use app\component\Controller;
use app\component\Front;
use app\exception\HttpException;
use app\model\Post;
use app\model\Comment;

/**
 * Class CommentController
 * Manage post comments
 *
 * @package app\controller
 */
class CommentController extends Controller
{
    /**
     * Add a comment
     *
     * @throws \app\exception\HttpException
     * @throws \Exception
     */
    public function actionCreate()
    {
        $rq = Front::instance()->getRequest();
        $pId = $rq->getPost('post_id');
        if(!$rq->isPost() || !$pId) {
            throw new HttpException(400);
        }
        $post = Post::findByAttributes(['id' => $pId]);
        if(!$post) {
            throw new HttpException(404);
        }
        $comment = new Comment();
        $comment->setAttributes($_POST);
        if(!$comment->validate()) {
            throw new HttpException(404);
        }
        if(!$comment->save()) {
            throw new \Exception('Cannot save comment');
        }
        $this->redirect('/?r=post/view&id=' . $post->getId());
    }
}
