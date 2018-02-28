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
        $concert = factory(Concert::class)->create([
            'date' => Carbon::parse('2018-02-28 8:00pm')
        ]);

        $this->assertEquals('February 28, 2018', $concert->formatted_date);
    }

    /**
     * @test
     */
    public function can_get_formatted_start_time()
    {
        $concert = factory(Concert::class)->create([
            'date' => Carbon::parse('2018-02-28 20:00:00')
        ]);

        $this->assertEquals('8:00pm', $concert->formatted_start_time);
    }
}
