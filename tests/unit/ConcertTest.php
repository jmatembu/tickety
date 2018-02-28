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
        // Create a concert with a known date
        $concert = factory(Concert::class)->create([
            'date' => Carbon::parse('2018-02-28 8:00pm')
        ]);
        
        // Retrieve the formatted date
        $date = $concert->formatted_date;

        // Verify the date is formatted as expected
        $this->assertEquals('February 28, 2018', $date);
    }
}
