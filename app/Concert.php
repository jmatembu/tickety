<?php

namespace App;

<<<<<<< HEAD
=======
use App\Order;
>>>>>>> 4c338e88d2c42489fe577a3df730c3475deb532b
use Illuminate\Database\Eloquent\Model;

class Concert extends Model
{
    protected $guarded = [];
<<<<<<< HEAD
=======

    protected $dates = ['date'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }
    /**
     * Formate date
     *
     * @return string
     */
    public function getFormattedDateAttribute()
    {
        return $this->date->format('F j, Y');
    }

    /**
     * Format start time
     *
     * @return string
     */
    public function getFormattedStartTimeAttribute()
    {
        return $this->date->format('g:ia');
    }

    /**
     * Format price
     *
     * @return void
     */
    public function getPriceInDollarsAttribute()
    {
        return number_format($this->price / 100, 2);
    }

    public function orderTickets($email, $ticketQuantity)
    {
        $order = $this->orders()->create(['email' => $email]);

        foreach (range(1, $ticketQuantity) as $i) {
            $order->tickets()->create([]);
        }

        return $order;
    }
>>>>>>> 4c338e88d2c42489fe577a3df730c3475deb532b
}
