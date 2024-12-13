<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 16-11-2018
     * Time: 11:29 AM
     * Since: 1.0.0
     * Updated: 1.0.0
     */

    $room_id = get_the_ID();
    $room_id = TravelHelper::post_translated($room_id);
    $item_id = get_post_meta( $room_id, 'room_parent', true );
    if ( empty( $item_id ) ) {
        $item_id = $room_id;
    }
    $get_data = array();
    $get_data['start'] =  STInput::request( 'start' );
    $get_data['end'] =     STInput::request( 'end' );
    $get_data['date'] =     STInput::request( 'date' );
    $get_data['room_num_search'] =     STInput::request( 'room_num_search' );
    $get_data['adult_number'] =     STInput::request( 'adult_number' );
    $get_data['child_number'] =     STInput::request( 'child_number' );
	
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

    $link_with_params = add_query_arg($get_data, get_the_permalink());
?>
<div class="item">
    <form class="form-booking-inpage" method="get">
        <input type="hidden" name="check_in" value="<?php echo STInput::request( 'start' ); ?>"/>
        <input type="hidden" name="check_out" value="<?php echo STInput::request( 'end' ); ?>"/>
        <input type="hidden" name="room_num_search" value="<?php echo STInput::request( 'room_num_search' ); ?>"/>
        <input type="hidden" name="adult_number" value="<?php echo STInput::request( 'adult_number' ); ?>"/>
        <input type="hidden" name="child_number" value="<?php echo STInput::request( 'child_number' ); ?>"/>
        <input name="action" value="hotel_add_to_cart" type="hidden">
        <input name="item_id" value="<?php echo esc_attr($item_id); ?>" type="hidden">
        <input name="room_id" value="<?php echo esc_attr($room_id); ?>" type="hidden">
        <input type="hidden" name="start" value="<?php echo STInput::request( 'start' ); ?>"/>
        <input type="hidden" name="end" value="<?php echo STInput::request( 'end' ); ?>"/>
        <input type="hidden" name="is_search_room" value="<?php echo STInput::request( 'is_search_room' ); ?>">
        <div class="row">
            <div class="col-xs-12 col-md-4">
                <div class="image">
                    <a href="<?php echo esc_url($link_with_params) ?>">
						<img src="<?php echo get_the_post_thumbnail_url(null, [800,600]) ?>" alt="" class="img-responsive img-full img-room">
					</a>
                </div>
            </div>
            <div class="col-xs-12 col-md-8">
                
                <div class="row">
                    <div class="col-xs-12 col-md-8">
						<h2 class="heading"><a href="<?php echo esc_url($link_with_params) ?>" class="st-link"><?php echo get_the_title($room_id); ?></a>
						</h2>
                        <div class="facilities">
						
                            <?php if ( $room_footage = get_post_meta( $room_id, 'room_footage', true ) ): ?>
                                <p class="item" data-toggle="tooltip" data-placement="top" title="<?php echo __('Größe', 'traveler') ?>">
                                    <?php echo TravelHelper::getNewIcon( 'ico_square', '#5E6D77' ) ?><br/>
									<span>Größe: <?php echo esc_attr( $room_footage ); ?>m<sup>2</sup></span>
                                </p>
                            <?php endif; ?>
                            <?php if ( $bed = get_post_meta( $room_id, 'bed_number', true ) ): ?>
                                <p class="item" data-toggle="tooltip" data-placement="top" title="<?php echo __('Betten', 'traveler') ?>">
                                    <?php echo TravelHelper::getNewIcon( 'ico_beds', '#5E6D77' ) ?><br/>
									<span>Betten: <?php echo esc_attr( $bed ); ?></span>									
                                </p>
                            <?php endif; ?>
							<?php if ( $child = (int)get_post_meta( $room_id, 'children_number', true ) ): ?>
                                <p class="item" data-toggle="tooltip" data-placement="top" title="<?php echo __('Ausziehcouch', 'traveler') ?>">
                                    <?php echo TravelHelper::getNewIcon( 'sofa-couch', '#5E6D77' ) ?><br/>
									<span>Ausziehcouch: <?php echo( $child ); ?></span>		
                                </p>
                            <?php endif; ?>
                            <?php if ( $adult = (int)get_post_meta( $room_id, 'adult_number', true ) ): ?>
                                <p class="item" data-toggle="tooltip" data-placement="top" title="<?php echo __('max. Pers.', 'traveler') ?>">
                                    <?php echo TravelHelper::getNewIcon( 'ico_adults', '#5E6D77' ) ?><br/>
									<span>max. Personen: <?php echo( $adult ); ?></span>		
                                </p>
                            <?php endif; ?>

                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4">
						<div class="submit-group apparment-buttons">																												
							<button type="button" class="btn btn-green btn-large btn-full upper" style="margin-top: 10px;" data-toggle="modal" data-target="#modalBooking">Buchen</button>
							<button type="button" class="btn btn-white btn-medium btn-full upper" style="margin-top: 10px;" data-toggle="modal" data-target="#modalAvailability">Verfügbarkeit</button>
							<button type="button" class="btn btn-white btn-medium btn-full upper" style="margin-top: 10px;" data-cat-id="<?php echo $room_external_category[$room_external_id]; ?>" data-toggle="modal" data-target="#modalPrices">Preise</button>
							<!-- Button trigger modal -->														
						</div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
