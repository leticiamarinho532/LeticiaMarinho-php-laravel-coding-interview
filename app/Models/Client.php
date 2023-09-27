<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = ['username', 'name', 'email', 'phone'];

    /**
     * Their dogs
     *
     * @return HasMany
     */
    public function dogs(): HasMany
    {
        return $this->hasMany(Dog::class);
    }

    /**
     * Their bookings
     *
     * @return HasMany
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
