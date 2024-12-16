<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 20-11-2018
     * Time: 8:08 AM
     * Since: 1.0.0
     * Updated: 1.0.0
     */
    while ( have_posts() ): the_post();
        $room_id   = get_the_ID();
        $hotel_id  = get_post_meta( get_the_ID(), 'room_parent', true );
        $thumbnail = get_the_post_thumbnail_url( $room_id, 'full' );

        $adult_number = STInput::request( 'adult_number', 1 );
        $child_number = STInput::request( 'child_number', '' );

        
        $room_num_search = (int)STInput::get( 'room_num_search', 1 );
        if ( $room_num_search <= 0 ) $room_num_search = 1;
        
        $price_by_per_person = get_post_meta( $room_id, 'price_by_per_person', true );
        $total_price = STPrice::getRoomPriceOnlyCustomPrice( $room_id, strtotime( $start ), strtotime( $end ), $room_num_search, $adult_number, $child_number );
        $sale_price  = STPrice::getRoomPrice( $room_id, strtotime( $start ), strtotime( $end ), $room_num_search, $adult_number, $child_number );

        $review_rate = STReview::get_avg_rate();

        $gallery       = get_post_meta( $room_id, 'gallery', true );
        $gallery_array = explode( ',', $gallery );

        $room_external = get_post_meta(get_the_ID(), 'st_room_external_booking', true);
		
		$room_external_id = get_post_meta(get_the_ID(), 'st_room_external_booking_link', true);
		$room_external_category = array(
									"2" => "11",
									"3" => "12",
									"4" => "13",
									"5" => "14",
									"6" => "15",
									"7" => "16",
									"8" => "17",									
									"9" => "18",
									"10" => "19"
								);
        $room_external_link = "//www.easy-booking.at/bookingengine2/#9403/2/room/" . $room_external_id;

        $booking_type = st_get_booking_option_type();        
        $total_person = intval( $adult_number ) + intval( $child_number );
        ?>
        <div id="st-content-wrapper">
            <?php st_breadcrumbs_new() ?>
            <div class="st-featured-background"
                 style="background-image: url('<?php echo esc_url( $thumbnail ) ?>')"></div>
            <div class="st-hotel-room-content">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-md-9">
                            <div class="room-heading">
                                <div class="left">
                                    <h2 class="st-heading"><?php the_title(); ?></h2>
                                    <div class="sub-heading mt10">
                                    </div>
                                </div>
                                <div class="right">
                                    
                                </div>
                            </div>
                            <div class="st-hr large"></div>
                            <div class="room-featured-items">
                                <div class="row">
                                    <div class="col-xs-6 col-md-3">
                                        <div class="item has-matchHeight">
                                            <?php echo TravelHelper::getNewIcon( 'ico_square', '#5E6D77', '32px' ); ?>
                                            <?php echo sprintf( __( 'Gr&ouml;&szlig;e: %s', 'traveler' ), get_post_meta( $room_id, 'room_footage', true ) ) ?><?php echo __('m','traveler')?><sup>2</sup>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-3">
                                        <div class="item has-matchHeight">
                                            <?php echo TravelHelper::getNewIcon( 'ico_beds', '#5E6D77', '32px' ); ?>
                                            <?php echo sprintf( __( 'Betten: %s', 'traveler' ), get_post_meta( $room_id, 'bed_number', true ) ) ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-3">
                                        <div class="item has-matchHeight">
                                            <?php echo TravelHelper::getNewIcon( 'sofa-couch', '#5E6D77', '32px' ); ?>
                                            <?php echo sprintf( __( 'Ausziehcouch: %s', 'traveler' ), get_post_meta( $room_id, 'children_number', true ) ) ?>
                                        </div>
                                    </div>
									<div class="col-xs-6 col-md-3">
                                        <div class="item has-matchHeight">
                                            <?php echo TravelHelper::getNewIcon( 'ico_adults', '#5E6D77', '32px'  ); ?>
                                            <?php echo sprintf( __( 'max. Personen: %s', 'traveler' ), get_post_meta( $room_id, 'adult_number', true ) ) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                                if ( !empty( $gallery_array ) ) { ?>
                                    <div class="st-gallery mt20" data-width="100%"
                                         data-nav="false" data-allowfullscreen="true">
                                        <div class="fotorama" data-auto="false">
                                            <?php
                                                foreach ( $gallery_array as $value ) {
                                                    ?>
                                                    <img src="<?php echo wp_get_attachment_image_url( $value, array(870, 555) ) ?>">
                                                    <?php
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            ?>                            
                          
                            <?php
                            $all_attribute = TravelHelper::st_get_attribute_advance( 'hotel_room');
                            foreach ($all_attribute as $key_attr => $attr) {
                                if(!empty($attr["value"])){
                                    $get_label_tax = get_taxonomy($attr["value"]);
                                    $facilities = get_the_terms( get_the_ID(), $attr["value"]);
                                    ?>
                                    <?php if($attr["value"] != 'room_type'){
                                        if(!empty($get_label_tax) && !empty($facilities)  ){
                                                echo '<h2 class="st-heading-section">Ausstattung</h2>';
                                            }
                                        ?>
                                        <?php
                                            if ( $facilities ) {
                                                $count = count( $facilities );
                                                ?>
                                                <div class="facilities" data-toggle-section="st-<?php echo esc_attr($attr["value"]);?>"
                                                    <?php if ( $count > 6 ) echo 'data-show-all="st-'. esc_attr($attr["value"]) .'"
                                                data-height="150"'; ?>
                                                    >
                                                    <div class="row">
                                                        <?php
                                                        foreach ( $facilities as $term ) {
                                                            $icon     = TravelHelper::handle_icon( get_tax_meta( $term->term_id, 'st_icon', true ) );
                                                            $icon_new = TravelHelper::handle_icon( get_tax_meta( $term->term_id, 'st_icon_new', true ) );
                                                            if ( !$icon ) $icon = "fa fa-cogs";
                                                            ?>
                                                            <div class="col-xs-6 col-sm-4">
                                                                <div class="item has-matchHeight">
                                                                    <?php
                                                                        if ( !$icon_new ) {
                                                                            echo '<i class="' . esc_attr($icon) . '"></i>' . esc_html($term->name);
                                                                        } else {
                                                                            echo TravelHelper::getNewIcon( $icon_new, '#5E6D77', '24px', '24px' ) . esc_html($term->name);
                                                                        }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                                <?php if ( $count > 6 ) { ?>
                                                    <a href="#" class="st-link block" data-show-target="st-<?php echo esc_attr($attr["value"]);?>"
                                                    data-text-less="<?php echo esc_html__( 'Show Less', 'traveler' ) ?>"
                                                    data-text-more="<?php echo esc_html__( 'Show All', 'traveler' ) ?>"><span
                                                                class="text"><?php echo esc_html__( 'Show All', 'traveler' ) ?></span>
                                                        <i
                                                                class="fa fa-caret-down ml3"></i></a>
                                                    <?php
                                                }
                                            }
                                        if ( $facilities ) {
                                        ?>
                                            <div class="st-hr large"></div>
                                        <?php }
                                    }
                                }

                            }
                            ?>
							  <?php
                                global $post;
                                $content = $post->post_content;
                                $count   = str_word_count( $content );
                            ?>
                            <div class="st-description" data-toggle-section="st-description">
                                <?php the_content(); ?>                                
                            </div>                           
                            <div class="st-hr large"></div>
                            <?php if(comments_open() and st()->get_option( 'room_review' ) == 'on') {?>
                                <div class="st-hr large"></div>
                                <div class="st-flex space-between">
                                    <h2 class="st-heading-section"><?php echo esc_html__( 'Review', 'traveler' ); ?></h2>
                                    <div class="f18 font-medium15">
                                        <span class="mr15"><?php comments_number( __( '0 review', 'traveler' ), __( '1 review', 'traveler' ), __( '% reviews', 'traveler' ) ); ?></span>
                                        <?php echo st()->load_template( 'layouts/modern/common/star', '', [ 'star' => $review_rate, 'style' => 'style-2', 'element' => 'span' ] ); ?>
                                    </div>
                                </div>
                                <div id="reviews" class="hotel-room-review">
                                    <div class="review-pagination">
                                        <div id="reviews" class="review-list">
                                            <?php
                                                $comments_count   = wp_count_comments( get_the_ID() );
                                                $total            = (int)$comments_count->approved;
                                                $comment_per_page = (int)get_option( 'comments_per_page', 10 );
                                                $paged            = (int)STInput::get( 'comment_page', 1 );
                                                $from             = $comment_per_page * ( $paged - 1 ) + 1;
                                                $to               = ( $paged * $comment_per_page < $total ) ? ( $paged * $comment_per_page ) : $total;
                                            ?>
                                            <?php
                                                $offset         = ( $paged - 1 ) * $comment_per_page;
                                                $args           = [
                                                    'number'  => $comment_per_page,
                                                    'offset'  => $offset,
                                                    'post_id' => get_the_ID(),
                                                    'status' => ['approve']
                                                ];
                                                $comments_query = new WP_Comment_Query;
                                                $comments       = $comments_query->query( $args );

                                                if ( $comments ):
                                                    foreach ( $comments as $key => $comment ):
                                                        echo st()->load_template( 'layouts/modern/common/reviews/review', 'list', [ 'comment' => (object)$comment ] );
                                                    endforeach;
                                                endif;
                                            ?>
                                        </div>
                                    </div>
                                    <?php TravelHelper::pagination_comment( [ 'total' => $total ] ) ?>
                                    <?php
                                        if ( comments_open( $room_id ) ) {
                                            ?>
                                            <div id="write-review">
                                                <h4 class="heading">
                                                    <a href="" class="toggle-section c-main f16" data-target="st-review-form"><?php echo __( 'Write a review', 'traveler' ) ?><i class="fa fa-angle-down ml5"></i></a>
                                                </h4>
                                                <?php
                                                    TravelHelper::comment_form();
                                                ?>
                                            </div>
                                            <?php
                                        }
                                    ?>
                                </div>
                            <?php }?>
                            <div class="stoped-scroll-section"></div>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <div class="widgets">
                                <div class="fixed-on-mobile" data-screen="992px">
                                    <div class="close-icon hide">
                                        <?php echo TravelHelper::getNewIcon( 'Ico_close' ); ?>
                                    </div>
                                   
                                            <div class="form-book-wrapper">
                                                <?php echo st()->load_template( 'layouts/modern/common/loader' ); ?>
                                                <div class="form-head">
													Noch wenige Klicks zur Erholung ...
                                                </div>
												<div class="submit-group mb30">																												
														<button type="button" class="btn btn-green btn-large btn-full upper" style="margin-top: 10px;" data-toggle="modal" data-target="#modalBooking">Buchen</button>
														<button type="button" class="btn btn-white btn-large btn-full upper" style="margin-top: 10px;" data-toggle="modal" data-target="#modalAvailability">Verfügbarkeit</button>
														<button type="button" class="btn btn-white btn-large btn-full upper" style="margin-top: 10px;" data-toggle="modal" data-target="#modalPrices">Preise</button>															
														<!-- Button trigger modal -->														
												</div>
                                            </div>


                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
				function ebPricesLoadedCheck() {
					if(typeof jQuery != "undefined") {
						if(jQuery.fn.ebPricelist) {
							jQuery("#pricesFrame").ebPricelist({
								customerId: 9403,
								serialNo: "7801-4403-8613",
								localeId: 2,
								loadCSS : true,
								arrivalDate : "",
								category : "<?php echo $room_external_category[$room_external_id]; ?>",
								showAvailability: false,
								enquiryPage : "popup",
								bookingPage : "popup",
								bookingEngine: 2
							});
						} else{setTimeout(ebPricesLoadedCheck,200);}
					}else{setTimeout(ebPricesLoadedCheck,200);}
				}
				ebPricesLoadedCheck();
				</script>

			  </div>
			  <div class="modal-footer">				
			  </div>
			</div>
		  </div>
		</div>
		
    <?php
    endwhile;
