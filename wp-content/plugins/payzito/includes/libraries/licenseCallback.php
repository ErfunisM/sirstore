<?php

function ioncube_event_handler($err_code,$params)
{
    $errors = [
        ION_CORRUPT_FILE => 'corrupt-file',
        ION_EXPIRED_FILE => 'expired-file',
        ION_NO_PERMISSIONS => 'no-permissions',
        ION_CLOCK_SKEW => 'clock-skew',
        ION_LICENSE_NOT_FOUND => 'license-not-found',
        ION_LICENSE_CORRUPT => 'license-corrupt',
        ION_LICENSE_EXPIRED => 'license-expired',
        ION_LICENSE_PROPERTY_INVALID => 'license-property-invalid',
        ION_LICENSE_HEADER_INVALID => 'license-header-invalid',
        ION_LICENSE_SERVER_INVALID => 'license-server-invalid',
        ION_UNAUTH_INCLUDING_FILE => 'unauth-including-file',
        ION_UNAUTH_INCLUDED_FILE => 'unauth-included-file',
        ION_UNAUTH_APPEND_PREPEND_FILE => 'unauth-append-prepend-file',
    ];

    $msg = 'مشکلی در فایل لایسنس شما وجود دارد. خطای شماره '.$err_code.' ('.($errors[$err_code] ?? '').')';

    echo '#|#[0,"'.$msg.'"]#|#';
}