<?php

/**
 * Decorates newsletters
 *
 **/

class NewsletterArchiveDecorator extends DataExtension
{

    private static $casting = array(
        "ViewingPage" => "SiteTree",
        "Link" => "Varchar"
    );

    public function getViewingPage()
    {
        return $this->owner->ViewingPage();
    }

    public function ViewingPage()
    {
        $mailingLists = $this->owner->MailingLists();
        $mailingListArray[0] = 0;
        $mailingListArray += $mailingLists->map("ID", "ID")->toArray();
        $count = DB::query("SELECT  COUNT(\"NewsletterArchivePageID\")  FROM  \"NewsletterArchivePage_MailingLists\"  WHERE  \"MailingListID\" IN (".implode(",", $mailingListArray).") LIMIT 1")->value();
        if ($count) {
            $value = DB::query("SELECT  \"NewsletterArchivePageID\"  FROM  \"NewsletterArchivePage_MailingLists\"  WHERE  \"MailingListID\" IN (".implode(",", $mailingListArray).") LIMIT 1")->value();
            return NewsletterArchivePage::get()->byID($value);
        }
    }

    public function ViewLink()
    {
        $viewingPage = $this->owner->ViewingPage();
        if ($viewingPage) {
            return $viewingPage->Link("showonenewsletter")."/".$this->owner->ID;
        }
    }
}
