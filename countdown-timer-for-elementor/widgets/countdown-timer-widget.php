<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Countdown_Timer_Elementor_Widget extends Widget_Base {

	public function get_name() { 		//Function for get the slug of the element name.
		return 'countdown-timer-widget';
	}

	public function get_title() { 		//Function for get the name of the element.
		return __( 'Countdown Timer', 'countdown-timer-for-elementor' );
	}

	public function get_icon() { 		//Function for get the icon of the element.
		return 'eicon-countdown';
	}
	
	public function get_categories() { 		//Function for include element into the category.
		return [ 'countdown-timer-widget' ];
	}
	
    /* 
	 * Adding the controls fields for the countdown timer
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'ctw_section',
			[
				'label' => __( 'Countdown', 'countdown-timer-for-elementor' ),
			]
		);
	    $this->add_control(
			'ctw_due_date',
			[
				'label' => __( 'Due Date', 'countdown-timer-for-elementor' ),
				'type' => Controls_Manager::DATE_TIME,
				'default' => date( 'Y-m-d H:i', strtotime( '+1 month' ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) ),
				'description' => sprintf( __( 'Date set according to your timezone: %s.', 'countdown-timer-for-elementor' ), Utils::get_timezone_string() ),
			]
		);
		$this->add_control(
			'ctw_show_days',
			[
				'label' => __( 'Days', 'countdown-timer-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'countdown-timer-for-elementor' ),
				'label_off' => __( 'Hide', 'countdown-timer-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->add_control(
			'ctw_show_hours',
			[
				'label' => __( 'Hours', 'countdown-timer-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'countdown-timer-for-elementor' ),
				'label_off' => __( 'Hide', 'countdown-timer-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->add_control(
			'ctw_show_minutes',
			[
				'label' => __( 'Minutes', 'countdown-timer-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'countdown-timer-for-elementor' ),
				'label_off' => __( 'Hide', 'countdown-timer-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->add_control(
			'ctw_show_seconds',
			[
				'label' => __( 'Seconds', 'countdown-timer-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'countdown-timer-for-elementor' ),
				'label_off' => __( 'Hide', 'countdown-timer-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->end_controls_section(); 
		
		$this->start_controls_section(
			'ctw_expire_section',
			[
				'label' => __( 'Countdown Expire' , 'countdown-timer-for-elementor' )
			]
		);
		$this->add_control(
			'ctw_expire_show_type',
			[
				'label'			=> __('Expire Type', 'countdown-timer-for-elementor'),
				'label_block'	=> false,
				'type'			=> Controls_Manager::SELECT,
                'description'   => __('Select whether you want to set a message or a redirect link after expire countdown', 'countdown-timer-for-elementor'),
				'options'		=> [
					'message'		=> __('Message', 'countdown-timer-for-elementor'),
					'redirect_link'		=> __('Redirect to Link', 'countdown-timer-for-elementor')
				],
				'default' => 'message'
			]
		);
		$this->add_control(
			'ctw_expire_message',
			[
				'label'			=> __('Expire Message', 'countdown-timer-for-elementor'),
				'type'			=> Controls_Manager::TEXTAREA,
				'default'		=> __('Sorry you are late!','countdown-timer-for-elementor'),
				'condition'		=> [
					'ctw_expire_show_type' => 'message'
				]
			]
		);
		$this->add_control(
			'ctw_expire_redirect_link',
			[
				'label'			=> __('Redirect On', 'countdown-timer-for-elementor'),
				'type'			=> Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'countdown-timer-for-elementor' ),
				'show_external' => true,
				'default' => [
					'url' => 'https://google.com',
					'is_external' => true,
					'nofollow' => true,
				],
				'condition'		=> [
					'ctw_expire_show_type' => 'redirect_link'
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'ctw_label_text_section',
			[
				'label' => __( 'Change Labels Text' , 'countdown-timer-for-elementor' )
			]
		);
        $this->add_control(
			'ctw_change_labels',
			[
				'label' => __( 'Change Labels', 'countdown-timer-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'countdown-timer-for-elementor' ),
				'label_off' => __( 'No', 'countdown-timer-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
		$this->add_control(
			'ctw_label_days',
			[
				'label' => __( 'Days', 'countdown-timer-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Days', 'countdown-timer-for-elementor' ),
				'placeholder' => __( 'Days', 'countdown-timer-for-elementor' ),
				'condition' => [
					'ctw_change_labels' => 'yes',
					'ctw_show_days' => 'yes',
				],
			]
		);
		$this->add_control(
			'ctw_label_hours',
			[
				'label' => __( 'Hours', 'countdown-timer-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Hours', 'countdown-timer-for-elementor' ),
				'placeholder' => __( 'Hours', 'countdown-timer-for-elementor' ),
				'condition' => [
					'ctw_change_labels' => 'yes',
					'ctw_show_hours' => 'yes',
				],
			]
		);
		$this->add_control(
			'ctw_label_minuts',
			[
				'label' => __( 'Minutes', 'countdown-timer-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Minutes', 'countdown-timer-for-elementor' ),
				'placeholder' => __( 'Minutes', 'countdown-timer-for-elementor' ),
				'condition' => [
					'ctw_change_labels' => 'yes',
					'ctw_show_minutes' => 'yes',
				],
			]
		);
		$this->add_control(
			'ctw_label_seconds',
			[
				'label' => __( 'Seconds', 'countdown-timer-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Seconds', 'countdown-timer-for-elementor' ),
				'placeholder' => __( 'Seconds', 'countdown-timer-for-elementor' ),
				'condition' => [
					'ctw_change_labels' => 'yes',
					'ctw_show_seconds' => 'yes',
				],
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(   
			'ctw_style_section',
			[
				'label' => __( 'Box', 'countdown-timer-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
            'ctw_box_align',
                [
                    'label'         => esc_html__( 'Alignment', 'countdown-timer-for-elementor' ),
                    'type'          => Controls_Manager::CHOOSE,
                    'options'       => [
                        'left'      => [
                            'title'=> esc_html__( 'Left', 'countdown-timer-for-elementor' ),
                          //  'icon' => 'fa fa-align-left',
							'icon' => 'eicon-text-align-left',
							
                            ],
                        'center'    => [
                            'title'=> esc_html__( 'Center', 'countdown-timer-for-elementor' ),
                            'icon' => 'eicon-text-align-center',
							
                            ],
                        'right'     => [
                            'title'=> esc_html__( 'Right', 'countdown-timer-for-elementor' ),
                            'icon' => 'eicon-text-align-right',
                            ],
                        ],
                    'toggle'        => false,
                    'default'       => 'center',
                    'selectors'     => [
                        '{{WRAPPER}} .countdown-timer-widget' => 'justify-content: {{VALUE}};',
						 '{{WRAPPER}} .countdown-timer-init' => 'justify-content: {{VALUE}};',
                        ],
                ]
        );
	    $this->add_control(
			'ctw_box_background_color',
			[
				'label' => __( 'Background Color', 'countdown-timer-for-elementor' ),
				'type' => Controls_Manager::COLOR,
 				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .countdown-items' => 'background-color: {{VALUE}};',
				],
				'separator' => 'after',
			]
		);
		$this->add_responsive_control(
			'ctw_box_spacing',
			[
				'label' => __( 'Box Gap', 'countdown-timer-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}} .countdown-items:not(:first-of-type)' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
					'body:not(.rtl) {{WRAPPER}} .countdown-items:not(:last-of-type)' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
					'body.rtl {{WRAPPER}} .countdown-items:not(:first-of-type)' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
					'body.rtl {{WRAPPER}} .countdown-items:not(:last-of-type)' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
				],
			]
		);
		$this->add_responsive_control(
			'ctw_col_spacing',
			[
				'label' => __( 'Column Gap', 'countdown-timer-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .countdown-timer-init' => 'column-gap:{{SIZE}}{{UNIT}}'
				],
			]
		);
		$this->add_responsive_control(
			'ctw_row_spacing',
			[
				'label' => __( 'Row Gap', 'countdown-timer-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .countdown-timer-init' => 'row-gap:{{SIZE}}{{UNIT}}'
				],
			]
		);
		$this->add_responsive_control(
			'ctw_digit_spacing',
			[
				'label' => __( 'Digit Gap', 'countdown-timer-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 300,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 200,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 150,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 100,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .countdown-items .ctw-digits' => 'height: calc( {{SIZE}}{{UNIT}}/2 );',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'box_border',
	            'selector' => '{{WRAPPER}} .countdown-items',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'ctw_box_border_radius',
			[
				'label' => __( 'Border Radius', 'countdown-timer-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .countdown-items' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
			'ctw_digits_style_section',
			[
				'label' => __( 'Digits', 'countdown-timer-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'ctw_digit_background_color',
			[
				'label' => __( 'Background Color', 'countdown-timer-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .countdown-items .ctw-digits' => 'background-color: {{VALUE}};',
				],
				'separator' => 'after',
			]
		);
		$this->add_control(
			'ctw_digits_color',
			[
				'label' => __( 'Color', 'countdown-timer-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ctw-digits' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'eac_digits_typography',
				'selector' => '{{WRAPPER}} .ctw-digits',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);
		$this->end_controls_section();   
		
		$this->start_controls_section(
			'ctw_labels_style_section',
			[
				'label' => __( 'Labels', 'countdown-timer-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'ctw_label_background_color',
			[
				'label' => __( 'Background Color', 'countdown-timer-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .ctw-label' => 'background-color: {{VALUE}};',
				],
				'separator' => 'after',
			]
		);
		$this->add_control(
			'ctw_label_color',
			[
				'label' => __( 'Color', 'countdown-timer-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ctw-label' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'eac_label_typography',
				'selector' => '{{WRAPPER}} .ctw-label',				
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);
		$this->end_controls_section();   
		
		$this->start_controls_section(
			'ctw_finish_message_style_section',
			[
				'label' => __( 'Message', 'countdown-timer-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'ctw_message_color',
			[
				'label' => __( 'Color', 'countdown-timer-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .finished-message' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'eac_message_typography',
				'selector' => '{{WRAPPER}} .finished-message',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);
		$this->end_controls_section();  
	}
	
	/**
	 * Render countdown timer widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings();		
		$day = $settings['ctw_show_days'];
		$hours = $settings['ctw_show_hours'];
		$minute = $settings['ctw_show_minutes'];
		$seconds = $settings['ctw_show_seconds'];
		$due_date = isset($settings['ctw_due_date']) ? preg_replace('/-/', '/', sanitize_text_field($settings['ctw_due_date'])) : '';
		?>
		<div class="countdown-timer-widget">
		    <div id="countdown-timer-<?php echo esc_attr($this->get_id()); ?>" class="countdown-timer-init"></div>
			<div id="finished-message-<?php echo esc_attr($this->get_id()); ?>" class="finished-message"></div>
		</div>
		<script>
			jQuery(function(){				
				jQuery('#countdown-timer-<?php echo esc_attr($this->get_id()); ?>').countdowntimer({
                    dateAndTime : "<?php echo esc_js($due_date); ?>",
                    regexpMatchFormat: "([0-9]{1,3}):([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})",
      				regexpReplaceWith: "<?php if ($day == "yes"){?><div class='countdown-items'><span class='ctw-digits'>$1</span><span class='ctw-label'><?php echo esc_html($settings['ctw_label_days']); ?></span> </div><?php } ?><?php if ($hours == "yes"){?> <div class='countdown-items'><span class='ctw-digits'>$2 </span><span class='ctw-label'><?php echo esc_html($settings['ctw_label_hours']); ?></span></div><?php } ?><?php if ($minute == "yes"){?><div class='countdown-items'> <span class='ctw-digits'> $3 </span><span class='ctw-label'><?php echo esc_html($settings['ctw_label_minuts']); ?></span> </div><?php } ?><?php if ($seconds == "yes"){?><div class='countdown-items'><span class='ctw-digits'> $4</span><span class='ctw-label'><?php echo esc_html($settings['ctw_label_seconds']); ?></span></div><?php } ?>",					
					<?php  
					if ( $settings['ctw_expire_show_type'] == "redirect_link" ){  ?>	
					timeUp : timeexpiryUrl,			
					<?php }
					if( $settings['ctw_expire_show_type'] == "message"){ ?>
					timeUp : timeisUp,					
					<?php } ?>
                });
				
				<?php
				if( $settings['ctw_expire_show_type'] == "redirect_link"){ ?>				
					function timeexpiryUrl(){
						<?php  $target = $settings['ctw_expire_redirect_link']['is_external'] ? '_blank' : '_self'; 					
						if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ){ ?>
							jQuery("#finished-message-<?php echo esc_attr($this->get_id()); ?>").html( "You can not redirect url from elementor Editor" );
						<?php } else { ?>
							window.open("<?php echo esc_url($settings['ctw_expire_redirect_link']['url']); ?>", "<?php echo esc_js($target); ?>");
							exit;
						<?php } ?>
				    }
				<?php } ?>
				<?php
				if( $settings['ctw_expire_show_type'] == "message"){ ?>				
					function timeisUp(){						
						jQuery("#finished-message-<?php echo esc_attr($this->get_id()); ?>").html( "<span><?php echo esc_html($settings['ctw_expire_message']);?></span>" );
				    }
				<?php } ?>					
			});		    
        </script>
		<?php
	}

    /**
	 * Render countdown widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @access protected
	 */
	protected function content_template() { 
		 
	}	
}
Plugin::instance()->widgets_manager->register( new Countdown_Timer_Elementor_Widget() );