<?php
/**
 * Developer : MahdiY
 * Web Site  : MahdiY.IR
 * E-Mail    : M@hdiY.IR
 */

defined( 'ABSPATH' ) || exit;

if ( class_exists( 'Tapin_Pishtaz_Method' ) ) {
	return;
} // Stop if the class already exists

/**
 * Class WC_Tapin_Method
 *
 * @author mahdiy
 *
 */
class Tapin_Pishtaz_Method extends PWS_Tapin_Method {

	public function __construct( $instance_id = 0 ) {

		$this->id                 = 'Tapin_Pishtaz_Method';
		$this->instance_id        = absint( $instance_id );
		$this->method_title       = 'پست پیشتاز - تاپین';
		$this->method_description = 'ارسال کالا با استفاده از پست پیشتاز - تاپین';

		parent::__construct();
	}

	public static function calculate_rates( array $args ): int {

		$weight = $args['weight'];

		$state_center = [
			381,
			561,
			571,
			81,
			61,
			6931,
			941,
			791,
			751,
			971,
			51,
			1,
			681,
			41,
			981,
			451,
			481,
			351,
			661,
			881,
			71,
			341,
			371,
			31,
			761,
			671,
			491,
			91,
			651,
			7591,
			891,
			1011,
			1013,
			1014,
			1015,
			1016,
			1017,
			1018,
			1019,
		];

		$gateway = $args['gateway'] ?? 'tapin';

		if ( $gateway == 'tapin' ) {

			if ( $args['from_province'] == $args['to_province'] ) {
				$cost   = 148400;
				$per_kg = 45000;
			} else {
				$cost   = 223727;
				$per_kg = 47000;
			}

			// calculate
			if ( $weight > 1000 ) {
				$cost += $per_kg * ceil( ( $weight - 1000 ) / 1000 );
			}

		} else {

			$in_city    = 110010;
			$in_center  = 166110;
			$in_country = 166110;

			if ( $args['from_province'] == $args['to_province'] ) {
				$cost = $in_city;
			} elseif ( in_array( $args['from_city'], $state_center ) && in_array( $args['to_city'], $state_center ) ) {
				$cost = $in_center;
			} else {
				$cost = $in_country;
			}

			// calculate
			if ( $weight > 1000 ) {
				$cost += 34850 * ceil( ( $weight - 1000 ) / 1000 );
			}

		}

		if ( $args['content_type'] != 1 || $weight >= 2500 ) {
			$cost *= 1.25;
		}

		if ( in_array( $args['to_city'], [ 1, 91, 61, 51, 71, 81, 31 ] ) ) {
			$cost *= 1.1;
		}

		// INSURANCE
		if ( $args['price'] >= 20000000 ) {
			$cost += $args['price'] * 0.002;
		} else {
			$cost += 20000;
		}

		// COD
		if ( $args['is_cod'] ) {
			$cost += $args['price'] * 0.01;
		}

		// TAX
		$cost += $cost * 0.09;

		return intval( $cost );
	}
}
