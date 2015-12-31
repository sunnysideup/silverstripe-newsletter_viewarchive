<?php

/**
 * This page allows you to display old newsletters.
 *
 **/

class NewsletterArchivePage extends Page
{

    private static $icon = "newsletter_viewarchive/images/treeicons/NewsletterArchivePage";

    private static $description = "This page allows you to display old newletters";

    private static $many_many = array(
        "MailingLists" => "MailingList"
    );

    /**
     * Standard SS variable.
     */
    private static $singular_name = "Newsletter Archive Page";
    public function i18n_singular_name()
    {
        return _t("NewsletterArchivePage.SINGULARNAME", "Newsletter Archive Page");
    }

    /**
     * Standard SS variable.
     */
    private static $plural_name = "Newsletter Archive Pages";
    public function i18n_plural_name()
    {
        return _t("NewsletterArchivePage.PLURALNAME", "Newsletter Archive Pages");
    }


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab("Root.Newsletter", new CheckboxSetField("MailingLists", "Show Mailing Lists", MailingList::get()->map()));
        return $fields;
    }
}

class NewsletterArchivePage_Controller extends Page_Controller
{

    private static $allowed_actions = array(
        "showonenewsletter"
    );

    protected $newsletterID = 0;

    public function NewsletterList()
    {
        $newsletterArray = array();
        if ($mailingLists = $this->MailingLists()) {
            foreach ($mailingLists as $mailingList) {
                $newsletterItems = $mailingList->Newsletters()->map("ID", "ID")->toArray();
                foreach ($newsletterItems as $newsletterItemID => $newsletterItem) {
                    $newsletterArray[$newsletterItemID] = $newsletterItemID;
                }
            }
            $items =  Newsletter::get()->filter(
                array(
                    "Status" => "Sent",
                    "ID" => $newsletterArray
                )
            );
        } else {
            $items = Newsletter::get()->filter(array("Status" => "Sent"));
        }
        return $items;
    }

    public function Newsletter()
    {
        if ($this->newsletterID) {
            return Newsletter::get()->byID($this->newsletterID);
        }
    }

    public function showonenewsletter($request)
    {
        if ($this->newsletterID = intval($request->Param("ID"))) {
            if ($newsletter = $this->Newsletter()) {
                $this->Title = $newsletter->Subject;
                $this->Content = $newsletter->Content;
            }
        }
        return array();
    }
}
