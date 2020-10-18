<?php

use yii\db\Migration;

/**
 * Class m201017_123255_init
 */
class m201017_123255_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE author
                            (
                                id   INT AUTO_INCREMENT PRIMARY KEY,
                                name VARCHAR(32) NOT NULL
                            ) CHARACTER SET utf8mb4;
                            
                            CREATE TABLE book
                            (
                                id   INT AUTO_INCREMENT PRIMARY KEY,
                                name VARCHAR(32) NOT NULL
                            ) CHARACTER SET utf8mb4;
                            
                            CREATE TABLE author_book
                            (
                                author_id INT NOT NULL,
                                book_id   INT NOT NULL
                            )"
        );

        $this->insert('author', ['id' => 1, 'name' => 'Джордж Оруэлл']);
        $this->insert('author', ['id' => 2, 'name' => 'Ганс Фреймарк']);
        $this->insert('author_book', ['author_id' => 1, 'book_id' => 1]);
        $this->insert('author_book', ['author_id' => 1, 'book_id' => 2]);
        $this->insert('author_book', ['author_id' => 2, 'book_id' => 3]);
        $this->insert('book', ['id' => 1, 'name' => '1984']);
        $this->insert('book', ['id' => 2, 'name' => 'Скотный двор']);
        $this->insert('book', ['id' => 3, 'name' => 'Оккультизм и сексуальность']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return false;
    }
}
