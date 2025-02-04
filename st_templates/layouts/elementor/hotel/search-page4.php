<?php
get_header();
wp_enqueue_script( 'filter-hotel' );
?>
	<div id="st-content-wrapper" class="search-result-page layout2">
		<?php
		echo st()->load_template( 'layouts/elementor/hotel/elements/banner' );

		$zoom_map = get_post_meta( get_the_ID(), 'rs_map_room', true );
		if ( empty( $zoom_map ) ) {
			$zoom_map = 13;
		}
		$check_enable_map_google = st()->get_option( 'st_googlemap_enabled' );
		if ( $check_enable_map_google === 'on' ) {
			$height_map = '500px';
		} else {
			$height_map = '650px';
		}
		?>

		<div class="full-map style-full-width">
			<?php echo st()->load_template( 'layouts/elementor/common/loader', 'map' ); ?>
			<div class="full-map-item">
				<div class="title-map-mobile d-block d-sm-none d-md-none"><?php echo __( 'MAP', 'traveler' ); ?> <span class="close-map"><?php echo TravelHelper::getNewIcon( 'Ico_close', '#A0A9B2', '20px', '20px' ); ?></span></div>
				<div id="map-search-form" style="width: 100%; height: <?php echo esc_attr( $height_map ); ?>" class="full-map-form" data-disablecontrol="true" data-showcustomcontrol="true" data-zoom="<?php echo esc_attr( $zoom_map ); ?>" data-popup-position="right"></div>
			</div>
			<div class="search-form-wrapper">
				<div class="container">
					<div class="row">
						<?php echo st()->load_template( 'layouts/elementor/hotel/elements/search-form' ); ?>
					</div>

				</div>
			</div>


		</div>
		<div class="st-results st-hotel-result">
			<div class="container">
				<?php
				echo st()->load_template( 'layouts/elementor/hotel/elements/top-filter/top-filter4' );
				$query = [
					'post_type'   => 'st_hotel',
					'post_status' => 'publish',
					's'           => '',
					'orderby'     => 'post_modified',
					'order'       => 'DESC',
				];
				global $wp_query , $st_search_query;

				$current_lang = TravelHelper::current_lang();
				$main_lang    = TravelHelper::primary_lang();
				if ( TravelHelper::is_wpml() ) {
					global $sitepress;
					$sitepress->switch_lang( $main_lang, true );
				}

				$hotel = STHotel::inst();
				$hotel->alter_search_query();
				query_posts( $query );
				$st_search_query = $wp_query;
				$hotel->remove_alter_search_query();
				wp_reset_query();

				if ( TravelHelper::is_wpml() ) {
					global $sitepress;
					$sitepress->switch_lang( $current_lang, true );
				}

				echo st()->load_template( 'layouts/elementor/hotel/elements/content4' );
				?>
			</div>
		</div>
		<input id="st-layout-fullwidth" value="1" type="hidden"/>
	</div>
<?php
echo st()->load_template( 'layouts/elementor/hotel/elements/popup/date' );
echo st()->load_template( 'layouts/elementor/hotel/elements/popup/guest' );
get_footer();
