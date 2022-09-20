<?php

namespace Asciisd\Zoho\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property string zohoable_type
 * @property int zohoable_id
 * @property string zoho_id
 */
class Zoho extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'zohoable_type', 'zohoable_id', 'zoho_id',
    ];

    /**
     * Get the owning zohoable model.
     */
    public function zohoable(): MorphTo
    {
        return $this->morphTo();
    }
}
