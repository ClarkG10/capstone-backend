<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Donor extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

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
    protected $fillable = ['email', 'password', 'fullname', 'birthday', 'gender', 'age', 'address', 'email_address', 'phonenumber', 'blood_type', 'medical_history', 'current_medications', 'allergies', 'previous_donation', 'emergency_name', 'emergency_relationship', 'emergency_phonenumber', 'status', 'user_id'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['donor_id', 'created_at', 'updated_at'];
}
