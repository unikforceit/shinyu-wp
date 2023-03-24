		
	<?php $my_current_lang = apply_filters( 'wpml_current_language', NULL );
		// Check WPML current lang and put in in variable to create custom logic - Nutn0n, Nov 28, 2022. 
		?>

<section class="subscribe">
				<subscribe></subscribe>
			</section>
			<footer class="site-footer">
				<div class="container">
					<div class="columns">
						<div class="column">
							<ul class="is-primary">
								<li>
									<a href="<?php echo get_permalink(PAGE_ID_SEARCH); ?>?transaction=sell"><?php pll_e('Condo For Sale'); ?></a>
								</li>
								<li>
									<a href="<?php echo get_permalink(PAGE_ID_SEARCH); ?>?transaction=rent"><?php pll_e('Condo For Rent'); ?></a>
								</li>
								<li>
									<a href="<?php echo get_permalink(PAGE_ID_POST_PROPERTY); ?>"><?php pll_e('Post Property'); ?></a>
								</li>
								<li>
									<a href="<?php echo get_post_type_archive_link('promotion'); ?>">
									<?php if($my_current_lang == 'th'){ echo('โปรโมชัน'); } elseif($my_current_lang == 'ja'){ echo('プロモーション'); } else{ echo('Promotion'); } ?>
									</a>
								</li>
								<li>
									<a href="<?php echo get_post_type_archive_link('service'); ?>"><?php pll_e('Other services'); ?></a>
								</li>
							</ul>
						</div>
						<div class="column">
							<h3><?php pll_e('Interesting locations'); ?></h3>
							<ul>
							<?php
								$terms = get_terms('room_tag', array(
									'hide_empty' => false,
									'orderby'    => 'date',
									'order'      => 'DESC',
									'meta_query' => array(
										array(
											'key'       => 'room_tag_display_footer',
											'value'     => 1,
											'compare'   => '='
										)
									)
								));
								if (!empty($terms) && !is_wp_error($terms)){
									foreach ($terms as $term) {
											$link = get_permalink(PAGE_ID_SEARCH);
											$link = add_query_arg([
												'transaction' => 'rent',
												'tag_id' => $term->term_id,
												'q' => $term->name,
											], $link); ?>
										<li><a href="<?php echo $link; ?>"><?php echo $term->name; ?></a></li>
									<?php }
								}
							?>
							</ul>

							<h3><?php pll_e('Follow us'); ?></h3>
							<ul class="social">
								<li>
									<div class="b-tooltip is-danger is-top is-medium is-square">
										<div class="tooltip-content">Facebook</div>
										<div class="tooltip-trigger">
											<a href="<?php the_field('social_facebook_url', 'option'); ?>" target="_blank">
												<?php shinyu_icon('facebook-2'); ?>
											</a>
										</div>
									</div>
								</li>
								<li>
									<div class="b-tooltip is-danger is-top is-medium is-square">
										<div class="tooltip-content">Line</div>
										<div class="tooltip-trigger">
											<a href="<?php the_field('social_line_url', 'option'); ?>" target="_blank">
												<?php shinyu_icon('line'); ?>
											</a>
										</div>
									</div>
								</li>
								<li>
									<div class="b-tooltip is-danger is-top is-medium is-square">
										<div class="tooltip-content">Instagram</div>
										<div class="tooltip-trigger">
											<a href="<?php the_field('social_instagram_url', 'option'); ?>" target="_blank">
												<?php shinyu_icon('instagram'); ?>
											</a>
										</div>
									</div>
								</li>
								<li>
									<div class="b-tooltip is-danger is-top is-medium is-square">
										<div class="tooltip-content">Facebook Messenger</div>
										<div class="tooltip-trigger">
											<a href="<?php the_field('social_messenger_url', 'option'); ?>" target="_blank">
												<?php shinyu_icon('messenger'); ?>
											</a>
										</div>
									</div>
								</li>
								<li>
									<div class="b-tooltip is-danger is-top is-medium is-square">
										<div class="tooltip-content">Youtube</div>
										<div class="tooltip-trigger">
											<a href="<?php the_field('social_youtube_url', 'option'); ?>" target="_blank">
												<?php shinyu_icon('youtube-2'); ?>
											</a>
										</div>
									</div>
								</li>
							</ul>
						</div>
						<div class="column train-station-column">
							<h3><?php pll_e('Travel'); ?></h3>
							<div class="train-station"><train-station></train-station></div>
						</div>
						<div class="column pl-sm-6">
							<h3><?php pll_e('Developers/Brands'); ?></h3>
							<?php
							$terms = get_terms('project_developer', array(
								'hide_empty' => false,
								'meta_query' => array(
									array(
										'key'       => 'project_developer_recommend',
										'value'     => '1',
										'compare'   => '='
									)
								)
							));
							?>

							
							<?php if ($terms) { ?>
								<ul>
								<?php foreach ($terms as $term) : ?>
									<li><a href="<?php echo get_permalink(PAGE_ID_SEARCH) . '?transaction=rent&developer=' . $term->slug ?>" class="viewall"><?php echo $term->name; ?></a></li>
								<?php endforeach; ?>
									<li><a href="<?php echo get_permalink(PAGE_ID_SEARCH); ?>" class="viewall"><?php pll_e('View More'); ?></a></li>
								</ul>
							<?php } ?>
						</div>
					</div>
					<div class="site-footer-copyright d-flex justify-content-between">
						<div class="d-flex">
							<p>Copyright 2021 Shinyu Real Estate Co.,Ltd. All rights reserved.</p>
							<ul class="d-none d-lg-block">
								<li><a href="<?php echo get_permalink(PAGE_ID_TERMS_AND_CONDITIONS); ?>">Terms and Conditions</a></li>
								<li><a href="<?php echo get_permalink(PAGE_ID_PRIVACY_POLICY); ?>">Privacy Policy</a></li>
							</ul>
						</div>
						<div class="d-none d-lg-block">Member of Thailand Real Estate Broker Association</div>
					</div>
				</div>
			</footer>
		</div>

		<ul class="quick-contact">
			<li class="messenger">
				<a href="https://www.messenger.com/t/ShinyuRealEstate" target="_blank"><?php shinyu_icon('messenger3'); ?></a>
			</li>
			<li class="line">
				<a href="https://lin.ee/536xXCX" target="_blank"><?php shinyu_icon('line3'); ?></a>
			</li>
			<li class="phone">
				<a href="tel:020013033"><?php shinyu_icon('phone'); ?></a>
			</li>
		</ul>

		<?php wp_footer(); ?>
	</body>
</html>


<?php

// $order = wc_get_order(31857);
// $date = $order->get_date_created();

// $date = date_i18n('j', strtotime($date));
// $M = date_i18n('n', strtotime($date));
// $YY = date_i18n('Y', strtotime($date));

// echo $D . '<br>';
// echo $M . '<br>';
// echo $YY . '<br>';


	// $order_id = 31490;

	// $body = [
	// 	'merchantId' => '9986',
	// 	'loginId'    => 'ShinyuApi',
	// 	'password'   => 'Password123',
	// 	'actionType' => 'Query',
	// 	'orderRef'   => $order_id,
	// 	'payRef'     => null
	// ];

	// $response = wp_remote_post('https://psipay.bangkokbank.com/b2c/eng/merchant/api/orderApi.jsp', [
	// 		'method'      => 'POST',
	// 		'timeout'     => 45,
	// 		'redirection' => 5,
	// 		'httpversion' => '1.0',
	// 		'blocking'    => true,
	// 		'headers'     => [],
	// 		'body'        => $body,
	// 	]
	// );

	// $xml = simplexml_load_string($response['body']);



	// echo '<pre>';
	// print_r($xml->record);
	// echo '</pre>';

?>