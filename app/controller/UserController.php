<?php
namespace app\controller;

use \app\component\Controller;
use \app\component\Front;
use \app\model\User;

/**
 * Class UserController
 * Manage user actions (signin, signup, logout)
 *
 * @package app\controller
 */
class UserController extends Controller
{
    /**
     * User Sign Up
     * @throws \Exception if cannot save a model
     */
    public function actionSignup()
    {
        $rq = Front::instance()->getRequest();
        if($rq->isPost()) {
            $model = new User();
            $model->setAttributes($_POST);
            if($model->validate()) {
                if(!$model->save()) {
                    throw new \Exception('Cannot save model');
                }
                Front::instance()->getSession()->id = $model->getId();
                Front::instance()->getSession()->name = $model->getName();
                $this->redirect('/');
            } else {
                $errors = $model->getErrors();
            }
        }
        echo $this->render('signup', compact('errors'));
    }

    /**
     * User Sign In
     */
    public function actionSignin()
    {
        $rq = Front::instance()->getRequest();
        if($rq->isPost()) {
            $email = $rq->getPost('email');
            $password = $rq->getPost('password');
            $model = User::findByAttributes(['email' => $email]);
            if(!$model || $model->checkPassword($password)) {
                $errors = ['Invalid Email or Password'];
            } else {
                Front::instance()->getSession()->id = $model->getId();
                Front::instance()->getSession()->name = $model->getName();
                $this->redirect('/');
            }
        }
        echo $this->render('signin', compact('errors'));
    }

    /**
     * User Log Out
     */
    public function actionLogout()
    {
        Front::instance()->getSession()->destroy();
        $this->redirect('/');
    }
}
