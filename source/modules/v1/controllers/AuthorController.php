<?php

namespace app\modules\v1\controllers;


use app\modules\v1\helpers\ResponseStatusHelper;
use app\modules\v1\models\Author;
use app\modules\v1\models\AuthorBook;
use yii\rest\Controller;

class AuthorController extends Controller
{
    public $modelClass = 'app\modules\v1\models\Author';

    public function actionListAuthors()
    {
        $response = ['status' => ResponseStatusHelper::STATUS_NOT_FOUND];

        $authors = Author::find()->asArray()->all();

        if ($authors) {
            $response['status'] = ResponseStatusHelper::STATUS_DONE;
            $response['data'] = $authors;
        }

        return $this->asJson($response);
    }

    public function actionGetAuthor(int $id)
    {
        $response = ['status' => ResponseStatusHelper::STATUS_NOT_FOUND];

        $author = Author::find()->where(['id' => $id])->asArray()->one();
        if ($author) {
            $response['status'] = ResponseStatusHelper::STATUS_DONE;
            $response['data'] = $author;
        }

        return $this->asJson($response);
    }

    public function actionAddAuthor()
    {
        $name = \Yii::$app->request->post('name');

        $response = ['status' => ResponseStatusHelper::STATUS_DONE];

        $author = new Author();
        $author->name = $name;
        if (!$author->save()) {
            $response['status'] = ResponseStatusHelper::STATUS_ERROR;
            $response['messages'] = $author->getErrors();
        }

        return $this->asJson($response);
    }

    public function actionUpdateAuthor(int $id)
    {
        $name = \Yii::$app->request->post('name');

        $response = ['status' => ResponseStatusHelper::STATUS_DONE];

        $author = Author::findOne($id);
        if ($author) {
            $author->name = $name;

            if (!$author->save()) {
                $response['status'] = ResponseStatusHelper::STATUS_ERROR;
                $response['messages'] = $author->getErrors();
            }
        }

        return $this->asJson($response);
    }

    public function actionDeleteAuthor(int $id)
    {
        $response = ['status' => ResponseStatusHelper::STATUS_DONE];

        $db = \Yii::$app->db;
        $transaction = $db->beginTransaction();

        try {
            Author::deleteAll(['id' => $id]);
            AuthorBook::deleteAll(['author_id' => $id]);

            $transaction->commit();
        } catch (\Exception $exception) {
            $response = ['status' => ResponseStatusHelper::STATUS_ERROR, 'messages' => [$exception->getMessage()]];

            $transaction->rollBack();
        }

        return $this->asJson($response);
    }
}
