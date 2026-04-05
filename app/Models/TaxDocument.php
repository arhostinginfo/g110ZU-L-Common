<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxDocument extends Model
{
    public $table = 'tax_documents';
    public $timestamps = true;

    protected $fillable = [
        'gp_name_in_url',
        'tax_type',
        'document_type',
        'file_path',
        'file_name',
        'is_active',
    ];

    public function isImage()
    {
        $ext = strtolower(pathinfo($this->file_name, PATHINFO_EXTENSION));
        return in_array($ext, ['jpg', 'jpeg', 'png']);
    }
}
