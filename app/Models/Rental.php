<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

/**
 * 
 *
 * @property int $id
 * @property int $vehicle_id
 * @property int $customer_id
 * @property string $start_time
 * @property string|null $end_time
 * @property string|null $total_cost
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Customer $customer
 * @property-read \App\Models\Vehicle $vehicle
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rental newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rental newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rental query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rental whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rental whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rental whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rental whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rental whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rental whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rental whereTotalCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rental whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rental whereVehicleId($value)
 * @mixin \Eloquent
 */
class Rental extends Pivot
{
    protected $table = "rentals";

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function start_time(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format('d/m/Y H:i'),
        );
    }

    public function end_time(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? Carbon::parse($value)->format('d/m/Y H:i') : null,
        );
    }
}
