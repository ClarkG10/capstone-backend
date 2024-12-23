<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stock_in';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'stockIn_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['blood_type', 'component', 'rh_factor', 'units_in', 'inventory_id', 'reserveBlood_id', 'user_id'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['stockIn_id', 'created_at', 'updated_at'];
}
