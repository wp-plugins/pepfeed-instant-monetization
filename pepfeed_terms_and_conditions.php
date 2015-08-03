<div class="wrap">
<h2>PepFeed Shopping Terms and Conditions</h2>

<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>

<table class="form-table">
	<tr>
	<th scope="row">Agreement</th>
	<td>
		<?php $my_pepfeed_agreement = get_option( 'pepfeed_agreement' ); ?>
		<p><input id="pepfeed_agreement" name="pepfeed_agreement" type="checkbox" value="1" <?php checked( "1" == $my_pepfeed_agreement );?>>I authorize showing PepFeed's logos and links in my Webpage</p>
		<p class="description" id="tagline-description">When you decide to use PepFeed please be so kind and leave the plugin's footer intact. You are not the author of the software and should honor those that have worked on it.</p>
	</td>
	</tr>
</table>

<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="pepfeed_agreement" />

<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>"/>
</p>
<p>
<a href="plugins.php"> Or take me back to the plugins page.<a>
</p>


</form>

</div>
