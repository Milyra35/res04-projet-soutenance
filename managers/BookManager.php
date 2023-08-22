<?php

class BookManager extends AbstractManager {
    // Add a book to the database
    public function addBook(Book $book) : Book
    {
        $query=$this->db->prepare("SELECT * FROM books WHERE file_id = :file_id AND amount = :amount");
        $parameters=[
            'file_id' => $book->getFile()->getId(),
            'amount' => $book->getAmount()
        ];
        $query->execute($parameters);
        $existingBook = $query->fetch(PDO::FETCH_ASSOC);

        if(!$existingBook)
        {
            $insert=$this->db->prepare("INSERT INTO books (file_id, amount)
                                    VALUES (:file_id, :amount)");
            $insertParam = [
                'file_id' => $book->getFile()->getId(),
                'amount' => $book->getAmount(),
            ];
            $insert->execute($parameters);

            $book->setId($this->db->lastInsertId());
        }
        else
        {
            $update = $this->db->prepare("UPDATE books SET amount = :amount WHERE file_id = :file_id");
            $updateParam = [
                'file_id' => $book->getFile()->getId(),
                'amount' => $book->getAmount()
            ];
            $update->execute($updateParam);
        }
        
        return $book;
    }
}

?>