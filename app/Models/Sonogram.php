<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sonogram extends Model
{
    use HasFactory;

    protected $id = 'sonogramID';
    protected $table = 'sonograms';

    protected $fillable = [
        'sonogramID',
        'userID',
        'petName',
        "imagePath",
        "status",
        "approver",
    ];
}
