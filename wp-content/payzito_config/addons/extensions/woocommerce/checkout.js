
jQuery(function(){

    setPayzitoCookie(0);

    jQuery("body").on("click",".pa-payzito-woocommerce-gateways label",function(){
        setPayzitoCookie(jQuery(this).parent().find('[name="payzito_gateway"]').val());
    });
});

function setPayzitoCookie(gateway)
{
    let date = new Date();
    date.setTime(date.getTime() + (10*24*60*60*1000));
    expires = "; expires=" + date.toUTCString();
    document.cookie = "payzito_wc_gateway="+gateway+"; expires="+ date.toUTCString()+"";
}

class wc_payzito_block
{
    constructor(name)
    {
        this.name = name;
        this.register();
    }

    register()
    {
        let payzitoWoocommerceBlockGateway = {
            name: this.name,
            label: this.getLabel(),
            content: Object(window.wp.element.createElement)('div', {
                dangerouslySetInnerHTML: this.createMarkup(this.myHtml()),
            }),
            edit: Object(window.wp.element.createElement)('div', {
                dangerouslySetInnerHTML: this.createMarkup(this.myHtml()),
            }),
            canMakePayment: () => true,
            ariaLabel: this.getLabel(),
            supports: {
                features: this.getSettings().supports,
            },
        };

        window.wc.wcBlocksRegistry.registerPaymentMethod(payzitoWoocommerceBlockGateway);
    }

    getLabel()
    {
        return window.wp.htmlEntities.decodeEntities(this.getSettings().title);
    }

    getSettings()
    {
        return window.wc.wcSettings.getPaymentMethodData(this.name);
    }

    createMarkup(htmlString)
    {
       return { __html: htmlString };
    }

    myHtml()
    {
        return this.getSettings().description;
    }
}

jQuery.each(wcPayzitoGateways,function (i,v){
    new wc_payzito_block(v);
});