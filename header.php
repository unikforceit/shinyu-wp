<!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?php echo wp_is_mobile() ? 'mobile' : 'pc'; ?>">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <meta name="theme-color" id="theme-color" content="#0f4b81">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="msapplication-TileColor" content="#0f4b81">
    <meta name="facebook-domain-verification" content="91sxs41r5xencus793r9fwhkc5k2qc"/>
    <?php wp_head(); ?>
    <!-- LINE Tag Base Code -->
    <!-- Do Not Modify -->
    <script>
        (function (g, d, o) {
            g._ltq = g._ltq || [];
            g._lt = g._lt || function () {
                g._ltq.push(arguments)
            };
            var h = location.protocol === 'https:' ? 'https://d.line-scdn.net' : 'http://d.line-cdn.net';
            var s = d.createElement('script');
            s.async = 1;
            s.src = o || h + '/n/line_tag/public/release/v1/lt.js';
            var t = d.getElementsByTagName('script')[0];
            t.parentNode.insertBefore(s, t);
        })(window, document);
        _lt('init', {
            customerType: 'lap',
            tagId: 'c60b5996-7b41-4c69-8990-076281df0fd0'
        });
        _lt('send', 'pv', ['c60b5996-7b41-4c69-8990-076281df0fd0']);
    </script>
    <noscript>
        <img height="1" width="1" style="display:none"
             src="https://tr.line.me/tag.gif?c_t=lap&t_id=c60b5996-7b41-4c69-8990-076281df0fd0&e=pv&noscript=1"/>
    </noscript>
    <!-- End LINE Tag Base Code -->
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php $my_current_lang = apply_filters('wpml_current_language', NULL);
// Check WPML current lang and put in in variable to create custom logic - Nutn0n, Nov 28, 2022.
?>

<div class="wrapper">
    <header class="header site-header">
        <div class="d-flex">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="site-branding" aria-label="">
                <img src="<?php echo content_url('uploads/2022/07/logo-new.png') ?>" alt="">
            </a>
            <nav class="site-navigation">
                <ul>
                    <li class="navigation-item<?php if (get_query_var('transaction') === 'sell') echo ' is-active'; ?>"
                        data-transaction="sell">
                        <a href="<?php echo get_permalink(PAGE_ID_SEARCH); ?>?transaction=sell"><?php pll_e('Buy'); ?></a>
                    </li>
                    <li class="navigation-item<?php if (get_query_var('transaction') === 'rent') echo ' is-active'; ?>"
                        data-transaction="rent">
                        <a href="<?php echo get_permalink(PAGE_ID_SEARCH); ?>?transaction=rent"><?php pll_e('Rent'); ?></a>
                    </li>
                    <li class="navigation-item<?php if (is_post_type_archive('project')) echo ' is-active'; ?>">
                        <a href="<?php echo get_post_type_archive_link('project'); ?>">
                            <?php if ($my_current_lang == 'th') {
                                echo('โปรเจ็ค');
                            } elseif ($my_current_lang == 'ja') {
                                echo('プロジェクト');
                            } else {
                                echo('Project');
                            } ?>
                        </a>
                    </li>
                    <li class="navigation-item<?php if (is_post_type_archive('promotion')) echo ' is-active'; ?>">
                        <a href="<?php echo get_post_type_archive_link('promotion'); ?>">
                            <?php if ($my_current_lang == 'th') {
                                echo('โปรโมชั่น');
                            } elseif ($my_current_lang == 'ja') {
                                echo('プロモーション');
                            } else {
                                echo('Promotion');
                            } ?>
                        </a>
                    </li>
                    <li class="navigation-item<?php if (is_page('post-property')) echo ' is-active'; ?>">
                        <a href="<?php echo get_permalink(PAGE_ID_POST_PROPERTY); ?>"><?php pll_e('Post Property'); ?></a>
                    </li>
                    <!-- <li class="navigation-item<?php if (is_page('contact')) echo ' is-active'; ?>">
								<a href="<?php echo get_permalink(PAGE_ID_CONTACT); ?>">ติดต่อทีมงาน</a>
							</li> -->
                    <!-- <li class="navigation-item<?php if (is_page('academy')) echo ' is-active'; ?>">
								<a href="<?php echo get_permalink(PAGE_ID_ACADEMY); ?>"><?php echo get_the_title(PAGE_ID_ACADEMY); ?></a>
							</li> -->
                </ul>
            </nav>
            <div class="header-end d-flex">
                <!-- <a class="header-contact d-none d-xl-inline" href="<?php echo get_permalink(PAGE_ID_CONTACT_FORM); ?>"><?php pll_e('Contact Us'); ?></a> -->
                <!-- <div class="header-compare">
							<?php shinyu_icon('compare'); ?>
						</div> -->
                <div class="dropdown is-hoverable currency-switcher">
                    <div class="dropdown-trigger">
                        <span><?php echo CURRENCY; ?></span>
                    </div>
                    <div class="dropdown-menu" id="dropdown-menu4" role="menu">
                        <div class="dropdown-content">
                            <?php
                            $currencies = get_all_currencies();
                            foreach ($currencies as $currency) {
                                if ($currency['code'] !== CURRENCY) { ?>
                                    <a class="dropdown-item" href="#"
                                       data-code="<?php echo $currency['code']; ?>"><?php echo $currency['code']; ?></a>
                                <?php }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="dropdown is-hoverable languages-switcher">
                    <div class="dropdown-trigger">
                        <img src="<?php echo STATIC_URI . '/flag/' . pll_current_language('slug') . '.svg' ?>" alt="">
                    </div>
                    <div class="dropdown-menu" id="dropdown-menu4" role="menu">
                        <div class="dropdown-content">
                            <?php echo languages_switcher(); ?>
                        </div>
                    </div>
                </div>
                <div class="hamburger-menu">
                    <div class="hamburger">
                        <div class="hamburger-box">
                            <div class="hamburger-inner"></div>
                        </div>
                    </div>
                    <div class="rippleJS"></div>
                </div>
                <div class="header-account">
                    <a href="<?php echo get_permalink(PAGE_ID_ACCOUNT); ?>"
                       class="account-icon is-block"><?php shinyu_icon('user-2'); ?></a>
                </div>
            </div>
        </div>
    </header>
    <div class="fullscreen-navigation">
        <div class="fullscreen-navigation-body">
            <div class="container d-block d-lg-none">
                <ul>
                    <li>
                        <a href="<?php echo get_permalink(PAGE_ID_SEARCH); ?>?transaction=sell"><?php pll_e('Buy'); ?></a>
                    </li>
                    <li class="<?php if (get_query_var('transaction') === 'rent') echo ' is-active'; ?>"
                        data-transaction="rent">
                        <a href="<?php echo get_permalink(PAGE_ID_SEARCH); ?>?transaction=rent"><?php pll_e('Rent'); ?></a>
                    </li>
                    <li class="<?php if (is_post_type_archive('project')) echo ' is-active'; ?>">
                        <a href="<?php echo get_post_type_archive_link('project'); ?>">
                            <?php if ($my_current_lang == 'th') {
                                echo('โปรเจ็ค');
                            } elseif ($my_current_lang == 'ja') {
                                echo('プロジェクト');
                            } else {
                                echo('Project');
                            } ?>
                        </a>
                    </li>
                    <li class="<?php if (is_post_type_archive('promotion')) echo ' is-active'; ?>">
                        <a href="<?php echo get_post_type_archive_link('promotion'); ?>">
                            <?php if ($my_current_lang == 'th') {
                                echo('โปรโมชั่น');
                            } elseif ($my_current_lang == 'ja') {
                                echo('プロモーション');
                            } else {
                                echo('Promotion');
                            } ?>
                        </a>
                    </li>
                    <li class="<?php if (is_page('post-property')) echo ' is-active'; ?>">
                        <a href="<?php echo get_permalink(PAGE_ID_POST_PROPERTY); ?>"><?php pll_e('Post Property'); ?></a>
                    </li>
                    <li>
                        <a href="<?php echo get_permalink(PAGE_ID_ABOUT); ?>"><?php echo get_the_title(PAGE_ID_ABOUT); ?></a>
                    </li>
                    <li>
                        <a href="<?php echo get_post_type_archive_link('service'); ?>"><?php pll_e('Our Services'); ?></a>
                    </li>
                    <li class="<?php if (is_page('academy')) echo ' is-active'; ?>">
                        <a href="<?php echo get_permalink(PAGE_ID_ACADEMY); ?>"><?php echo get_the_title(PAGE_ID_ACADEMY); ?></a>
                    </li>
                    <li>
                        <a href="<?php echo get_post_type_archive_link('news'); ?>"><?php pll_e('News and Articles'); ?></a>
                    </li>
                    <!--<li><a href="<?php echo get_post_type_archive_link('job') ?>">ร่วมงานกับเรา</a></li>-->
                    <li>
                        <a href="<?php echo get_permalink(PAGE_ID_CONTACT_FORM); ?>"><?php echo get_the_title(PAGE_ID_CONTACT); ?></a>
                    </li>
                </ul>
            </div>
            <div class="container d-none d-lg-block">
                <div class="columns">
                    <div class="column is-3">
                        <h3>
                            <a href="<?php echo get_permalink(PAGE_ID_ABOUT); ?>"><?php echo get_the_title(PAGE_ID_ABOUT); ?></a>
                        </h3>
                        <ul>
                            <li>
                                <a href="<?php echo get_permalink(PAGE_ID_ABOUT); ?>?section=shinyu-value">Shinyu
                                    Value</a>
                            </li>
                            <li>
                                <a href="<?php echo get_permalink(PAGE_ID_ABOUT); ?>?section=team"><?php pll_e('Our Team'); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo get_permalink(PAGE_ID_ABOUT); ?>?section=developer"><?php pll_e('The Developer'); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo get_permalink(PAGE_ID_ABOUT); ?>?section=partner"><?php pll_e('Our Partners'); ?></a>
                            </li>
                        </ul>
                    </div>
                    <div class="column is-3">
                        <h3><a href=""><?php pll_e('Our Services'); ?></a></h3>
                        <ul class="our-services">
                            <?php
                            $args = [
                                'post_type' => 'service',
                                'posts_per_page' => 9,
                                'post_status' => 'publish',
                            ];

                            $the_query = new WP_Query($args);

                            if ($the_query->have_posts()) :
                                while ($the_query->have_posts()) : $the_query->the_post(); ?>
                                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                                <?php endwhile;
                                wp_reset_postdata();
                            endif;
                            ?>
                        </ul>
                    </div>

                    <div class="column is-3">
                        <h3>
                            <a href="<?php echo get_permalink(PAGE_ID_PACKAGES); ?>"><?php echo get_the_title(PAGE_ID_PACKAGES); ?></a>
                        </h3>


                        <?php
                        $args = [
                            'post_type' => 'product',
                            'posts_per_page' => 4,
                            'post_status' => 'publish',
                            'order' => 'DESC',
                            'tax_query' => [
                                'relation' => 'AND',
                                [
                                    'taxonomy' => 'product_cat',
                                    'field' => 'slug',
                                    'terms' => 'packages',
                                    'operator' => 'IN'
                                ],
                                [
                                    'taxonomy' => 'product_visibility',
                                    'field' => 'name',
                                    'terms' => 'exclude-from-catalog',
                                    'operator' => 'NOT IN',
                                ],
                            ],
                        ];

                        $the_query = new WP_Query($args);

                        if ($the_query->have_posts()) : ?>
                            <ul>
                                <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
                                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                                <?php endwhile; ?>
                            </ul>
                            <?php wp_reset_postdata();
                        endif;
                        ?>
                    </div>

                    <div class="column is-3">
                        <!-- <h3><a href="<?php echo get_permalink(PAGE_ID_ACADEMY); ?>"><?php echo get_the_title(PAGE_ID_ACADEMY); ?></a></h3>
								<?php
                        $args = [
                            'post_type' => 'product',
                            'posts_per_page' => -1,
                            'post_status' => 'publish',
                            'order' => 'DESC',
                            'tax_query' => [
                                'relation' => 'AND',
                                [
                                    'taxonomy' => 'product_cat',
                                    'field' => 'slug',
                                    'terms' => 'courses',
                                    'operator' => 'IN'
                                ],
                                [
                                    'taxonomy' => 'product_visibility',
                                    'field' => 'name',
                                    'terms' => 'exclude-from-catalog',
                                    'operator' => 'NOT IN',
                                ],
                            ]
                        ];

                        $the_query = new WP_Query($args);

                        if ($the_query->have_posts()) : ?>
										<ul>
										<?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
											<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
										<?php endwhile; ?>
										</ul>
										<?php wp_reset_postdata();
                        endif;
                        ?> -->
                    </div>
                </div>

                <div class="columns columns-2">
                    <div class="column is-3">
                        <h3><a href="<?php echo get_permalink(PAGE_ID_CALCULATOR); ?>"><?php pll_e('Tool'); ?></a></h3>
                        <ul>
                            <li>
                                <a href="<?php echo get_permalink(PAGE_ID_CALCULATOR); ?>">
                                    <?php echo get_the_title(PAGE_ID_CALCULATOR); ?>
                                </a>
                            </li>
                            <!-- <li>
										<a href="<?php echo get_permalink(PAGE_ID_STATISTICS); ?>">
											<?php echo get_the_title(PAGE_ID_STATISTICS); ?>
										</a>
									</li> -->
                            <!-- <li>
                                <a href="#">Foreigners’ Guide</a>
                            </li> -->
                            <li>
                                <a href="<?php echo get_permalink(PAGE_ID_COMPARE); ?>">
                                    <?php echo get_the_title(PAGE_ID_COMPARE); ?>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="column is-3">
                        <h3>
                            <a href="<?php echo get_post_type_archive_link('news'); ?>"><?php pll_e('News and Articles'); ?></a>
                        </h3>
                        <ul>
                            <?php $terms = get_terms('news_cat');
                            if (!empty($terms) && !is_wp_error($terms)) {
                                foreach ($terms as $term) { ?>
                                    <li>
                                        <a href="<?php echo get_term_link($term->term_id); ?>"><?php echo $term->name ?></a>
                                    </li>
                                <?php }
                            } ?>
                        </ul>
                    </div>

                    <div class="column is-3">
                        <h3><a href="<?php echo get_permalink(PAGE_ID_CONTACT); ?>"><?php pll_e('Contact Us'); ?></a>
                        </h3>
                        <ul>
                            <?php if ($my_current_lang == 'th'): ?>
                                <li><a href="<?php echo get_post_type_archive_link('job') ?>">ร่วมงานกับเรา</a></li>
                            <?php endif; ?>
                            <li>
                                <a href="<?php echo get_permalink(PAGE_ID_CONTACT); ?>"><?php echo get_the_title(PAGE_ID_CONTACT); ?></a>
                            </li>
                            <!-- <li><a href="<?php echo get_permalink(PAGE_ID_SITEMAP) ?>"><?php echo get_the_title(PAGE_ID_SITEMAP); ?></a></li> -->
                        </ul>
                    </div>

                    <div class="column is-3">
                        <ul class="social no-effect">
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
                </div>
            </div>
        </div>
        <div class="fullscreen-navigation-footer">
            <div class="container d-none d-lg-flex justify-content-between">
                <div class="d-flex">
                    <p>© 2021 Shinyu Real Estate Co.,Ltd. All Rights Reserved.</p>
                    <ul class="no-effect">
                        <li><a href="#">Terms and Conditions</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
                <div>Member of Thailand Real Estate Broker Association</div>
            </div>
        </div>
    </div>
