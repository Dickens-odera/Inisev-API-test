<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Website extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'websites';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'domain'
    ];

    /**
     * @return HasMany
     */
    public function subscribers(): HasMany
    {
        return $this->hasMany(Subscriber::class,'id','website_id');
    }
}
