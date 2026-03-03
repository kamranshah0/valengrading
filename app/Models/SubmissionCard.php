<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionCard extends Model
{
    protected $fillable = [
        'submission_id',
        'qty',
        'brand',
        'title',
        'set_name',
        'year',
        'card_number',
        'variant',
        'lang',
        'notes',
        'label_type_id',
        'status',
        'admin_notes',
        'cert_number',
        'grade',
        'centering',
        'corners',
        'edges',
        'surface',
        'grading_insights',
        'grading_image',
        'back_image',
        'qr_code_token',
        'is_revealed',
        'grading_report_path',
        'certified_attributes',
    ];

    protected $casts = [
        // No casts needed for certified_attributes since it's a comma-separated string
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function labelType()
    {
        return $this->belongsTo(LabelType::class);
    }
}
