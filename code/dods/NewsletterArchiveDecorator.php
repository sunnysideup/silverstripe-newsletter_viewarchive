<?php

/**
 * Decorates newsletters
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
		return NewsletterArchivePage::get()->filter()->first();
	}

	function Link()  {
		$viewingPage = $this->ViewingPage();
		if($viewingPage) {
			return $viewingPage->Link("showonenewsletter")."/".$this->owner->ID;
		}
	}

}

