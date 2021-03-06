<?php if(!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) : ?>
<?php endif; ?>
	
<?php if(!empty($post->post_password)) : ?>
	<?php if($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) : ?>
	<?php endif; ?>
<?php endif; ?>

<?php if($comments) : ?>
	<?php foreach($comments as $comment) : ?>
		<?php if ($comment->comment_approved == '0') : ?>
		<?php endif; ?>
	<?php endforeach; ?>
<?php else : ?>
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