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
            if(!empty($_FILES['add-picture']))
            {
                $picture = $_FILES['add-picture'];

                foreach($picture['name'] as $key => $pictureName)
                {
                    if($picture['error'][$key] === UPLOAD_ERR_OK)
                    {
                        $nameWithoutExtension = pathinfo($pictureName, PATHINFO_FILENAME);
                        $name = str_replace('_', ' ', $nameWithoutExtension);

                        $path = 'assets/images/game_pictures/' . $pictureName;
                        $alt = 'Drawing of' . ' ' . $nameWithoutExtension;
                        $newPicture = new Picture($name, $path, $alt);

                        $this->pm->addPicture($newPicture);

                        echo "<p>File uploaded with success</p>";
                    }
                    else
                    {
                        echo "<p>Failed to upload the file</p>";
                    }
                }
                // $pictureName = $picture['name'];
            }
            else
            {
                echo "<p>No files were uploaded.</p>";
                var_dump($_FILES);
            }
        }
    }
}

?>