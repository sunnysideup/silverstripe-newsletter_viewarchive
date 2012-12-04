<?php

/**
 * This pays allows you to display old newsletters.
 *
 **/

class NewsletterArchivePage extends Page {

	static $icon = "newsletter_viewarchive/images/treeicons/NewsletterArchivePage";

	public static $has_one = array(
		"NewsletterType" => "NewsletterType"
	);

	function getCMSFields() {
		$fields = parent::getCMSFields();
		if($types = DataObject::get("NewsletterType")) {
			$array = $types->toDropDownMap($index = 'ID', $titleField = 'Title', $emptyString = " -- Please select newsletter --");
			if($array && count($array)) {
				$fields->addFieldToTab("Root.Content.Newsletter", new DropdownField("NewsletterTypeID", "Select Newsletter", $array));
			}
		}
		return $fields;
	}
}

class NewsletterArchivePage_Controller extends Page_Controller {

	protected $newsletterID = 0;

	function NewsletterList() {
		if($this->NewsletterTypeID) {
			return DataObject::get("Newsletter", "\"Status\" = 'Send' AND \"ParentID\" = ".$this->NewsletterTypeID);
		}
	}

	function Newsletter() {
		if($this->newsletterID) {
			return DataObject::get_by_id("Newsletter", $this->newsletterID);
		}
	}

	function showonenewsletter($request) {
		if($newsletterID = intval($request->Param("ID"))) {
			$this->newsletterID = $newsletterID;
			if($newsletter = $this->Newsletter()) {
				$this->Title = $newsletter->Subject;
				$this->MetaTitle = $newsletter->Subject;
				$this->Content = $newsletter->Content;
			}
		}
		return array();
	}

}
