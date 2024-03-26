<?php

namespace Modules\CRM\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\CRM\Database\factories\LeadFileFactory;

class LeadFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
		'file_title',
        'file_attachment',
        'file_description',
	];
}
