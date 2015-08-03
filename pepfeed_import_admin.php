<div class="wrap">
<h2>PepFeed Instant Monetization Settings</h2>

<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>

<table class="form-table">
<!--
	<tr valign="top">
	<th scope="row">Currency</th>
	<td>

	<?php $my_pepfeed_currency = get_option( 'pepfeed_currency' ); ?>
	<select name="pepfeed_currency">
	    <option value="usd" <?php selected( $my_pepfeed_currency, "usd" ); ?>>$ Dollar</option>
	    <option value="eur" <?php selected( $my_pepfeed_currency, "eur" ); ?>>€ Euro</option>
	</select>

	<p class="description" id="tagline-description">Select the currency in which the prices are displayed.</p>
	</td>
	</tr>

	<tr valign="top">
	<th scope="row">Sort Shops by</th>
	<td>

	<?php $my_pepfeed_sort_shops_by = get_option( 'pepfeed_sort_shops_by' ); ?>
	<select name="pepfeed_sort_shops_by">
	<option value="cheapest" <?php selected( $my_pepfeed_sort_shops_by, "cheapest" ); ?>>Cheapest</option>
	<option value="popular" <?php selected( $my_pepfeed_sort_shops_by, "popular" ); ?>>Popularity</option>
	</select>

	<p class="description" id="tagline-description">Sort stores by cheapest or popular.</p>
	</td>
	</tr>

	<tr valign="top">
	<th scope="row">Region</th>
	<td>

	<?php $my_pepfeed_region = get_option( 'pepfeed_region' ); ?> 
	<select name="pepfeed_region">
	<option value="us" <?php selected( $my_pepfeed_region, "us" ); ?>>United States</option>
	<option value="pt" <?php selected( $my_pepfeed_region, "pt" ); ?>>Portugal</option>
	</select>

	<p class="description" id="tagline-description">Select you preferred region for the contents.</p>
	</td>
	</tr>
-->
	<tr valign="top">
	<th scope="row">Amazon Affiliate ID</th>
		<td>
			<input type="text" name="pepfeed_amazon_affiliate_id" value="<?php echo get_option('pepfeed_amazon_affiliate_id'); ?>" />
			<p class="description" id="tagline-description">Sign up for your Amazon Affiliate/Partner account at <a href="http://affiliate-program.amazon.com/gp/associates/apply/main.html" target="_blank">http://affiliate-program.amazon.com/gp/associates/apply/main.html</a></p>
		</td>
	</tr>

<!--
	<tr>
	<th scope="row">PepFeed Display Format</th>
	<td>
		<fieldset>
		<legend class="screen-reader-text"><span>PepFeed Display Format</span></legend>
		<?php $my_pepfeed_display_format = get_option( 'pepfeed_display_format' ); ?>
		<label title="button_format"><input type="radio" name="pepfeed_display_format" value="button_format"<?php checked( 'button_format' == $my_pepfeed_display_format ); ?> >Button</label><br>
		<label title="widget_format"><input type="radio" name="pepfeed_display_format" value="widget_format"<?php checked( 'widget_format' == $my_pepfeed_display_format ); ?> >Widget</label><br>
		</fieldset>
	</td>
	</tr>
-->

	<tr>
	<th scope="row">Hide footer</th>
	<td>
		<?php $my_pepfeed_show_powered_by = get_option( 'pepfeed_show_powered_by' ); ?>
		<p><input id="pepfeed_show_powered_by" name="pepfeed_show_powered_by" type="checkbox" value="1" <?php checked( "1" == $my_pepfeed_show_powered_by );?>> Hide widget footer</p>
		<p class="description" id="tagline-description">When you decide to use PepFeed please be so kind and leave the plugin's footer intact. You are not the author of the software and should honor those that have worked on it.</p>
	</td>
	</tr>

</table>

<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="pepfeed_amazon_affiliate_id,pepfeed_show_powered_by" />
<!-- <input type="hidden" name="page_options" value="pepfeed_currency,pepfeed_sort_shops_by,pepfeed_region,pepfeed_amazon_affiliate_id,pepfeed_display_format,pepfeed_show_powered_by" /> -->

<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>

</form>
<?php
	echo 'powered by <a href="http://pepfeed.com">PepFeed</a> v' . pepfeed_cc_author_admin_init();
?>
</div>
