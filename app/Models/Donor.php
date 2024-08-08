<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'donors';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'donor_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['fullname', 'birthday', 'gender', 'age', 'address', 'email', 'phonenumber', 'blood_type', 'medical_history', 'current_medications', 'allergies', 'previous_donation', 'emergency_name', 'emergenncy_relationship', 'emergenncy_phonenumber', 'status'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['donor_id', 'created_at', 'updated_at'];
}
