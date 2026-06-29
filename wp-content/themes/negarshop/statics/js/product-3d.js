(function ($) {
    "use strict";
    var dir_url = negarshop_obj.assets_url;
    var loaded = false;
    var fullloaded = false;
    $(document).on("click", "a.action-btn-3d-view" , function () {
        if(!fullloaded) {
            var thisItem = $(this);
            if(!loaded) {
                $.getScript(dir_url + "three.js", function () {
                    loaded = true;
                    getModelAjax(thisItem, negarshop_obj.ajax_url);
                });
            }else{
                getModelAjax(thisItem, negarshop_obj.ajax_url);
            }
        }
    });
    var ajaxloaded = false;
    function getModelAjax(item,ajax_url) {
        if(!ajaxloaded) {
            ajaxloaded= true;
            jQuery.post(ajax_url, {
                'action': 'negarshop_3dview_ajax',
                'id': item.attr('data-id'),
            }, function (response) {
                if (response.status) {
                    jQuery('#modal-3d-view-inner .obj_content').html('<div id="canvas-container-3d"></div><div id="view-3d-controller">\n' +
                        '                    <button class="play-toggle"><i class="fas fa-pause"></i></button>\n' +
                        '                    <button class="btn-fullscreen"><i class="far fa-window-maximize"></i></button>\n' +
                        '                    <button class="popup-close" data-dismiss="modal"><i class="fas fa-times"></i></button>\n' +
                        '                </div>');
                    initModFile( response.data.m,response.data.t,response.data.c);
                    fullloaded = true;
                }
            });
        }
    }
    $(document).on("click","#view-3d-controller .btn-fullscreen",function() {
        var e = document.getElementById("canvas-container-3d");
        document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement || document.msFullscreenElement ? (document.exitFullscreen ? document.exitFullscreen() : document.msExitFullscreen ? document.msExitFullscreen() : document.mozCancelFullScreen ? document.mozCancelFullScreen() : document.webkitExitFullscreen && document.webkitExitFullscreen(), $(".full_screen_ic").removeClass("normal")) : (e.requestFullscreen ? e.requestFullscreen() : e.msRequestFullscreen ? e.msRequestFullscreen() : e.mozRequestFullScreen ? e.mozRequestFullScreen() : e.webkitRequestFullscreen && e.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT), $("#view-3d-controller .btn-fullscreen").addClass("normal"))
    });
})(jQuery);

function initModFile(m,t,c) {
    V3Dviewer(m,t,c);
    try {
        THREE.TextureLoader.prototype = {
            constructor: THREE.TextureLoader,
            load: function (url, onLoad, onProgress, onError) {
                var texture = new THREE.Texture();
                var loader = new THREE.ImageLoader(this.manager);
                loader.setCrossOrigin('*');
                loader.load(url, function (image) {
                    texture.image = image;
                    texture.needsUpdate = true;
                    if (onLoad !== undefined) {
                        onLoad(texture);
                    }
                }, onProgress, onError);
                return texture;
            },
            setCrossOrigin: function (value) {
                this.crossOrigin = value;
            }
        };
        create3d();
    } catch (e) {
        console.log("F", e);
    }
}
