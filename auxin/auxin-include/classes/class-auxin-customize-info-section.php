<?php
/**
 * A simple customizer section for displaying information
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
 */
class Auxin_Customize_Info_Section extends Auxin_Customize_Section {

    /**
     * The type of customize section being rendered.
     *
     * @since  1.0.0
     * @access public
     * @var    string
     */
    public $type = 'auxin_info_section';

    /**
     * Outputs the Underscore.js template.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function render_template() { ?>
        <li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
			<span class="customize-control-title customize-section-title-{{ data.id }}-heading">{{ data.title }}</span>
			<p class="customize-control-description customize-section-title-{{ data.id }}-description">{{ data.description }}</p>
        </li>
    <?php }
}
