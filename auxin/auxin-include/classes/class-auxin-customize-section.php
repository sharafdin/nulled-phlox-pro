<?php
/**
 * A custom customizer section for auxin framework
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
 */
class Auxin_Customize_Section extends WP_Customize_Section {

    public $section;
    public $preview_link;
    public $dependency;
    public $is_deprecated;
    public $type = 'auxin_section';

    public function __construct( $manager, $id, $args = array() ) {
        parent::__construct( $manager, $id, $args );
        if( isset( $this->dependency['relation'] ) ){
            $this->dependency[] = array( 'relation' => $this->dependency['relation'] );
            unset( $this->dependency['relation'] );
        } elseif ( is_array( $this->dependency ) ){
            $this->dependency[] = array( 'relation' => 'and' );
        }

    }

    /**
     * Add preview link to js params
     *
     * @return json data
     */
    public function json() {
        $json = parent::json();

        $field_dependencies = array();

        if( ! empty( $this->dependency ) ){
            $dependencies = (array) $this->dependency;

            foreach ( $dependencies as $target_id => $target ) {

                if( 'relation' === $target_id ) {
                    continue;
                }

                if( empty( $target['id'] ) || ! ( isset( $target['value'] ) && ! empty( $target['value'] ) ) ){ continue; }

                // make sure there is no duplication in values array
                if( is_array( $target['value'] ) ){
                    $target['value'] = array_unique( $target['value'] );
                }

                // if the operator was not defined or was defined as '=' by mistake
                $target['operator'] = ! empty( $target['operator'] ) && ( '=' !== $target['operator'] )  ? $target['operator'] : '==';

                $target['id'] = $target['id'] . '_control';
                $field_dependencies[ $target_id ] = $target;
            }

            $field_dependencies[ $target_id ] = $target;
        }

        $json['preview_link'] = $this->preview_link;
        $json['dependencies'] = $field_dependencies;
        $json['isDeprecated'] = $this->is_deprecated;

        return $json;
    }

    /**
     * Renders output for section title and description
     *
     * @return void
     */
    function render_template() {
        ?>
        <li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }}">
            <h3 class="accordion-section-title" tabindex="0">
                {{ data.title }}
                <span class="screen-reader-text"><?php _e( 'Press return or enter to open this section', 'phlox-pro' ); ?></span>
                <# if ( data.isDeprecated ) { #>
                    <span class="aux-deprecated"><?php _e( 'Deprecated', 'phlox-pro' ); ?></span>
                <# } #>
            </h3>

            <ul class="accordion-section-content">
                <li class="customize-section-description-container section-meta <# if ( data.description_hidden ) { #>customize-info<# } #>">
                    <div class="customize-section-title">
                        <button class="customize-section-back" tabindex="-1">
                            <span class="screen-reader-text"><?php _e( 'Back', 'phlox-pro' ); ?></span>
                        </button>
                        <h3>
                            <span class="customize-action">
                                {{{ data.customizeAction }}}
                            </span>
                            {{ data.title }}
                        </h3>
                        <# if ( data.description && data.description_hidden ) { #>
                            <button type="button" class="customize-help-toggle dashicons dashicons-editor-help" aria-expanded="false"><span class="screen-reader-text"><?php _e( 'Help', 'phlox-pro' ); ?></span></button>
                            <div class="description customize-section-description">
                                {{{ data.description }}}
                            </div>
                        <# } #>
                    </div>

                    <# if ( data.description && ! data.description_hidden ) { #>
                        <div class="description customize-section-description">
                            <!-- @auxin start -->
                            <# if ( data.preview_link ) { #>
                            <a class="aux-customizer-section-preview-link" href="{{{ data.preview_link }}}">
                            <# } #>
                            {{{ data.description }}}
                            <# if ( data.preview_link ) { #>
                            </a>
                            <# } #>
                            <!-- @auxin end -->
                        </div>
                    <# } #>
                </li>
            </ul>
        </li>
        <?php
    }
}

