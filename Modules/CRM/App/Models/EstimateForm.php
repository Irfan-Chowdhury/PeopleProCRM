<?php

namespace Modules\CRM\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\CRM\Database\factories\EstimateFormFactory;

class EstimateForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'status',
        'is_public',
        'description'
    ];
}
