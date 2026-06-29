<?php

namespace WeDevs\DokanPro\Modules\StripeExpress\Admin;

use WeDevs\DokanPro\Modules\StripeExpress\Support\Api;
use WeDevs\DokanPro\Modules\StripeExpress\Support\Helper;
use \Exception;

/**
 * Deletes stripe account
 *
 * @since 3.9.4
 */
class StripeDeleteAccount extends Api {

    /**
     * Initializes and calls all hooks
     *
     * @since 3.9.4
     */
    public function __construct() {
        add_filter(
            'dokan_stripe_express_is_vendor_stripe_account_deleted_from_remote',
            [ $this, 'delete_stripe_account' ],
            10,
            2
        );
    }

    /**
     * Checks is the account has been deleted from stripe server
     *
     * @since 3.9.4
     *
     * @param $is_deleted
     * @param $account_id
     *
     * @return bool
     */
    public function delete_stripe_account( $is_deleted, $account_id ) {
        $stripe_object = self::api();
        try {
            $response = $stripe_object->accounts->delete( $account_id, [] );
            if ( ! empty( $response['deleted'] ) && $response['deleted'] ) {
                return true;
            } else {
                Helper::log( sprintf( 'Could not delete account: %1$s. Error: %2$s', $account_id, "Unrecognized Response" ) );
                return $is_deleted;
            }
        } catch ( Exception $e ) {
            Helper::log( sprintf( 'Could not delete account: %1$s. Error: %2$s', $account_id, $e->getMessage() ) );
        }
        return $is_deleted;
    }
}
