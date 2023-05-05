<?php
/**
 * Show Kanren Posts
 *
 * @package Show_Kanren_Posts
 */

/**
 * Class Show_Kanren_Posts
 */
class Show_Kanren_Posts {

	private $post_id;
	private $post_ids;
	private $page_id;
	private $post_url;
	private $page_url;
	private $date;
	private $datenone;
	private $order;
	private $orderby;
	private $labelclass;
	private $labeltext;
	private $target;
	private $type;
	private $classname;


	/**
	 * Register shortcodes
	 */
	public function __construct() {
		add_shortcode( 'kanren', array( &$this, 'kanren_post' ) );
		add_shortcode( 'kanren2', array( &$this, 'kanren2_post' ) );
	}

	/**
	 * Set attributes
	 *
	 * @param array|string $atts Attributes in shortcode.
	 * @param bool         $is_kanren2 Whether shortcode is kanren2.
	 * @return void
	 */
	public function set_atts( $atts, $is_kanren2 = false ) {
		if ( ! $is_kanren2 ) {
			$this->post_id  = isset( $atts['postid'] ) ? esc_attr( $atts['postid'] ) : null;
			$this->page_id  = isset( $atts['pageid'] ) ? esc_attr( $atts['pageid'] ) : null;
			$this->post_url = isset( $atts['posturl'] ) ? esc_url( $atts['posturl'] ) : null;
			$this->page_url = isset( $atts['pageurl'] ) ? esc_url( $atts['pageurl'] ) : null;
			if ( $this->post_id === null && $this->post_url !== null ) {
				$this->post_id = url_to_postid( $this->post_url );
			}
			if ( $this->page_id === null && $this->page_url !== null ) {
				$this->page_id = url_to_postid( $this->page_url );
			}
			$this->post_ids   = explode( ',', (string) $this->post_id );
			$this->datenone   = isset( $atts['date'] ) ? esc_attr( $atts['date'] ) : null;
			$this->order      = isset( $atts['order'] ) ? esc_attr( $atts['order'] ) : 'DESC';
			$this->orderby    = isset( $atts['orderby'] ) ? esc_attr( $atts['orderby'] ) : 'post_date';
			$this->labelclass = isset( $atts['label'] ) ? ' labelnone' : '';
			$this->labeltext  = isset( $atts['labeltext'] ) ? esc_attr( $atts['labeltext'] ) : '関連記事';
			$this->target     = isset( $atts['target'] ) ? ' target="_blank"' : '';
			$this->type       = isset( $atts['type'] ) ? ' type' . esc_attr( $atts['type'] ) : ' typesimple';
			$this->classname  = isset( $atts['class'] ) ? ' ' . esc_attr( $atts['class'] ) : null;
		} else {
			$this->post_id   = isset( $atts['postid'] ) ? esc_attr( $atts['postid'] ) : null;
			$this->page_id   = isset( $atts['pageid'] ) ? esc_attr( $atts['pageid'] ) : null;
			$this->post_url  = isset( $atts['posturl'] ) ? ' posturl="' . esc_url( $atts['posturl'] ) . '"' : null;
			$this->page_url  = isset( $atts['pageurl'] ) ? ' pageurl="' . esc_url( $atts['pageurl'] ) . '"' : null;
			$this->date      = isset( $atts['date'] ) ? ' date="' . esc_attr( $atts['date'] ) . '"' : null;
			$this->order     = isset( $atts['order'] ) ? ' order="' . esc_attr( $atts['order'] ) . '"' : null;
			$this->orderby   = isset( $atts['orderby'] ) ? ' orderby="' . esc_attr( $atts['orderby'] ) . '"' : null;
			$this->target    = isset( $atts['target'] ) ? ' target="' . esc_attr( $atts['target'] ) . '"' : null;
			$this->type      = isset( $atts['type'] ) ? ' type="' . esc_attr( $atts['type'] ) . '"' : null;
			$this->classname = isset( $atts['class'] ) ? ' class="' . esc_attr( $atts['class'] ) . '"' : null;
		}
	}

	/**
	 * Show related post
	 *
	 * @param string|array $atts Given values set in shortcode attributes.
	 * @return string|null
	 */
	public function kanren_post( $atts ) {
		$this->set_atts( $atts );
		if ( $this->post_id === null && $this->page_id === null ) {
			return '';
		} else {
			$out = '<div class="kanren';

			$args = array(
				'post_type'           => array( 'post', 'page' ),
				'posts_per_page'      => -1,
				'post__in'            => $this->post_ids,
				'page_id'             => $this->page_id,
				'orderby'             => $this->orderby,
				'order'               => $this->order,
				'post_status'         => 'publish',
				'suppress_filters'    => true,
				'ignore_sticky_posts' => true,
				'no_found_rows'       => true,
			);

			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) {
				$out .= '">';
				while ( $the_query->have_posts() ) {
					$the_query->the_post();

					$post_id   = get_the_ID();
					$url       = esc_url( get_permalink() );
					$postimg   = has_post_thumbnail() && ' typetext' !== $this->type
									? sprintf( '<figure class="eyecatch of-cover thum">%s</figure>', $this->get_thumbnail( $post_id ) )
									: null;
					$postdate  = ! $this->datenone && ! $this->page_id
									? sprintf( '<time class="time__date gf">%s</time>', get_the_date( 'Y.m.d' ) )
									: null;
					$postlabel = ! ' labelnone' === $this->labelclass
									? sprintf( '<span class="labeltext">%s</span>', $this->labeltext )
									: null;
					$postttl   = sprintf( '<div class="related_article__ttl ttl">%s%s</div>', $postlabel, esc_attr( get_the_title() ) );

					$out .= sprintf( '<div class="related_article%s%s%s">', $this->labelclass, $this->type, $this->classname );
					$out .= sprintf( '<a class="related_article__link no-icon" href="%s"%s>', $url, $this->target );
					$out .= sprintf( '%s<div class="related_article__meta archives_post__meta inbox">', $postimg );
					$out .= sprintf( '%s%s</div></a></div>', $postttl, $postdate );
				}
				wp_reset_postdata();
			} else {
				$out .= ' nopost"><p>記事を取得できませんでした。記事IDをご確認ください。</p>';
			}
			return sprintf( '%s</div>', $out );
		}
	}

	/**
	 * Show related post with no label.
	 *
	 * @param string|array $atts Given values set in shortcode attributes.
	 * @return string|null
	 */
	public function kanren2_post( $atts ) {
		$this->set_atts( $atts, true );

		ob_start();
		if ( $this->post_id !== null || $this->post_url !== null ) {
			echo do_shortcode( '[kanren postid="' . $this->post_id . '" label="none"' . $this->date . $this->order . $this->orderby . $this->type . $this->target . $this->post_url . $this->classname . ']' );
		} elseif ( $this->page_id !== null || $this->page_url !== null ) {
			echo do_shortcode( '[kanren pageid="' . $this->page_id . '" label="none"' . $this->date . $this->order . $this->orderby . $this->type . $this->target . $this->page_url . $this->classname . ']' );
		} else {
			null;
		}
		return ob_get_clean();
	}

	/**
	 * Get thumbnail img.
	 * If no thumbnail is set, get noimg.png instead.
	 *
	 * @param string $post_id Post ID.
	 * @return string
	 */
	public function get_thumbnail( $post_id ) {
		$image_id = get_post_thumbnail_id( $post_id );
		if ( $image_id > 0 ) {
			$thumb = get_the_post_thumbnail( $post_id );
		} else {
			$noimg_dir   = '/images/noimg.png';
			$src         = get_theme_file_uri( $noimg_dir );
			$width       = 485;
			$height      = 300;
			$noimg_class = 'wp-post-image wp-post-no_image archives-eyecatch-image';
			$thumb       = sprintf( '<img src="%s" width="%d" height="%d" class="%s" alt="NO IMAGE">', $src, $width, $height, $noimg_class );
		}
		return $thumb;
	}
}
