<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16-11-2018
 * Time: 8:47 AM
 * Since: 1.0.0
 * Updated: 1.0.0
 */
while (have_posts()): the_post();
    $price = STHotel::get_price();
    $post_id = get_the_ID();
    $hotel_star = (int)get_post_meta($post_id, 'hotel_star', true);
    $address = get_post_meta($post_id, 'address', true);
    $review_rate = STReview::get_avg_rate();
    $count_review = get_comment_count($post_id)['approved'];
    $lat = get_post_meta($post_id, 'map_lat', true);
    $lng = get_post_meta($post_id, 'map_lng', true);
    $zoom = get_post_meta($post_id, 'map_zoom', true);

    $gallery = get_post_meta($post_id, 'gallery', true);
    $gallery_array = explode(',', $gallery);
    $marker_icon = st()->get_option('st_hotel_icon_map_marker', '');
    ?>
    <div id="st-content-wrapper">        
        <div class="container">
            <div class="st-hotel-content">
            </div>
            <div class="st-hotel-header">
                <div class="left">                    
                    
                    <div class="sub-heading">
					                    <?php
                    global $post;
                    $content = $post->post_content;
                    $count = str_word_count($content);
                    ?>
                    <div class="st-description" data-toggle-section="st-description" <?php if ($count >= 120) {
                        echo 'data-show-all="st-description"
                             data-height="120"';
                    } ?>>
                        <?php the_content(); ?>
                        <?php if ($count >= 120) { ?>
                            <div class="cut-gradient"></div>
                        <?php } ?>
                    </div>

                    </div>
                </div>
                <div class="right">
                    
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12">

            



                    <div class="st-list-rooms relative" data-toggle-section="st-list-rooms">
                        <?php echo st()->load_template('layouts/modern/common/loader'); ?>
                        <div class="fetch">						
                            <?php
                            global $post;
                            $hotel = new STHotel();
                            $query = $hotel->search_room();
														
														
							
							$a = array($query->posts[6],$query->posts[3],$query->posts[8],$query->posts[4],$query->posts[5],$query->posts[2],$query->posts[0],$query->posts[1],$query->posts[7]);
							$query->posts = $a;
							?>
							
							<script>
								console.log(<?= json_encode($query); ?>);
								
							</script>
							<?php
                            while ($query->have_posts()) {
                                $query->the_post();
                                echo st()->load_template('layouts/modern/hotel/loop/room_item');
                            }
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>

                    <?php if (comments_open() and st()->get_option('hotel_review') == 'on') { ?>
                        <div class="st-hr large"></div>
                        <div id="reviews" data-toggle-section="st-reviews">
                            <div class="row">
                                <div class="col-xs-12 col-sm-4">
                                    <div class="review-box has-matchHeight">
                                        <h2 class="heading"><?php echo __('Review score', 'traveler') ?></h2>
                                        <div class="review-box-score">
                                            <?php
                                            $avg = STReview::get_avg_rate();
                                            ?>
                                            <div class="review-score">
                                                <?php echo esc_attr($avg); ?><span class="per-total">/5</span>
                                            </div>
                                            <div class="review-score-text"><?php echo TravelHelper::get_rate_review_text($avg, $count_review); ?></div>
                                            <div class="review-score-base">
                                                <?php echo __('Based on', 'traveler') ?>
                                                <span><?php comments_number(__('0 review', 'traveler'), __('1 review', 'traveler'), __('% reviews', 'traveler')); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="review-box has-matchHeight">
                                        <h2 class="heading"><?php echo __('Traveler rating', 'traveler') ?></h2>
                                        <?php $total = get_comments_number(); ?>
                                        <?php $rate_exe = STReview::count_review_by_rate(null, 5); ?>
                                        <div class="item">
                                            <div class="progress">
                                                <div class="percent green"
                                                     style="width: <?php echo TravelHelper::cal_rate($rate_exe, $total) ?>%;"></div>
                                            </div>
                                            <div class="label">
                                                <?php echo esc_html__('Excellent', 'traveler') ?>
                                                <div class="number"><?php echo esc_html($rate_exe); ?></div>
                                            </div>
                                        </div>
                                        <?php $rate_good = STReview::count_review_by_rate(null, 4); ?>
                                        <div class="item">
                                            <div class="progress">
                                                <div class="percent darkgreen"
                                                     style="width: <?php echo TravelHelper::cal_rate($rate_good, $total) ?>%;"></div>
                                            </div>
                                            <div class="label">
                                                <?php echo __('Very Good', 'traveler') ?>
                                                <div class="number"><?php echo esc_html($rate_good); ?></div>
                                            </div>
                                        </div>
                                        <?php $rate_avg = STReview::count_review_by_rate(null, 3); ?>
                                        <div class="item">
                                            <div class="progress">
                                                <div class="percent yellow"
                                                     style="width: <?php echo TravelHelper::cal_rate($rate_avg, $total) ?>%;"></div>
                                            </div>
                                            <div class="label">
                                                <?php echo __('Average', 'traveler') ?>
                                                <div class="number"><?php echo esc_html($rate_avg); ?></div>
                                            </div>
                                        </div>
                                        <?php $rate_poor = STReview::count_review_by_rate(null, 2); ?>
                                        <div class="item">
                                            <div class="progress">
                                                <div class="percent orange"
                                                     style="width: <?php echo TravelHelper::cal_rate($rate_poor, $total) ?>%;"></div>
                                            </div>
                                            <div class="label">
                                                <?php echo __('Poor', 'traveler') ?>
                                                <div class="number"><?php echo esc_html($rate_poor); ?></div>
                                            </div>
                                        </div>
                                        <?php $rate_terible = STReview::count_review_by_rate(null, 1); ?>
                                        <div class="item">
                                            <div class="progress">
                                                <div class="percent red"
                                                     style="width: <?php echo TravelHelper::cal_rate($rate_terible, $total) ?>%;"></div>
                                            </div>
                                            <div class="label">
                                                <?php echo __('Terrible', 'traveler') ?>
                                                <div class="number"><?php echo esc_html($rate_terible); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="review-box has-matchHeight">
                                        <h2 class="heading"><?php echo __('Summary', 'traveler') ?></h2>
                                        <?php
                                        $stats = STReview::get_review_summary();
                                        if ($stats) {
                                            foreach ($stats as $stat) {
                                                ?>
                                                <div class="item">
                                                    <div class="progress">
                                                        <div class="percent"
                                                             style="width: <?php echo esc_attr($stat['percent']); ?>%;"></div>
                                                    </div>
                                                    <div class="label">
                                                        <?php echo esc_html($stat['name']); ?>
                                                        <div class="number"><?php echo esc_html($stat['summary']) ?>
                                                            /5
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="review-pagination">
                                <div class="summary">
                                    <?php
                                    $comments_count = wp_count_comments(get_the_ID());
                                    $total = (int)$comments_count->approved;
                                    $comment_per_page = (int)get_option('comments_per_page', 10);
                                    $paged = (int)STInput::get('comment_page', 1);
                                    $from = $comment_per_page * ($paged - 1) + 1;
                                    $to = ($paged * $comment_per_page < $total) ? ($paged * $comment_per_page) : $total;
                                    ?>
                                    <?php comments_number(__('0 review on this Hotel', 'traveler'), __('1 review on this Hotel', 'traveler'), __('% reviews on this Hotel', 'traveler')); ?>
                                    - <?php echo sprintf(__('Showing %s to %s', 'traveler'), $from, $to) ?>
                                </div>
                                <div id="reviews" class="review-list">
                                    <?php
                                    $offset = ($paged - 1) * $comment_per_page;
                                    $args = [
                                        'number' => $comment_per_page,
                                        'offset' => $offset,
                                        'post_id' => get_the_ID(),
                                        'status' => ['approve']
                                    ];
                                    $comments_query = new WP_Comment_Query;
                                    $comments = $comments_query->query($args);

                                    if ($comments):
                                        foreach ($comments as $key => $comment):
                                            echo st()->load_template('layouts/modern/common/reviews/review', 'list', ['comment' => (object)$comment]);
                                        endforeach;
                                    endif;
                                    ?>
                                </div>
                            </div>
                            <?php TravelHelper::pagination_comment(['total' => $total]) ?>
                            <?php
                            if (comments_open($post_id)) {
                                ?>
                                <div id="write-review">
                                    <h4 class="heading">
                                        <a href="" class="toggle-section c-main f16"
                                           data-target="st-review-form"><?php echo __('Write a review', 'traveler') ?>
                                            <i class="fa fa-angle-down ml5"></i></a>
                                    </h4>
                                    <?php
                                    TravelHelper::comment_form();
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    <?php } ?>
                    <div class="stoped-scroll-section"></div>
                </div>
            </div>
            <?php 
                global $post;
                $hotel = new STHotel();
                $nearby_posts = $hotel->get_near_by();
                if ($nearby_posts) { ?>
                    <div class="st-hr x-large"></div>
                    <h2 class="st-heading text-center"><?php echo __('Hotel Nearby', 'traveler') ?></h2>
                    <div class="services-grid services-nearby hotel-nearby grid mt50">
                        <div class="row">
                            <?php
                                foreach ($nearby_posts as $key => $post) {
                                    setup_postdata($post);
                                    $hotel_star = (int)get_post_meta(get_the_ID(), 'hotel_star', true);
                                    $price = STHotel::get_price();
                                    $address = get_post_meta(get_the_ID(), 'address', true);
                                    $review_rate = STReview::get_avg_rate();
                                    $is_featured = get_post_meta(get_the_ID(), 'is_featured', true);
                                    ?>
                                    <div class="col-xs-12 col-sm6 col-md-3">
                                        <div class="item">
                                            <div class="featured-image">
                                                <?php
                                                if ($is_featured == 'on') {
                                                    ?>
                                                    <div class="featured"><?php echo __('Featured', 'traveler') ?></div>
                                                <?php } ?>
                                                <a href="<?php the_permalink(); ?>">
                                                    <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>"
                                                         alt="" class="img-responsive img-full">
                                                </a>
                                                <?php echo st()->load_template('layouts/modern/common/star', '', ['star' => $hotel_star]); ?>
                                            </div>
                                            <h4 class="title">
                                                <a href="<?php the_permalink(); ?>" class="st-link c-main">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h4>
                                            <div class="sub-title">
                                                <?php if ($address) {
                                                    echo TravelHelper::getNewIcon('ico_maps_search_box', '', '10px');
                                                    echo esc_html($address);
                                                }
                                                ?>
                                            </div>
                                            <div class="reviews">
                                                        <span class="rate"><?php echo esc_attr($review_rate); ?>/5
                                                            <?php echo TravelHelper::get_rate_review_text($review_rate, $count_review); ?></span><span
                                                        class="summary"><?php comments_number(__('0 review', 'traveler'), __('1 review', 'traveler'), __('% reviews', 'traveler')); ?></span>
                                            </div>
                                            <div class="price-wrapper">
                                                <?php
                                                if(STHotel::is_show_min_price()):
                                                    _e("from", 'traveler');
                                                else:
                                                    _e("avg", 'traveler');
                                                endif;?>
                                                <?php echo wp_kses(sprintf(__(' <span class="price">%s</span><span class="unit">/night</span>', 'traveler'), TravelHelper::format_money($price)), ['span' => ['class' => []]]); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                wp_reset_query();
                                wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                <?php }
            ?>
        </div>
    </div>
	
		<!-- Buchen -->
		<div class="modal fade" id="modalBooking" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Buchen</h4>
			  </div>
			  <div class="modal-body">
				<div id="ebFrontEndFrame" style="width: 810px; min-height:600px;"></div>				
				<script src="//www.easy-booking.at/bookingengine2/js/jquery.easybooking.frontend.js"></script>
				<script>
				  function ebFrontendLoadedCheck() {
					if (typeof jQuery != "undefined") {
					  if (jQuery.fn.ebFrontEnd) {
						jQuery("#ebFrontEndFrame").ebFrontEnd({
						  customerId: 9403,
						  serialNo: "7801-4403-8613",
						  localeId: 2,
						  frameId: "ebFrontEndPlugin",
						  encapsulated: true,
						  adultOnly: false,
						  hideFilters: "on",
						  conversionReservation: "",
						  conversionEnquiry: "",
						  frameWidth: "auto",
						  frameHeight: "auto",
						  resizeInterval: 500,
						});
					  } else {
						setTimeout(ebFrontendLoadedCheck, 200);
					  }
					} else {
					  setTimeout(ebFrontendLoadedCheck, 200);
					}
				  }
				  ebFrontendLoadedCheck();
				</script>
			  </div>
			  <div class="modal-footer">				
			  </div>
			</div>
		  </div>
		</div>
		
		<!-- Verfügbarkeit  -->
		<div class="modal fade" id="modalAvailability" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Verfügbarkeit</h4>
			  </div>
			  <div class="modal-body">
				<div id="ebAvailability" style="width: 810px; min-height:600px;"></div>
				<script type="text/javascript" src="//www.easy-booking.at/ebPlugins/availability/jquery.easybooking.availability.js"></script>
				<script type="text/javascript">
				function ebAvailabilityLoadedCheck() {
					if (typeof jQuery !== "undefined") {
						if (jQuery.fn.ebAvailabilityCalendar) {
							jQuery("#ebAvailability").ebAvailabilityCalendar({
								customerId: 9403,
								serialNo: "7801-4403-8613",
								localeId: 2,
								categories: "all",
								startDate: "default",
								showForm: true
							});
						} else{setTimeout(ebAvailabilityLoadedCheck, 200);}
					} else{setTimeout(ebAvailabilityLoadedCheck, 200);}
				}
				ebAvailabilityLoadedCheck();
				</script>
			  </div>
			  <div class="modal-footer">				
			  </div>
			</div>
		  </div>
		</div>
		
		<!-- Preise -->
		<div class="modal fade" id="modalPrices" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Preise</h4>
			  </div>
			  <div class="modal-body">
				<div id="pricesFrame" style="width: 810px; min-height:600px;"></div>
				<script type="text/javascript" src="//www.easy-booking.at/ebPlugins/prices/jquery.easybooking.pricelist.v2.js"></script>
				<script type="text/javascript">
				jQuery('#modalPrices').on('show.bs.modal', function(e) {
					jQuery("#pricesFrame").html('');
					var catId = jQuery(e.relatedTarget).data('cat-id');
					ebPricesLoadedCheck(catId);					
				});
				function ebPricesLoadedCheck(catId) {
					if(typeof jQuery != "undefined") {
						if(jQuery.fn.ebPricelist) {
							jQuery("#pricesFrame").ebPricelist({
								customerId: 9403,
								serialNo: "7801-4403-8613",
								localeId: 2,
								loadCSS : true,
								arrivalDate : "",
								category : catId,
								showAvailability: false,
								enquiryPage : "popup",
								bookingPage : "popup",
								bookingEngine: 2
							});
						} else{setTimeout(ebPricesLoadedCheck,200);}
					}else{setTimeout(ebPricesLoadedCheck,200);}
				}
				
				</script>

			  </div>
			  <div class="modal-footer">				
			  </div>
			</div>
		  </div>
		</div>
<?php endwhile;
