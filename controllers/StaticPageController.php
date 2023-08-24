<?php

class StaticPageController extends AbstractController {
    // Homepage
    public function renderHomepage()
    {
        $this->render("staticpages/homepage.phtml", "Homepage", []);
    }

    // Confidentiality
    public function renderConfidentiality()
    {
        $this->render("staticpages/confidentiality.phtml", "Confidentiality", []);
    }

    // Legal-notices
    public function renderLegalNotices()
    {
        $this->render("staticpages/legal-notices.phtml", "Legal Notices", []);
    }

    // Credits
    public function renderCredits()
    {
        $this->render("staticpages/credits.phtml", "Credits", []);
    }
}

?>