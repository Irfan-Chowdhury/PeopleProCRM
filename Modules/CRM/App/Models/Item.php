<?php

namespace Modules\CRM\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\CRM\Database\factories\ItemFactory;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'item_category_id',
        'title',
        'description',
        'unit_type',
        'rate',
        'is_client_visible',
        'image',
    ];

    public function itemCategory(): BelongsTo
    {
        return $this->belongsTo(ItemCategory::class);
    }
}
