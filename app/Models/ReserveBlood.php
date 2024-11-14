<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReserveBlood extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reserve_blood';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'reserveBlood_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['blood_type', 'rh_factor', 'component', 'avail_blood_units', 'user_id'];

    // Define relationship to stock_in table
    public function stockIn()
    {
        return $this->hasMany(StockIn::class, 'reserveBlood_id');
    }

    // Define relationship to stock_out table
    public function stockOut()
    {
        return $this->hasMany(StockOut::class, 'reserveBlood_id');
    }

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['reserveBlood_id', 'created_at', 'updated_at'];
}
