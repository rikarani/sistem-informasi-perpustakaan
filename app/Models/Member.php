<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory, HasUuids, Prunable, SoftDeletes;

    protected $guarded = ['id'];

    public $incrementing = false;

    protected $keyType = 'string';

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
