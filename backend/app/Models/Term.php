<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Term extends Model
{
    use HasFactory;

    protected $fillable = ['full_time', 'name', 'type', 'contact', 'reserved', 'admin_id'];
    protected $appends = ['date', 'time'];

    protected static function boot() {
        parent::boot();
        static::deleting(function($term) {
            if ($term->reserved) {
                send_mail_cancellation($term);
            }
  
        });
    }


 
    public function getDateAttribute() {
        return Carbon::parse($this->full_time)->format('Y-m-d');
    }

    public function getTimeAttribute() {
        return Carbon::parse($this->full_time)->format('H:i');
    }

    public function service_type()
    {
        return $this->belongsTo(Type::class, 'type');
    }

}
