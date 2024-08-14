/**
 * Ajax install the Theme Core Plugin
 *
 */
(function($, window, document, undefined){
    "use strict";

    $(function(){

        $('.auxin-install-now').on( 'click', function( event ) {
            var $button = $( event.target );
            event.preventDefault();

            if ( $button.hasClass( 'updating-message' ) || $button.hasClass( 'button-disabled' ) ) {
                return;
            }

            /**
             * Install a plugin
             *
             * @return void
             */
            function installPlugin($data) {
                // todo: modify these lines to just install auxin-pro-tools after approving auxin-elements
                if ( $data['data-plugin-slug'] == 'auxin-pro-tools' || $data['data-plugin-slug'] == 'auxin-elements' ) {
                    var _ajaxData = {
                        action: "aux_setup_plugins",
                        wpnonce: $data['data-wpnonce'],
                        slug: '',
                        plugins: []
                    };

                    if ($data['data-plugin-slug'] == 'auxin-pro-tools') {
                        _ajaxData.slug = 'auxin-pro-tools';
                        _ajaxData.plugins = ['auxin-pro-tools'];
                    } else {
                        _ajaxData.slug = 'auxin-elements';
                        _ajaxData.plugins = ['auxin-elements'];
                    }
                    globalAjax(
                        auxin.ajaxurl,
                        'POST',
                        _ajaxData,
                        function () { // beforeSend callback
                            buttonStatusInProgress( $data['data-installing-label']  );
                        },
                        function ( response ){ // success callback
                            if ( response.success ) {
                                globalAjax(
                                    response.data.url,
                                    'POST',
                                    response.data,
                                    function(){}, // beforeSendCallback
                                    function(){ // success callback
                                        buttonStatusInstalled( auxin.l10n.pluginInstalled );
                                        activatePlugin($data);
                                    },
                                    function(){} // error callback
                                );
                            }
                        },
                        function () { // error callback
                            buttonStatusDisabled( auxin.l10n.installFailedShort );
                            return false;
                        }
                    );
                } else {
                    globalAjax(
                        $data['data-install-url'],
                        'GET',
                        {},
                        function(){ // beforeSend callback
                           buttonStatusInProgress( $data['data-installing-label']  );
                        },
                        function(){ // success callback
                            buttonStatusInstalled( auxin.l10n.pluginInstalled );
                            activatePlugin($data);
                        },
                        function() { // error callback
                            buttonStatusDisabled( auxin.l10n.installFailedShort );
                            return false;
                        }
                    );
                }
            }

            /**
             * global AJAX callback
             */
            function globalAjax( _url, _type, _data, _beforeSendCallback, _successCallback, _errorCallback ) {
                $.ajax({
                    url: _url,
                    type: _type,
                    data: _data,
                    beforeSend: _beforeSendCallback,
                    success: _successCallback,
                    error: _errorCallback
                });
            }

            /**
             * Activate a plugin
             *
             * @return void
             */
            function activatePlugin( $data ){

                globalAjax(
                    $data['data-activate-url'],
                    'GET',
                    {},
                    function () { // beforeSend callback
                        buttonStatusInProgress( $data['data-activating-label'] );
                    },
                    function () { // success callback
                        buttonStatusDisabled( auxin.l10n.installedMsg );
                        run( $data['data-plugin-order'] );
                    },
                    function (xhr) {
                        buttonStatusDisabled( auxin.l10n.unknownError );
                        return false;
                    }
                );

            }

            /**
             * Change button status to in-progress
             *
             * @return void
             */
            function buttonStatusInProgress( message ){
                $button.addClass('updating-message').removeClass('button-disabled aux-not-installed installed').text( message );
            }

            /**
             * Change button status to disabled
             *
             * @return void
             */
            function buttonStatusDisabled( message ){
                $button.removeClass('updating-message aux-not-installed installed')
                        .addClass('button-disabled')
                        .text( message );
            }

            /**
             * Change button status to installed
             *
             * @return void
             */
            function buttonStatusInstalled( message ){
                $button.removeClass('updating-message aux-not-installed')
                        .addClass('installed')
                        .text( message );
            }

            const $plugins_info = $button.data('info');
            function run($key = 0) {
                if (typeof $plugins_info[$key] == 'undefined' || $plugins_info[$key]['data-plugin-order'] > $plugins_info[0]['data-num-of-required-plugins'] ) {
                    location.replace( $plugins_info[$plugins_info.length - 1]['data-redirect-url'] );
                    return;
                }
                let $this = $plugins_info[$key];
                if( $this['data-action'] === 'install' ){
                    installPlugin($this);
                } else if( $this['data-action'] === 'activate' ){
                    activatePlugin($this);
                }
            }
            run();

        });

    });

})(jQuery, window, document);
