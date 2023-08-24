<?php

class StaticPageController extends AbstractController {
    // Homepage
    public function renderHomepage()
    {
        $this->render("staticpages/homepage.phtml", []);
    }

    // Confidentiality
    public function renderConfidentiality()
    {
        $this->render("staticpages/confidentiality.phtml", []);
    }

    // Legal-notices
    public function renderLegalNotices()
    {
        $this->render("staticpages/legal-notices.phtml", []);
    }

    // Credits
    public function renderCredits()
    {
        $this->render("staticpages/credits.phtml", []);
    }
}

?>