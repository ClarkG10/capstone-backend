<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationHistory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'donation_history';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'donationhistory_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['units', 'component', 'even_name', 'comments', 'donation_date', 'donor_id'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['donationhistory_id', 'created_at', 'updated_at'];
}
