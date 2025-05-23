<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Loan extends Model
{
    use HasUuids;

    protected $guarded = ['id'];

    public $incrementing = false;

    protected $keyType = 'string';

    public function book()
    {
        return $this->belongsTo(Book::class)->withTrashed();
    }

    public function member()
    {
        return $this->belongsTo(Member::class)->withTrashed();
    }

    protected function casts()
    {
        return [
            'borrow_date' => 'datetime',
            'due_date' => 'datetime',
            'return_date' => 'datetime',
        ];
    }
}
