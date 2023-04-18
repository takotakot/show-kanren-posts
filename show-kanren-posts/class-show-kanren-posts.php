<?php
/**
 * Show Kanren Posts
 *
 * @package           Show_Kanren_Posts
 */

/**
 * Class Show_Kanren_Posts
 */
class Show_Kanren_Posts {

    /**
     * Register shortcodes
     */
    public function __construct() {
		add_shortcode('kanren', array(&$this, 'kanrenPost'));
	}

	/**
	 * Query string for sort
	 *
	 * @var bool
	 */
	private static $initiated = false;

	/**
	 * Initialization
	 */
	public static function init() {
		if ( ! self::$initiated ) {
			self::init_hooks();
		}
	}

	/**
	 * Initializes WordPress hooks
	 */
	private static function init_hooks() {
		self::$initiated = true;
	}

	/**
	 * Show related post
	 */
	public function kanrenPost($atts) {
		$postid = isset($atts['postid']) ? esc_attr($atts['postid']) : null;
		$pageid = isset($atts['pageid']) ? esc_attr($atts['pageid']) : null;

		$posturl = isset($atts['posturl']) ? esc_url($atts['posturl']) : null;
		$pageurl = isset($atts['pageurl']) ? esc_url($atts['pageurl']) : null;
		if ($posturl) {
			$postid = url_to_postid($posturl);
		}
		if ($pageurl) {
			$pageid = url_to_postid($pageurl);
		}

		if ($postid || $pageid) {

			$postids = (explode(',', (string)$postid));
			$datenone = isset($atts['date']) ? esc_attr($atts['date']) : null;
			$order = isset($atts['order']) ? esc_attr($atts['order']) : "DESC";
			$orderby = isset($atts['orderby']) ? esc_attr($atts['orderby']) : "post_date";
			$labelclass = isset($atts['label']) ? ' labelnone' : "";
			$labeltext = isset($atts['labeltext']) ? esc_attr($atts['labeltext']) : '関連記事';
			$target = isset($atts['target']) ? ' target="_blank"' : "";
			$type = isset($atts['type']) ? ' type' . esc_attr($atts['type']) : " typesimple";
			$classname = isset($atts['class']) ? ' ' . esc_attr($atts['class']) : null;

			$echo = "";

			$args = array(
				"post_type" => array('post', 'page'),
				'posts_per_page' => -1,
				'post__in' => $postids,
				'page_id' => $pageid,
				'orderby' => $orderby,
				'order' => $order,
				'post_status' => 'publish',
				'suppress_filters' => true,
				'ignore_sticky_posts' => true,
				'no_found_rows' => true
			);

			$the_query = new WP_Query($args);

			if ($the_query->have_posts()) {
				while ($the_query->have_posts()) {
					$the_query->the_post();

					$post_id = '';

					$url = esc_url(get_permalink());
					$postimg = has_post_thumbnail() && $type !== ' typetext' ? '<figure class="eyecatch of-cover thum">' . $this->skt_oc_post_thum() . '</figure>' : null;
					$postdate = (!$datenone && !$pageid) ? $this->stk_archivesdate() : null;
					$postlabel = (!$labelclass == ' labelnone') ? '<span class="labeltext">' . $labeltext . '</span>' : null;
					$postttl = '<div class="related_article__ttl ttl">' . $postlabel . esc_attr(get_the_title()) . '</div>';

					$echo .= '<div class="related_article' . $labelclass . $type . $classname . '"><a class="related_article__link no-icon" href="' . $url . '"' . $target . '>' . $postimg . '<div class="related_article__meta archives_post__meta inbox">' . $postttl . $postdate . '</div></a></div>';
				} // LOOP END
				wp_reset_postdata();
			} else {
				$echo = '<p>記事を取得できませんでした。記事IDをご確認ください。</p>';
			}

			return $echo;
		} else {
			return null;
		}
	}

	public function stk_archivesdate() {
		$display_post_date = get_option('post_options_date', 'undo_on');

		if ($display_post_date == "date_undo_off") return;
		$output = "";
		// date on
		if (
			$display_post_date == "date_on"
			|| ($display_post_date == "undo_on" && get_the_date('Ymd') >= get_the_modified_date('Ymd'))
			|| ($display_post_date == "date_undo_on" && get_the_date('Ymd') >= get_the_modified_date('Ymd'))
		) {
			$output .= '<time class="time__date gf">';
			$output .= get_the_date('Y.m.d');
			$output .= '</time>';
		}
		// undo on
		if (
			($display_post_date == "date_undo_on" || $display_post_date == "undo_on")
			&& get_the_date('Ymd') < get_the_modified_date('Ymd')
		) {
			$output .= '<time class="time__date gf undo">';
			$output .= get_the_modified_date('Y.m.d');
			$output .= '</time>';
		}
		return $output;
	}

	public function skt_oc_post_thum($stk_eyecatch_size = 'oc-post-thum') {

		$post_id = get_the_ID();
		$image_id = get_post_thumbnail_id($post_id);

		if ($image_id) {

			$thumb = get_the_post_thumbnail(
				$post_id,
				$stk_eyecatch_size,
				array(
					'class' => 'archives-eyecatch-image attachment-' . $stk_eyecatch_size,
				)
			);
		} else {
			$thumb = $this->oc_noimg();
		}
		$thumb = str_replace('100vw', '45vw', $thumb);
		return $thumb;
	}

	public function oc_noimg() {
		$image_id = attachment_url_to_postid(get_theme_mod('stk_archives_noimg'));

		if ($image_id !== 0) {
			$output = wp_get_attachment_image(
				$image_id,
				'full',
				false,
				array(
					'class' => 'wp-post-image wp-post-no_image archives-eyecatch-image',
				)
			);
		} else {
			$output = '<img src="' . get_theme_file_uri('/images/noimg.png') . '" width="485" height="300" class="wp-post-image wp-post-no_image archives-eyecatch-image" alt="NO IMAGE">';
		}

		return $output;
	}
}
