<?php

namespace Tests;

use Symfony\Component\DomCrawler\Crawler;

/**
 * ShowKanrenPostsTest class
 */
class ShowKanrenPostsTest extends TestCase {

	protected \Show_Kanren_Posts $show_kanren_posts;

	public function setUp() :void {
		$this->show_kanren_posts = new \Show_Kanren_Posts();
	}

	/**
	 * @test
	 *
	 * Story: Instantiate Show_Kanren_Posts.
	 * Expected: an instance instantiated from Show_Kanren_Posts is instance of Show_Kanren_Posts.
	 */
	public function do_instance_of() {
		$this->assertInstanceOf( \Show_Kanren_Posts::class, $this->show_kanren_posts );
	}

	/**
	 * @test
	 *
	 * Story: Do shortcode without any options(postid, pageid, etc,...).
	 * Expected: null returned.
	 */
	public function do_shortcode_without_options() {
		$shortcode = '[kanren]';
		$response  = '';
		$this->assertSame( $response, do_shortcode( $shortcode ) );
	}

	/**
	 * @test
	 *
	 * Story: Give an existing postid.
	 * Expected: A div tag associated with given postid is returned.
	 */
	public function do_shortcode_with_existing_postid() {
		$post      = $this->factory()->post->create_and_get(
			array(
				'post_title'   => 'Hello World!',
				'post_content' => 'Hello World!',
				'post_type'    => 'page',
			)
		);
		$shortcode = '[kanren postid="' . $post->ID . '"]';
		$title     = $post->post_title;
		$date      = date( 'Y.m.d', strtotime( $post->post_date ) );

		$format  = '';
		$format .= '<div class="kanren">';
		$format .= '<div class="related_article typesimple">';
		$format .= '<a class="related_article__link no-icon" href="http://localhost/?page_id=%d">';
		$format .= '<div class="related_article__meta archives_post__meta inbox">';
		$format .= '<div class="related_article__ttl ttl">%s</div>';
		$format .= '<time class="time__date gf">%s</time>';
		$format .= '</div></a></div></div>';

		$response = sprintf( $format, $post->ID, $title, $date );
		$this->assertSame( $response, do_shortcode( $shortcode ) );
	}

	/**
	 * @test
	 *
	 * Story: Five post_ids are given.
	 * Expected: Each post is in single div(class: kanren) tag.
	 */
	public function do_shortcode_with_existing_postids() {
		$ids       = $this->factory()->post->create_many( 5 );
		$shortcode = '[kanren postid="' . implode( ',', $ids ) . '"]';
		$html      = do_shortcode( $shortcode );
		$crawler   = new Crawler( $html );
		$response  = 5;
		$this->assertSame( $response, count( $crawler->filter( '.kanren' ) ) );
	}

	/**
	 * @test
	 *
	 * Story: Give a NOT existing postid.
	 * Expected: A not-found message is returned.
	 */
	public function do_shortcode_with_not_existing_postid() {
		$shortcode = '[kanren postid="' . PHP_INT_MAX . '"]';
		$response  = '<p>記事を取得できませんでした。記事IDをご確認ください。</p>';
		$this->assertSame( $response, do_shortcode( $shortcode ) );
	}

	/**
	 * @test
	 *
	 * Story: Give an existing posturl.
	 * Expected: A div tag associated with given posturl is returned.
	 */
	public function do_shortcode_with_posturl_existed() {
		$post      = $this->factory()->post->create_and_get(
			array(
				'post_title'   => 'Hello World!',
				'post_content' => 'Hello World!',
				'post_type'    => 'post',
			)
		);
		$post_url  = get_permalink( $post->ID );
		$shortcode = '[kanren posturl="' . $post_url . '"]';
		$title     = $post->post_title;
		$date      = date( 'Y.m.d', strtotime( $post->post_date ) );

		$format  = '';
		$format .= '<div class="kanren">';
		$format .= '<div class="related_article typesimple">';
		$format .= '<a class="related_article__link no-icon" href="http://localhost/?p=%d">';
		$format .= '<div class="related_article__meta archives_post__meta inbox">';
		$format .= '<div class="related_article__ttl ttl">%s</div>';
		$format .= '<time class="time__date gf">%s</time>';
		$format .= '</div></a></div></div>';

		$response  = sprintf( $format, $post->ID, $title, $date );
		$shortcode = '[kanren posturl="' . $post_url . '"]';
		$this->assertSame( $response, do_shortcode( $shortcode ) );
	}

	/**
	 * @test
	 *
	 * Story: Give a NOT existing posturl.
	 * Expected: A not-found message is returned.
	 */
	public function do_shortcode_with_posturl_not_existed() {
		$post_url  = 'http://localhost/?p=' . PHP_INT_MAX;
		$shortcode = '[kanren posturl="' . $post_url . '"]';
		$response  = '<p>記事を取得できませんでした。記事IDをご確認ください。</p>';
		$this->assertSame( $response, do_shortcode( $shortcode ) );
	}

	/**
	 * @test
	 *
	 * Story: Give an existing pageurl.
	 * Expected: A div tag associated with given pageurl is returned.
	 */
	public function do_shortcode_with_pageurl_existed() {
		$post      = $this->factory()->post->create_and_get(
			array(
				'post_title'   => 'Hello World!',
				'post_content' => 'Hello World!',
				'post_type'    => 'page',
			)
		);
		$page_url  = get_permalink( $post->ID );
		$shortcode = '[kanren pageurl="' . $page_url . '"]';
		$title     = $post->post_title;
		$date      = date( 'Y.m.d', strtotime( $post->post_date ) );

		$format  = '';
		$format .= '<div class="kanren">';
		$format .= '<div class="related_article typesimple">';
		$format .= '<a class="related_article__link no-icon" href="http://localhost/?page_id=%d">';
		$format .= '<div class="related_article__meta archives_post__meta inbox">';
		$format .= '<div class="related_article__ttl ttl">%s</div>';
		$format .= '</div></a></div></div>';

		$response  = sprintf( $format, $post->ID, $title, $date );
		$shortcode = '[kanren pageurl="' . $page_url . '"]';
		$this->assertSame( $response, do_shortcode( $shortcode ) );
	}

	/**
	 * @test
	 *
	 * Story: Give a NOT existing pageurl.
	 * Expected: A not-found message is returned.
	 */
	public function do_shortcode_with_pageurl_not_existed() {
		$page_url  = 'http://localhost/?page_id=' . PHP_INT_MAX;
		$shortcode = '[kanren pageurl="' . $page_url . '"]';
		$response  = '<p>記事を取得できませんでした。記事IDをご確認ください。</p>';
		$this->assertSame( $response, do_shortcode( $shortcode ) );
	}

	/**
	 * @test
	 *
	 * Story: Get a thumbnail associated with a given post.
	 * Expected: An img tag with thumbnail is returned.
	 * Note: Check if PHP has right permissions to create an image file in uploads directory.
	 */
	public function do_get_exsting_thumbnail() {
		$post          = $this->factory()->post->create_and_get();
		$attachment_id = $this->factory()->attachment->create_upload_object( __DIR__ . '/assets/dummy-attachment.jpg', $post->ID );
		update_post_meta( $post->ID, '_thumbnail_id', $attachment_id );
		$attachment_metadata = wp_get_attachment_metadata( $attachment_id );
		$upload_dir          = wp_upload_dir();
		$src_url             = sprintf( '%s/%s', $upload_dir['baseurl'], $attachment_metadata['file'] );
		$response            = sprintf( '<img width="640" height="360" src="%s" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" decoding="async" loading="lazy" />', $src_url );

		$this->assertSame( $response, $this->show_kanren_posts->get_thumbnail( $post->ID ) );
		wp_delete_attachment( $attachment_id );
	}

	/**
	 * @test
	 *
	 * Story: Get a noimg.png instead of getting a thumbnail.
	 * Expected: An img tag with noimg.png is returned.
	 */
	public function do_get_noimg_thumbnail() {
		$post      = $this->factory()->post->create_and_get();
		$noimg_dir = '/images/noimg.png';
		$src       = get_theme_file_uri( $noimg_dir );
		$response  = sprintf( '<img src="%s" width="485" height="300" class="wp-post-image wp-post-no_image archives-eyecatch-image" alt="NO IMAGE">', $src );

		$this->assertSame( $response, $this->show_kanren_posts->get_thumbnail( $post->ID ) );
	}

	/**
	 * @test
	 *
	 * Story: Multiple shortcodes are called in a single post.
	 * Expected: Each kanren post has each value associated with themselves.
	 */
	public function do_multiple_shortcodes_in_single_post() {
		$values = array(
			array( 'post_title' => 'post0' ),
			array( 'post_title' => 'post1' ),
			array( 'post_title' => 'post2' ),
		);
		foreach ( $values as $value ) {
			$post      = $this->factory()->post->create_and_get( $value );
			$shortcode = sprintf( '[kanren postid="%s"]', $post->ID );
			$html      = do_shortcode( $shortcode );
			$crawler   = new Crawler( $html );
			$title     = $crawler->filter( '.related_article__ttl' )->text();
			$response  = $value['post_title'];
			$this->assertSame( $response, $title );
		}
	}
}
