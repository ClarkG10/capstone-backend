<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Stock_out';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'stockOut_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['blood_type', 'component', 'rh_factor', 'units_out', 'inventory_id', 'user_id'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['stockOut_id', 'created_at', 'updated_at'];
}
