<?php

namespace Tests;

/**
 * TODO
 * !!This test does not work because it cannot instantiate Show_Kanren_Posts class.
 */
class ShowKanrenPostsTest extends TestCase
{
    protected \Show_Kanren_Posts $show_kanren_posts;

    public function setUp() :void{
        $this->show_kanren_posts = new \Show_Kanren_Posts();
    }

    public function testInstanceOf() {
        $this->assertInstanceOf(\Show_Kanren_Posts::class, $this->show_kanren_posts);
    }

    /** @test */
    public function it_works()
    {
        $this->assertTrue(function_exists('add_action'));
    }

	/** @test */
	public function do_shortcode_processed() {
		$shortcode    = '[kanren]';
		$hellomessage = '<div>Hello, kanrenPost!</div>';
		$this->assertEquals( $hellomessage, do_shortcode( $shortcode ) );
	}
}
