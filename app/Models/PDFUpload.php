<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PDFUpload extends Model
{
    public $table = 'pdfview';
    public $timestamps = true;

   protected $fillable = ['name','attachment','type_attachment'
                            ,'gp_name_in_url',
                            'gp_user_id'];

}
