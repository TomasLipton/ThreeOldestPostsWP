<?php

class ThreeOldestPosts
{
    public function __construct()
    {
        add_action('wp_ajax_get_three_oldest_posts', array($this, 'my_action_callback'));
        add_action('wp_ajax_nopriv_get_three_oldest_posts', array($this, 'my_action_callback'));
    }

    public function my_action_callback()
    {
        $args = [
            'orderby' => 'post_date',
            'order' => 'ASC',
            'posts_per_page' => 3
        ];
        $query = new WP_Query($args);
        $content = [];
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $content[] = get_the_content();
            }
            wp_reset_postdata();
        }

        wp_send_json($content);
    }
}