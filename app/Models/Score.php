<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Score extends Model {
    protected $guarded = [];
    public function student() {
        return $this->belongsTo(Student::class);
    }
    public function subIndicator() {
        return $this->belongsTo(SubIndicator::class);
    }
}