<?php

/**
 * This pays allows you to display old newsletters.
 *
 **/

class NewsletterArchiveDecorator extends DataExtension {

	private static $casting = array(
		"ViewingPage" => "SiteTree",
		"Link" => "Varchar"
	);


	function getViewingPage() {
		return $this->owner->ViewingPage();
	}

	function ViewingPage() {
		if($this->owner->SentDate) {
			if($this->owner->ParentID) {
				$parent = NewsletterType::get()->byID($this->owner->ParentID);
				if($parent) {
					return NewsletterArchivePage::get()
						->filter(array("NewsletterTypeID" => $parent->ID))->first();
				}
			}
		}
	}

	function Link()  {
		$viewingPage = $this->ViewingPage();
		if($viewingPage) {
			return $viewingPage->Link("showonenewsletter")."/".$this->owner->ID;
		}
	}

}

