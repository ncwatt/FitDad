<?php
	/*
 	* If the current post is protected by a password and the visitor has not yet
 	* entered the password we will return early without loading the comments.
 	*/
	if (post_password_required())
 		return;

	// Get the sort order for comments from site settings
	$comment_order = get_option('comment_order');

	$args = array(
		//'status' => 'approve',
		'post_id' => get_the_ID(),	// Post ID of the current post
		'order' => $comment_order	// Order to display comments
	);

	// Build the comments query
	$comments_query = new WP_Comment_Query();
	$comments = $comments_query->query($args);
?>


<h2>Comments</h2>
<?php if ($comments) : ?>
	<?php foreach ($comments as $comment) : ?>
		<?php if ($comment->comment_approved == '1') : ?>
			<div class="comment-header">
				<a name="comment-<?php echo $comment->comment_ID; ?>"></a>
				<?php echo get_avatar($comment->comment_author_email, $size = '60'); ?>
				<p>
					<?php 
						if ($comment->comment_author_url != '') :
							echo "<a href=\"" . $comment->comment_author_url . "\" target=\"_blank\">" . $comment->comment_author . "</a>";
						else :
							echo $comment->comment_author;
						endif;
					?>
					<br />
					<?php echo date_format(new DateTime($comment->comment_date), 'd M Y H:i'); ?>
				</p>
			</div>
			<div class="comment-content">
				<?php echo str_replace(chr(13), "<br />", $comment->comment_content); ?>
			</div>
		<?php else : ?>
			<div class="comment-header">
				<a name="comment-<?php echo $comment->comment_ID; ?>"></a>
				<?php echo get_avatar($comment->comment_author_email, $size = '60'); ?>
				<p>
					<?php echo $comment->comment_author; ?>
					<br />
					<?php echo date_format(new DateTime($comment->comment_date), 'd M Y H:i'); ?>
				</p>
			</div>
			<div class="comment-content">
				</i>This comment is awaiting moderation</i>
			</div>
		<?php endif; ?>
		<hr />
	<?php endforeach; ?>
<?php else : ?>
	<p>There are currently no comments. Why not be the first by using the form below.</p>
<?php endif; ?>



<h2>Leave a comment</h2>
<?php if(comments_open()) : ?>
	<?php if(get_option('comment_registration') && !$user_ID) : ?>
		<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
	<?php else : ?>
		<form action="<?php echo bloginfo('template_directory'); ?><?php #echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
			<?php if( is_user_logged_in() ) : ?>
				<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Log out &raquo;</a></p>
			<?php else : ?>
				<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
				<label for="author"><small>Name <?php if($req) echo "(required)"; ?></small></label></p>
				<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
				<label for="email"><small>Email (will not be published) <?php if($req) echo "(required)"; ?></small></label></p>
				<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
				<label for="url"><small>Website</small></label></p>
			<?php endif; ?>
			<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>
			<p>
				<div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITEKEY; ?>" data-callback="callbackCommentSubmit"></div>
				<script type="text/javascript">
					function callbackCommentSubmit() {
						document.getElementById("submit-comment").removeAttribute("disabled");
					}
				</script>
			</p>
			<p>
				<input name="submit" type="submit" id="submit-comment" class="submit" value="Post Comment" disabled />
            	<?php comment_id_fields(); ?>
			</p>
			<?php do_action('comment_form', $post->ID); ?>
		</form>
	<?php endif; ?>
<?php else : ?>
	<p>The comments are closed.</p>
<?php endif; ?>