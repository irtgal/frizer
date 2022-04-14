<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Term extends Model
{
    use HasFactory;

    protected $fillable = ['full_time', 'name', 'contact', 'reserved'];
    protected $appends = ['date', 'time'];


 
    public function getDateAttribute() {
        return Carbon::parse($this->full_time)->format('Y-m-d');
    }

    public function getTimeAttribute() {
        return Carbon::parse($this->full_time)->format('H:i');
    }

}
