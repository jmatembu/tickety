<?php

use App\Concert;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ConcertTest extends TestCase
{
    use DatabaseMigrations;
    
    /**
     * @test
     */
    public function can_get_formatted_date()
    {
        $concert = factory(Concert::class)->make([
            'date' => Carbon::parse('2018-02-28 8:00pm')
        ]);

        $this->assertEquals('February 28, 2018', $concert->formatted_date);
    }

    /**
     * @test
     */
    public function can_get_formatted_start_time()
    {
        $concert = factory(Concert::class)->make([
            'date' => Carbon::parse('2018-02-28 20:00:00')
        ]);

        $this->assertEquals('8:00pm', $concert->formatted_start_time);
    }

    /**
     * @test
     */
    public function can_get_price_in_dollars()
    {
        $concert = factory(Concert::class)->make([
            'price' => 3250
        ]);

        $this->assertEquals(32.50, $concert->price_in_dollars);
    }

    /** @test */
    public function concerts_with_a_published_at_date_are_published()
    {
        $publishedConcertA = factory(Concert::class)->create([
            'published_at' => Carbon::parse('-1 Week')
        ]);
        $publishedConcertB = factory(Concert::class)->create([
            'published_at' => Carbon::parse('-1 Week')
        ]);
        $unpublishedConcert = factory(Concert::class)->create([
            'published_at' => null
        ]);

        $publishedConcerts = Concert::published()->get();

        $this->assertTrue($publishedConcerts->contains($publishedConcertA));
        $this->assertTrue($publishedConcerts->contains($publishedConcertB));
        $this->assertFalse($publishedConcerts->contains($unpublishedConcert));
    }
}
