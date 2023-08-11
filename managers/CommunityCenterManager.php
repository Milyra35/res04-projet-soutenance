<?php

class CommunityCenterManager extends AbstractManager {
    // Add a bundle to the database
    public function addBundle(CommunityCenter $bundle) : CommunityCenter
    {
        $query=$this->db->prepare("INSERT INTO community_center (file_id, bundle_name, items)
                                    VALUES (:file_id, :bundle_name, :items)");
        $parameters = [
            'file_id' => $bundle->getFile()->getId(),
            'bundle_name' => $bundle->getName(),
            'items' => $bundle->getItems()
        ];
        $query->execute($parameters);

        $data = $query->fetch(PDO::FETCH_ASSOC);
        $bundle->setId($this->db->lastInsertId());

        return $bundle;
    }
}

?>