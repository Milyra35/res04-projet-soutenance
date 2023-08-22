<?php

class BookManager extends AbstractManager {
    private FileManager $fm;

    public function __construct()
    {
        parent::__construct();
        $this->fm = new FileManager();
    }

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

    // Get the number of books by its file ID
    public function getBookByFile(int $id) : Book
    {
        $query=$this->db->prepare("SELECT * FROM books WHERE file_id = :file_id");
        $parameters=['file_id' => $id];
        $query->execute($parameters);
        $data = $query->fetch(PDO::FETCH_ASSOC);

        $newBook = new Book($this->fm->getFileById($data['file_id']), $data['amount']);
        $newBook->setId($data['id']);

        return $newBook;
    }
}

?>