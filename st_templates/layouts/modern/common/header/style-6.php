<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12-11-2018
 * Time: 11:47 AM
 * Since: 1.0.0
 * Updated: 1.0.0
 */
?>

<header id="header" class="header-style-4 style6">
    <div class="container">
        <?php
        $enable_topbar = st()->get_option('enable_topbar', 'on');
        if ($enable_topbar == 'on') {
            $hidden_topbar_in_mobile = st()->get_option('hidden_topbar_in_mobile', 'on');
            if ($hidden_topbar_in_mobile == 'off' || ($hidden_topbar_in_mobile == 'on' && !wp_is_mobile())) {
                ?>
                <div id="topbar">
                    <?php
                    $sort_topbar_menu = st()->get_option('sort_topbar_menu', false);
                    if ($sort_topbar_menu) {
                        ?>
                        <div class="topbar-left">
                            <ul class="st-list socials">
                                <li>
                                    <?php
                                    foreach ($sort_topbar_menu as $key => $val) {
                                        $target = '';
                                        if (!empty($val['topbar_custom_link_target']) && $val['topbar_custom_link_target'] == 'on') {
                                            $target = '_blank';
                                        }
                                        $icon = esc_html($val['topbar_custom_link_icon']);
                                        if (!empty($val['topbar_item']) && $val['topbar_position'] == 'left' && isset($val['topbar_is_social']) && $val['topbar_is_social'] == 'on') {
                                            echo '<a href="' . esc_url($val['topbar_custom_link']) . '" target="' . esc_attr($target) . '"><i class="fa ' . esc_attr($icon) . '"></i><span>'. esc_html($val['title']) .'</span></a>';
                                        }

                                    }
                                    ?>
                                </li>
                            </ul>
                            <ul class="st-list topbar-items">
                                <?php
                                foreach ($sort_topbar_menu as $key => $val) {
                                    if (!empty($val['topbar_item']) && $val['topbar_position'] == 'left' && (empty($val['topbar_is_social']) || $val['topbar_is_social'] == 'off')) {
                                        echo '<li class="hidden-xs hidden-sm"><a href="' . esc_url($val['topbar_custom_link']) . '" target="' . esc_attr($target) . '">' . esc_html($val['topbar_custom_link_title']) . '</a></li>';
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="topbar-right">
                        <ul class="st-list socials">
                            <li>
                                <?php
                                foreach ($sort_topbar_menu as $key => $val) {
                                    $target = '';
                                    if (!empty($val['topbar_custom_link_target']) && $val['topbar_custom_link_target'] == 'on') {
                                        $target = '_blank';
                                    }
                                    $icon = esc_html($val['topbar_custom_link_icon']);
                                    if (!empty($val['topbar_item']) && $val['topbar_position'] == 'right' && isset($val['topbar_is_social']) && $val['topbar_is_social'] == 'on') {
                                        echo '<a href="' . esc_url($val['topbar_custom_link']) . '" target="' . esc_attr($target) . '"><i class="fa ' . esc_attr($icon) . '"></i></a>';

                                    }


                                }
                                ?>
                            </li>
                        </ul>
                        <ul class="st-list topbar-items">
                            <?php
                            foreach ($sort_topbar_menu as $key => $val) {
                                if (!empty($val['topbar_item']) && $val['topbar_position'] == 'right' && ( empty($val['topbar_is_social']) || $val['topbar_is_social'] == 'off' )) {
                                    if ($val['topbar_item'] == 'login') {
                                        echo st()->load_template('layouts/modern/common/header/topbar-items/login', '');
                                    }
                                    if ($val['topbar_item'] == 'currency') {
                                        echo st()->load_template('layouts/modern/common/header/topbar-items/currency', '');
                                    }
                                    if ($val['topbar_item'] == 'language') {
                                        echo st()->load_template('layouts/modern/common/header/topbar-items/language', '');
                                    }
                                    if ($val['topbar_item'] == 'link') {
                                        $topbar_custom_class = isset($val['topbar_custom_class']) ? $val['topbar_custom_class'] : ''; ?>
                                        <li class="topbar-item link-item <?php echo esc_attr($topbar_custom_class); ?>">
                                            <a href="<?php echo esc_url($val['topbar_custom_link']); ?>"
                                               class="login"><?php echo esc_html($val['topbar_custom_link_title']); ?></a>
                                        </li>
                                    <?php }
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <?php
            }
        }
        ?>        
		<div class="header" id="main-menu-container">
		<a href="#" class="toggle-menu">
			<?php
			$menu_style = st()->get_option('menu_style_modern', "");
			if ($menu_style == '2') {
				echo TravelHelper::getNewIcon('Ico_off_menu', '#fff', '', '', true);
			} else {
				echo TravelHelper::getNewIcon('Ico_off_menu');
			}
			?>
		</a>
		<div class="header-left">
			<?php
			$logo_url = st()->get_option('logo_new');
			$logo_mobile_url = st()->get_option('logo_mobile', $logo_url);
			if (empty($logo_mobile_url))
				$logo_mobile_url = $logo_url;
			?>
			<a href="<?php echo home_url('/') ?>" class="logo hidden-xs">
				<img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo get_bloginfo('description'); ?>">
			</a>
			<a href="<?php echo home_url('/') ?>" class="logo hidden-lg hidden-md hidden-sm">
				<img src="<?php echo esc_url($logo_mobile_url); ?>"
					 alt="<?php echo get_bloginfo('description'); ?>">
			</a>
		</div>
		<div id="booking-menu-button">				
			<a href="<?php echo home_url('/') ?>/buchen/" class="btn btn-green">Buchen</a>
		</div>
		<div class="header-right">
			<nav id="st-main-menu">
				<a href="" class="back-menu"><i class="fa fa-angle-left"></i></a>
				<?php
				if (has_nav_menu('primary')) {
					$mega_menu = st()->get_option('allow_megamenu', 'off');
					if ($mega_menu == 'on') {
						wp_nav_menu(array(
							'theme_location' => 'primary',
							"container" => "",
							'items_wrap' => '<ul id="main-menu" class="%2$s main-menu">%3$s</ul>',
							'depth' => 10,
							'walker' => new ST_Mega_Menu_Walker_New(),
						));
						?>
						<?php
					} else {
						wp_nav_menu([
							'theme_location' => 'primary',
							"container" => "",
							'items_wrap' => '<ul id="main-menu" class="%2$s main-menu">%3$s</ul>',
							'walker' => new st_menu_walker_new(),
						]);
						?>
						<?php if(!is_user_logged_in()){ ?>
							<div class="advance-menu">
								<a  href="" class="login" data-toggle="modal" data-target="#st-login-form"><?php echo esc_html__('Login','traveler') ?></a>

								<a href="" class="signup" data-toggle="modal" data-target="#st-register-form"><?php echo esc_html__('Sign Up','traveler') ?></a>
							</div>
						<?php } ?>
						<?php
					}
				}
				?>
			</nav>
			<?php
			$sort_header_menu = st()->get_option('sort_header_menu', '');
			if (!empty($sort_header_menu) and is_array($sort_header_menu)) {
				?>
				<ul class="st-list">
					<?php
					foreach ($sort_header_menu as $key => $val) {
						if (!empty($val['header_item'])) {
							if ($val['header_item'] == 'login') {
								echo st()->load_template('layouts/modern/common/header/topbar-items/login', '', array('in_header' => true));
							}
							if ($val['header_item'] == 'currency') {
								echo st()->load_template('layouts/modern/common/header/topbar-items/currency', '');
							}
							if ($val['header_item'] == 'language') {
								echo st()->load_template('layouts/modern/common/header/topbar-items/language', '');
							}
							if ($val['header_item'] == 'link') {
								$icon = '';
								if (!empty($val['header_custom_link_icon'])) {
									$icon = esc_html($val['header_custom_link_icon']);
								}
								echo '<li class="st-header-link"><a href="' . esc_url($val['header_custom_link']) . '"> <i class="fa ' . esc_attr($icon) . ' mr5"></i>' . esc_html($val['header_custom_link_title']) . '</a></li>';
							}
							if ($val['header_item'] == 'shopping_cart') {
								echo st()->load_template('layouts/modern/common/header/topbar-items/cart', '');
							}
							if ($val['header_item'] == 'search') {
								$search_header_onoff = st()->get_option('search_header_onoff', 'on');
								if ($search_header_onoff == 'on'):
									echo st()->load_template('layouts/modern/common/header/topbar-items/search', '');
								endif;
							}
						}
					}
					?>

				</ul>
				<?php
			}
			?>
		</div>
	</div>    		
	<?php if ( is_front_page() ) { ?>    
		<div class="booking">		
			<link rel="stylesheet" href="https://easy-booking.at/plugins/global/_css/ebGlobal.css" type="text/css" media="screen" />
			<link rel="stylesheet" type="text/css" media="screen" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/base/jquery-ui.css" />
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/i18n/jquery-ui-i18n.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.4/jquery.fancybox.pack.js"></script>
			<script src="https://easy-booking.at/plugins/smallsearch/ebSmallsearch.js"></script>
			<style>
			
			.booking {				
				height: calc(100vh - 142px);
			}
			#ui-datepicker-div {
				font-size: 12px
			}
			@media(max-width:768px){
				  .eb_smallsearch{
					display:none;
				  }
				}

			@media(max-height:500px){
			  .eb_smallsearch{
				display:none;
			  }
			}
			.eb_smallsearch {				
				z-index: 1;
				bottom: 40px;
				margin: auto;
				position: absolute;
				left: 0;
				right: 0;
			}

			.eb_smallsearch_child {    
				background-color: #337AB7;            
				height: 101px;
				width: 900px;
				margin-right: auto;
				margin-left: auto;
			}

			.eb_smallsearch_child_child {
			  margin: 0px auto;
			  width: 630px;
			  padding: 29px 0px;
			}
			.heading {
				font-size: 25px;
				color: #FFF;
				float: left;
				padding-right: 25px;
			}

			.eb_smallsearch select {
				background-color: #FFF;
				border: 1px solid #CCC;
				height: 30px;
				padding: 7px 6px;
				width: 60px;
				float: right
			}

			.eb_smallsearch h3 {
				color: #FFF;	
			}

			.eb_smallsearch .arrival input,
			.eb_smallsearch .departure input {
				color: #666;
				font-size: 15px;
				height: 36px;
				line-height: 23px;
				padding-left: 5px;
				width: 92%;
				border: 1px solid #CCC
			}

			.eb_smallsearch .datepicker {
				background: url(//www.easy-booking.at/ebPlugins/smallSearch/img/cal.gif) no-repeat scroll right 5px top 8px #FFF;
				border: 0 none
			}

			.eb_smallsearch .adults .label,
			.eb_smallsearch .children .label {
				color: #666;
				line-height: 30px;
				padding-right: 10px
			}

			.eb_smallsearch .adults,
			.eb_smallsearch .children {
				margin: 5px 20px 0 0
			}

			.eb_smallsearch form div.search .sendButton {
				background: none repeat scroll 0 0 #FFF;
				border: 0 none;
				border-radius: 0 0 0 0;
				color: #005f6a;
				cursor: pointer;
				float: left;
				font-size: 1em;    
				padding: 7px 19px;
				margin-right: 6px;
				font-size: 15px;
				font-weight: 500;
			}
			}

			.eb_smallsearch h3 {
				float: left
			}

			.eb_smallsearch .arrival,
			.eb_smallsearch .departure {
				min-width: 150px;
				float: left
			}

			.eb_smallsearch .adults,
			.eb_smallsearch .children {
				min-width: 150px;
				float: left
			}
			
			.eb_smallsearch_changed{
				bottom: -31px;
			}

			</style>
			<script>jQuery(function($){ $.datepicker.setDefaults($.datepicker.regional['de']);}); </script>
      <div class="eb_smallsearch"> 
			  <div class="eb_smallsearch_child">
				<div class="eb_smallsearch_child_child">
				<div class="heading">BUCHEN</div>
				<form name='request' id="myform" action="https://www.easy-booking.at/bookingengine2/#/2/" method="get" target="_top"> <input name="cid" type="hidden" id="cid" value="9403" /> <input name="lid" type="hidden" id="lid" value="2" /> <input name="stepOne" value="on" type="hidden" /> 
				  <div class="arrival"> <input name="arrivalDate" id="arrivalDate" placeholder="Anreise" class="datepicker">  </div> 
				  <div class="departure"> <input name="departureDate" id="departureDate" placeholder="Abreise" class="datepicker"> </div> 
				  <div class="search"> <input class="sendButton" type="submit" value="weiter" name="imageField" id="SearchButton" alt="weiter"> </div> 
				</form>
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
		</div>
		
		
		
		</div>
		<?php }	?>	
	</div>
</header>
<script>
jQuery("document").ready(function($){
    var nav = jQuery('#main-menu-container');
	var booking = jQuery('.eb_smallsearch');

   jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > 71) {
            nav.addClass("f-nav");
			booking.addClass("eb_smallsearch_changed");
        } else {
            nav.removeClass("f-nav");
			booking.removeClass("eb_smallsearch_changed");
        }
    });
});
</script>