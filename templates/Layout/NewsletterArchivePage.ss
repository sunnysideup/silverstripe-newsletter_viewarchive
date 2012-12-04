
<% if Newsletter %>
	<div id="OneNewsletterHolder">
	<% control Newsletter %>
		<h3>$Subject</h3>
		<p class="timeOfSending">$SentDate.Long</p>
		<div class="contentHolder">$Content</div>
		<% if ViewingPage %><p class="backToMainPage">&raquo; Back to <a href="$ViewingPage.Link">$ViewingPage.Title</a>.</p><% end_if %>
	<% end_control %>
	</div>

<% else %>

	<div class="contentHolder">$Content</div>
	<% if NewsletterList %>
	<ul id="NewsletterList">
		<% control NewsletterList %>
		<li class="$FirstLast item"><a href="$Link">$Subject, $SentDate.Long</a></li>
		<% end_control %>
	</ul>
	<% end_if %>

<% end_if %>
