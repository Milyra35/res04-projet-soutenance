<?php

class MediaController extends AbstractController {
    private PictureManager $pm;

    public function __construct()
    {
        $this->pm = new PictureManager();
    }

    // To add a picture to the database with the admin account
    public function addPicture()
    {
        if(isset($_POST['upload-picture']))
        {
            if(!empty($_FILES['add-picture']) && $_FILES['add-picture']['error'] === UPLOAD_ERR_OK)
            {
                $picture = $_FILES['add-picture'];
                $pictureName = $picture['name'];
                $nameWithoutExtension = pathinfo($pictureName, PATHINFO_FILENAME);

                $path = 'assets/images/villagers/' . $pictureName;
                $alt = 'Drawing of' . ' ' . $nameWithoutExtension;
                $newPicture = new Picture($nameWithoutExtension, $path, $alt);

                $this->pm->addPicture($newPicture);

                echo "<p>File uploaded with success</p>";
            }
            else
            {
                echo "<p>Try later, there is an error</p>";
            }
        }
    }
}

?>