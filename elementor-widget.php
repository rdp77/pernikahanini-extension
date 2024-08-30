<?php
if (!defined("ABSPATH")) {
    exit();
}

class PernikahanIni_Elementor_Widget extends \Elementor\Widget_Base
{
    private string $query_parameter = "dear";
    private string $data_not_found = "No data found.";
    private string $text_color = "#000000";
    private string $text_alignment = "center";
    private string $form_wished_name = "input-text-form";
    private array $text_shadow = [
        "color" => "rgba(0, 0, 0, 0.3)",
        "blur" => "0px",
        "horizontal" => "0px",
        "vertical" => "0px",
    ];

    public function get_name()
    {
        return "dear_name";
    }

    public function get_title()
    {
        return "Dear Name";
    }

    public function get_icon()
    {
        return "eicon-text-align-center";
    }

    public function get_categories()
    {
        return ["pernikahan-ini"];
    }

    protected function _register_controls()
    {
        $this->start_controls_section("section_content", [
            "label" => esc_html__("Content", "textdomain"),
            "tab" => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->get_content_tab();
        $this->end_controls_section();

        $this->start_controls_section("section_style", [
            "label" => esc_html__("Style", "textdomain"),
            "tab" => \Elementor\Controls_Manager::TAB_STYLE,
        ]);
        $this->get_style_tab();
        $this->end_controls_section();
    }

    protected function get_content_tab()
    {
        $this->add_control("is_filled_name", [
            "label" => esc_html__("Filled Wished Name", "textdomain"),
            "type" => \Elementor\Controls_Manager::SWITCHER,
            "return_value" => "yes",
            "default" => "yes",
        ]);

        $this->add_control("filled_name_form", [
            "label" => esc_html__("Form Wished Name", "textdomain"),
            "type" => \Elementor\Controls_Manager::TEXT,
            "default" => $this->form_wished_name,
        ]);

        $this->add_control("is_hide_not_found", [
            "label" => esc_html__("Hide when data Not Found", "textdomain"),
            "type" => \Elementor\Controls_Manager::SWITCHER,
            "label_on" => esc_html__("Show", "textdomain"),
            "label_off" => esc_html__("Hide", "textdomain"),
            "return_value" => "yes",
            "default" => "no",
        ]);

        $this->add_control("data_not_found_text", [
            "label" => esc_html__("Data Not Found Message", "textdomain"),
            "type" => \Elementor\Controls_Manager::TEXT,
            "default" => $this->data_not_found,
        ]);

        $this->add_control("query_param", [
            "label" => esc_html__("Query Parameter", "textdomain"),
            "type" => \Elementor\Controls_Manager::TEXT,
            "default" => $this->query_parameter,
        ]);

        $this->end_controls_section();

        $this->start_controls_section("hidden_controls_content", [
            "label" => esc_html__("Hidden Control", "textdomain"),
            "tab" => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control("list", [
            "label" => esc_html__("IDs Selectors", "textdomain"),
            "type" => \Elementor\Controls_Manager::REPEATER,
            "fields" => [
                [
                    "name" => "list_id",
                    "label" => esc_html__("CSS ID", "textdomain"),
                    "type" => \Elementor\Controls_Manager::TEXT,
                    "default" => esc_html__("example-container", "textdomain"),
                    "label_block" => true,
                ],
            ],
            "default" => [
                [
                    "list_id" => esc_html__("container-data", "textdomain"),
                ],
                [
                    "list_id" => esc_html__("rspv-wishes", "textdomain"),
                ],
            ],
            "title_field" => "{{{ list_id }}}",
        ]);
    }

    public function get_style_tab()
    {
        // Text Color
        $this->add_control("text_color", [
            "label" => "Text Color",
            "type" => \Elementor\Controls_Manager::COLOR,
            "default" => $this->text_color,
            "selectors" => [
                "{{WRAPPER}} .dear-name-text" => "color: {{VALUE}};",
            ],
        ]);

        // Text Alignment
        $this->add_control("text_alignment", [
            "label" => esc_html__("Text Alignment", "textdomain"),
            "type" => \Elementor\Controls_Manager::CHOOSE,
            "options" => [
                "left" => [
                    "title" => esc_html__("Left", "textdomain"),
                    "icon" => "eicon-text-align-left",
                ],
                "center" => [
                    "title" => esc_html__("Center", "textdomain"),
                    "icon" => "eicon-text-align-center",
                ],
                "right" => [
                    "title" => esc_html__("Right", "textdomain"),
                    "icon" => "eicon-text-align-right",
                ],
            ],
            "default" => $this->text_alignment,
            "toggle" => true,
            "selectors" => [
                "{{WRAPPER}} .dear-name-text" => "text-align: {{VALUE}};",
            ],
        ]);

        // Text Shadow
        $this->add_control("text_shadow_toggle", [
            "label" => "Text Shadow",
            "type" => \Elementor\Controls_Manager::POPOVER_TOGGLE,
            "label_block" => false,
        ]);

        $this->start_popover();

        $this->add_control("custom_text_shadow", [
            "label" => esc_html__("Text Shadow", "textdomain"),
            "type" => \Elementor\Controls_Manager::TEXT_SHADOW,
            "selectors" => [
                "{{SELECTOR}}" =>
                "text-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{COLOR}};",
            ],
        ]);

        $this->end_popover();

        $this->end_controls_section();

        $this->start_controls_section("section_animation", [
            "label" => esc_html__("Animation", "textdomain"),
            "tab" => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control("entrance_animation", [
            "label" => esc_html__("Entrance Animation", "textdomain"),
            "type" => \Elementor\Controls_Manager::ANIMATION,
            "prefix_class" => "animated ",
        ]);

        $this->add_control("exit_animation", [
            "label" => esc_html__("Exit Animation", "textdomain"),
            "type" => \Elementor\Controls_Manager::EXIT_ANIMATION,
            "prefix_class" => "animated ",
        ]);

        $this->add_control("hover_animation", [
            "label" => esc_html__("Hover Animation", "textdomain"),
            "type" => \Elementor\Controls_Manager::HOVER_ANIMATION,
        ]);
    }

    protected function render_hide_element_javascript(array $list = [])
    {
        // * Normalize array data
        $list_ids = array_column($list, "list_id");

        // * Encode array to JSON
        $json_data = wp_json_encode($list_ids);
        // * Render JavaScript
?>
        <div id="elements-selector-data" data-array="<?php echo esc_attr(
                                                            $json_data
                                                        ); ?>"></div>
    <?php
    }

    protected function render_auto_filled_javascript(
        string $is_filled_text = "",
        string $filled_name_form = "",
        string $text = ""
    ) {
        // * Encode data to JSON
        $filled_data = wp_json_encode($is_filled_text);
        $filled_form_data = wp_json_encode($filled_name_form);
        // * Render JavaScript
    ?>
        <div id="element-filled-data" data-filled-name="<?php echo esc_attr(
                                                            $filled_data
                                                        ); ?>"></div>
        <div id="form-filled-data" data-form-name="<?php echo esc_attr(
                                                        $filled_form_data
                                                    ); ?>"></div>
    <?php
    }

    protected function render_hide_on_not_found(
        string $is_hidden_not_found = ""
    ) {
        // * Encode data to JSON
        $is_hidden_not_found_data = wp_json_encode(
            $is_hidden_not_found
        ); // * Render JavaScript
    ?>
        <div id="element-is-hidden-not-found" data-is-hidden-not-found="<?php echo esc_attr(
                                                                            $is_hidden_not_found_data
                                                                        ); ?>">
        </div>
<?php
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $data_not_found =
            $settings["data_not_found_text"] ?? $this->data_not_found;
        $param_text = $settings["query_param"];
        $text_color = $settings["text_color"] ?? $this->text_color;
        $text_alignment = $settings["text_alignment"] ?? $this->text_alignment;

        // * Get settings text shadow
        $text_shadow_color =
            $settings["custom_text_shadow"]["color"] ??
            $this->text_shadow["color"];
        $text_shadow_horizontal =
            $settings["custom_text_shadow"]["horizontal"] . "px" ??
            $this->text_shadow["horizontal"];
        $text_shadow_vertical =
            $settings["custom_text_shadow"]["vertical"] . "px" ??
            $this->text_shadow["vertical"];
        $text_shadow_blur =
            $settings["custom_text_shadow"]["blur"] . "px" ??
            $this->text_shadow["blur"];

        $style = sprintf(
            "color: %s; text-align: %s; text-shadow: %s %s %s %s;",
            esc_attr($text_color),
            esc_attr($text_alignment),
            esc_attr($text_shadow_horizontal),
            esc_attr($text_shadow_vertical),
            esc_attr($text_shadow_blur),
            esc_attr($text_shadow_color)
        );

        $param = isset($_GET[$param_text])
            ? sanitize_text_field($_GET[$param_text])
            : null;

        $found = false;
        if ($param) {
            global $wpdb;
            $table_name = $wpdb->prefix . "pernikahanini";
            $name = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT name FROM $table_name WHERE name = %s",
                    $param
                )
            );
            if ($name !== null) {
                $found = true;
            }
        } else {
            $name = $data_not_found;
        }

        $text = $found ? esc_html($name) : $data_not_found;

        if (!$found) {
            $this->render_hide_element_javascript($settings["list"]);
        }
        $this->render_auto_filled_javascript(
            $settings["is_filled_name"],
            $settings["filled_name_form"],
        );
        $this->render_hide_on_not_found($settings["is_hide_not_found"]);

        $id = 'dear-name';
        $class = 'dear-name-text';
        $styleAttr = htmlspecialchars($style, ENT_QUOTES, 'UTF-8');
        $textContent = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');

        echo sprintf(
            '<p id="%s" class="%s" style="%s">%s</p>',
            $id,
            $class,
            $styleAttr,
            $textContent
        );
    }
}
