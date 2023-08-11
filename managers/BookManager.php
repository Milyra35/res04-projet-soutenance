<?php

class BookManager extends AbstractManager {
    // Add a book to the database
    public function addBook(Book $book) : Book
    {
        $query=$this->db->prepare("INSERT INTO books (file_id, name, has)
                                    VALUES (:file_id, :name, :has)");
        $parameters = [
            'file_id' => $book->getFile()->getId(),
            'name' => $book->getName(),
            'has' => $book->getHas()
        ];
        $query->execute($parameters);

        $data = $query->fetch(PDO::FETCH_ASSOC);
        $book->setId($this->db->lastInsertId());

        return $book;
    }
}

?>