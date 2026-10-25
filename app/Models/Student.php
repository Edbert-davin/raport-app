<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Student extends Model {
    protected $guarded = [];
    
    // Relasi ke akun User
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }
    public function scores() {
        return $this->hasMany(Score::class);
    }
    public function descriptions() {
        return $this->hasMany(StudentDescription::class);
    }
}