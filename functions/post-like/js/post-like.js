jQuery(document).ready(function ($) {
	$(".post-like").on('click', function () {
		heart = $(this);
		// Retrieve post ID from data attribute
		post_id = heart.data("post_id");
		// Ajax call
		jQuery.ajax({
			type: "post",
			url: ajax_var.url,
			data: "action=post-like&nonce=" + ajax_var.nonce + "&post_like=&post_id=" + post_id,
			success: function (count) {
				// If vote successful
				if (count != "already")
				{
					heart.addClass("alreadyvoted");
					heart.siblings(".count").text(count + ' Likes');
				}
			}
		});

		return false;
	});
});