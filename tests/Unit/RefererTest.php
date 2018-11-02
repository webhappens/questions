<?php

namespace WebHappens\Questions\Tests\Unit;

use WebHappens\Questions\Referer;
use WebHappens\Questions\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RefererTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function can_make_from_not_a_url()
    {
        $this->makeFromString('example.org/not-a-url');
        $this->makeFromString('/not-a-url');
        $this->makeFromString('http://not-a-url');
    }

    /** @test */
    public function can_make_from_a_valid_url()
    {
        $this->makeFromString('https://example.org');
        $this->makeFromString('https://example.org/my-article');
        $this->makeFromString('https://example.org?a=1&b=2');
        $this->makeFromString('https://example.org#fragment');
    }

    /** @test */
    public function can_first_or_create_from_not_a_url()
    {
        $this->firstOrCreateFromString('example.org/not-a-url');
        $this->firstOrCreateFromString('/not-a-url');
        $this->firstOrCreateFromString('http://not-a-url');
    }

    /** @test */
    public function can_first_or_create_from_valid_url()
    {
        $this->firstOrCreateFromString('https://example.org');
        $this->firstOrCreateFromString('https://example.org/my-article');
        $this->firstOrCreateFromString('https://example.org?a=1&b=2');
        $this->firstOrCreateFromString('https://example.org#fragment');
    }

    /** @test */
    public function can_to_string()
    {
        $referer1 = Referer::makeFromString('https://example.org');
        $this->assertEquals('https://example.org', (string)$referer1);

        $referer2 = Referer::makeFromString('https://example.org?a=1&b=2');
        $this->assertEquals('https://example.org?a=1&b=2', (string)$referer2);
    }

    /** @test */
    public function will_normalise_query_order()
    {
        $referer = Referer::makeFromString('https://example.org?b=2&a=1');
        $this->assertEquals('https://example.org?a=1&b=2', (string)$referer);
    }

    private function makeFromString($string)
    {
        $referer = Referer::makeFromString($string);
        $this->assertInstanceOf(Referer::class, $referer);
        $this->assertCount(0, Referer::all());
    }

    private function firstOrCreateFromString($string)
    {
        $referer1 = Referer::firstOrCreateFromString($string);
        $this->assertInstanceOf(Referer::class, $referer1);

        $referer2 = Referer::firstOrCreateFromString($string);
        $this->assertInstanceOf(Referer::class, $referer2);

        $this->assertCount(1, Referer::all());

        Referer::truncate();
    }
}
