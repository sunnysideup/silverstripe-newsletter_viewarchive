<?php

/**
 * This page allows you to display old newsletters.
 *
 **/

class NewsletterArchivePage extends Page {

	private static $icon = "newsletter_viewarchive/images/treeicons/NewsletterArchivePage";

	private static $description = "This page allows you to display old newletters";

	private static $has_one = array(
		"NewsletterType" => "NewsletterType"
	);

	/**
	 * Standard SS variable.
	 */
	private static $singular_name = "Newsletter Archive Page";
		function i18n_singular_name() { return _t("NewsletterArchivePage.SINGULARNAME", "Newsletter Archive Page");}

	/**
	 * Standard SS variable.
	 */
	private static $plural_name = "Newsletter Archive Pages";
		function i18n_plural_name() { return _t("NewsletterArchivePage.PLURALNAME", "Newsletter Archive Pages");}


	function getCMSFields() {
		$fields = parent::getCMSFields();
		$types = NewsletterType::get();
		if($types->count()) {
			$array = array("" => " -- Please select newsletter --");
			$array += $types->map()->toArray();
			if(count($array)) {
				$fields->addFieldToTab("Root.Newsletter", new DropdownField("NewsletterTypeID", "Select Newsletter", $array));
			}
		}
		return $fields;
	}
}

class NewsletterArchivePage_Controller extends Page_Controller {

	protected $newsletterID = 0;

	function NewsletterList() {
		if($this->NewsletterTypeID) {
			return Newsletter::get()
				->filter(
					array(
						"Status" => 'Send'
					)
				);
		}
	}

	function Newsletter() {
		if($this->newsletterID) {
			return Newsletter::get()->byID($this->newsletterID);
		}
	}

	function showonenewsletter($request) {
		if($newsletterID = intval($request->Param("ID"))) {
			$this->newsletterID = $newsletterID;
			if($newsletter = $this->Newsletter()) {
				$this->Title = $newsletter->Subject;
				$this->Content = $newsletter->Content;
			}
		}
		return array();
	}

}
