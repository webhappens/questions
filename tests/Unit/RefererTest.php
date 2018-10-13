<?php

namespace WebHappens\Questions\Tests\Unit;

use WebHappens\Questions\Referer;
use WebHappens\Questions\Tests\TestCase;

class RefererTest extends TestCase
{
    /** @test */
    public function can_first_or_create_from_not_a_url()
    {
        $this->firstOrCreateFromString('example.com/not-a-url');
        $this->firstOrCreateFromString('/not-a-url');
        $this->firstOrCreateFromString('http://not-a-url');
    }

    /** @test */
    public function can_first_or_create_from_valid_url()
    {
        $this->firstOrCreateFromString('https://example.org');
        $this->firstOrCreateFromString('https://example.org/my-article');
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
