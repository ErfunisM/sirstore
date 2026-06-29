<?php
if(negarshop_option('checkout_steps') !== 'true'){return;}
?>
<div class="row justify-content-center cart-header-steps">
    <div class="col-auto <?= is_cart() ? 'active-step' : '' ?>">
		<?php if ( !is_order_received_page()){ ?><a href="<?= wc_get_cart_url() ?>"><?php } ?>
            <div class="step-item">
                <span class="icon"><i class="far fa-shopping-cart"></i></span>
                <span class="title">سبد خرید
            <span>مرحله اول</span>
            </span>
            </div>
			<?php if ( !is_order_received_page()){ ?></a><?php } ?>
    </div>
    <div class="col-auto <?= !is_order_received_page() && !is_checkout_pay_page() && is_checkout() ? 'active-step' : '' ?>">
		<?php if ( !is_order_received_page()){ ?><a href="<?= wc_get_checkout_url() ?>"><?php } ?>
            <div class="step-item">
                <span class="icon"><i class="far fa-user-edit"></i></span>
                <span class="title">صورتحساب
            <span>مرحله دوم</span>
            </span>
            </div>
			<?php if ( !is_order_received_page()){ ?></a><?php } ?>
    </div>
    <div class="col-auto <?= is_checkout_pay_page() ? 'active-step' : '' ?>">
        <div class="step-item">
            <span class="icon"><i class="far fa-credit-card"></i></span>
            <span class="title">پرداخت
            <span>مرحله سوم</span>
            </span>
        </div>
    </div>
    <div class="col-auto <?= is_order_received_page() ? 'active-step' : '' ?>">
        <div class="step-item">
            <span class="icon"><i class="far fa-list-ul"></i></span>
            <span class="title">فاکتور خرید
            <span>تمام ;)</span>
            </span>
        </div>
    </div>
</div>