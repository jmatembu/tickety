<?php

namespace Tests\Feature;

use App\Concert;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewConcertListingTest extends TestCase
{
    /**
     * @test
     */
    function user_can_view_a_concert_listing()
    {
        // Arrange
        // Create a concert for a user to view
        $concert = Concert::create([
            'title' => 'The Red Chord',
            'subtitle' => 'with Animosity and Lethargy',
            'date' => Carbon::parse('February 28, 2018 8:00pm'),
            'price' => 3250,
            'venue' => 'The Mosh Pit',
            'address' => '123 Example Lane',
            'city' => 'Laraville',
            'state' => 'ON',
            'zip' => '17916',
            'additional_information' => 'For tickets, call (080) 000-0000',
        ]);

        // Act and Assert
        // View a concert listing
        $this->visit('/concerts/' . $concert->id);

        // Assert
        // See concert listing
        $this->see('The Red Chord');
        $this->see('with Animosity and Lethargy');
        $this->see('February 28, 2018');
        $this->see('8:00pm');
        $this->see('32.50');
        $this->see('The Mosh Pit');
        $this->see('123 Example Lane');
        $this->see('Laraville');
        $this->see('ON');
        $this->see('17916');
        $this->see('For tickets, call (080) 000-0000');
    }
}
