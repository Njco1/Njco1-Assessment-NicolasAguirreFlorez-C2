<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'specialty_id'];

    // Relation with the user (doctor)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation with the appointments 
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // Relation with the specialty
    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }
}
