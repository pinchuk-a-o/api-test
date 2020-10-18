<?php

namespace app\modules\v1\controllers;


use app\modules\v1\helpers\ResponseStatusHelper;
use app\modules\v1\models\AuthorBook;
use app\modules\v1\models\Book;
use yii\rest\Controller;

class BookController extends Controller
{
    public $modelClass = 'app\modules\v1\models\Book';

    public function actionListBooks()
    {
        $response = ['status' => ResponseStatusHelper::STATUS_NOT_FOUND];

        $books = Book::find()->asArray()->all();

        if ($books) {
            $response['status'] = ResponseStatusHelper::STATUS_DONE;
            $response['data'] = $books;
        }

        return $this->asJson($response);
    }

    public function actionGetBook(int $id)
    {
        $response = ['status' => ResponseStatusHelper::STATUS_NOT_FOUND];

        $book = Book::find()->where(['id' => $id])->asArray()->one();
        if ($book) {
            $response['status'] = ResponseStatusHelper::STATUS_DONE;
            $response['data'] = $book;
        }

        return $this->asJson($response);
    }

    public function actionAddBook()
    {
        $name = \Yii::$app->request->post('name');

        $response = ['status' => ResponseStatusHelper::STATUS_DONE];

        $book = new Book();
        $book->name = $name;
        if (!$book->save()) {
            $response['status'] = ResponseStatusHelper::STATUS_ERROR;
            $response['messages'] = $book->getErrors();
        }

        return $this->asJson($response);
    }

    public function actionUpdateBook(int $id)
    {
        $name = \Yii::$app->request->post('name');

        $response = ['status' => ResponseStatusHelper::STATUS_DONE];

        $book = Book::findOne($id);
        if ($book) {
            $book->name = $name;

            if (!$book->save()) {
                $response['status'] = ResponseStatusHelper::STATUS_ERROR;
                $response['messages'] = $book->getErrors();
            }
        }

        return $this->asJson($response);
    }

    public function actionDeleteBook(int $id)
    {
        $response = ['status' => ResponseStatusHelper::STATUS_DONE];

        $db = \Yii::$app->db;
        $transaction = $db->beginTransaction();

        try {
            Book::deleteAll(['id' => $id]);
            AuthorBook::deleteAll(['book_id' => $id]);

            $transaction->commit();
        } catch (\Exception $exception) {
            $response = ['status' => ResponseStatusHelper::STATUS_ERROR, 'messages' => [$exception->getMessage()]];

            $transaction->rollBack();
        }

        return $this->asJson($response);
    }
}
