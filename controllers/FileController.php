<?php

class FileController extends AbstractController {
    private FileManager $fm;

    public function __construct()
    {
        $this->fm = new FileManager();
    }

    // To add the file with the form
    public function uploadFile()
    {
        if(isset($_POST['upload-file']))
        {
            // Verify if the file has been uploaded with success
            if(!empty($_FILES['saved-file']) && $_FILES['saved-file']['error'] === UPLOAD_ERR_OK)
            {
                $file = $_FILES['saved-file'];

                // To get the file name
                $fileName = $file['name'];
                
                // To move the file to the right path
                $path = 'data/uploadedfile/' . $fileName . '.xml';
                move_uploaded_file($file['tmp_name'], $path);

                $newFile = new SavedFile($_SESSION['user'], $fileName, $path);

                $this->fm->addFile($newFile);

                echo "File uploaded with success";
            }
            else
            {
                // var_dump($_FILES);
                // Show the errors if one exists
                if($_FILES['saved-file']['error'] === UPLOAD_ERR_FORM_SIZE)
                {
                    echo "The file exceeds the maximum file size";
                }
                else if($_FILES['saved-file']['error'] === UPLOAD_ERR_PARTIAL)
                {
                    echo "The file could not be uploaded entirely. Try again";
                }
                else
                {
                    echo "Try again later";
                }
            }
        }
        // else 
        // {
        //     $this->render('staticpages/homepage.phtml', []);
        // }
    }

    // We want the list of the games of a user
    public function indexGames()
    {
        $gamesSaved = $this->fm->getGamesByUser($_SESSION['user_id']);
        $this->render('users/games.phtml', $gamesSaved);
    }
}

?>