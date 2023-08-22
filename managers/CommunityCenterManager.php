<?php

class CommunityCenterManager extends AbstractManager {
    private FileManager $fm;

    public function __construct()
    {
        parent::__construct();
        $this->fm = new FileManager();
    }

    // Add a bundle to the database
    public function addBundle(CommunityCenter $bundle) : CommunityCenter
    {
        $query=$this->db->prepare("SELECT * FROM community_center WHERE file_id = :file_id AND bundle_name = :name");
        $parameters=[
            'file_id' => $bundle->getFile()->getId(),
            'name' => $bundle->getBundleName()
        ];
        $query->execute($parameters);
        $existingBundle = $query->fetch(PDO::FETCH_ASSOC);

        if(!$existingBundle)
        {
            $insert=$this->db->prepare("INSERT INTO community_center (file_id, bundle_name, complete)
                                    VALUES (:file_id, :bundle_name, :complete)");
            $insertParam = [
                'file_id' => $bundle->getFile()->getId(),
                'bundle_name' => $bundle->getBundleName(),
                'complete' => $bundle->getComplete() ? 1 : 0
            ];
            $insert->execute($insertParam);

            $bundle->setId($this->db->lastInsertId());
        }
        else
        {
            $update = $this->db->prepare("UPDATE community_center SET
                file_id = :file_id,
                bundle_name = :name,
                complete = :complete
                WHERE file_id = :file_id AND bundle_name = :name");
            $updateParam = [
                'file_id' => $bundle->getFile()->getId(),
                'name' => $bundle->getBundleName(),
                'complete' => $bundle->getComplete() ? 1 : 0
            ];
            $update->execute($updateParam);
        }
        
        return $bundle;
    }

    // Get the bundles by File
    public function getBundlesByFile(int $id) : array
    {
        $query=$this->db->prepare("SELECT * FROM community_center WHERE file_id = :file_id");
        $parameters = ['file_id' => $id];
        $query->execute($parameters);
        $data=$query->fetchAll(PDO::FETCH_ASSOC);

        $bundles = [];

        foreach($data as $bundle)
        {
            $newBundle = new CommunityCenter($this->fm->getFileById($bundle['file_id']), $bundle['bundle_name'], $bundle['complete']);
            $newBundle->setId($bundle['id']);
            $bundles[] = $newBundle;
        }

        return $bundles;
    }
}

?>