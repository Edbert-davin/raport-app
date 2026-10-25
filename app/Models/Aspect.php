<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Aspect extends Model {
    protected $guarded = [];
    public function subIndicators() {
        return $this->hasMany(SubIndicator::class);
    }
    public function templates() {
        return $this->hasMany(DescriptionTemplate::class);
    }
}