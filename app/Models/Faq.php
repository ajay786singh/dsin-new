<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{

    protected $fillable= ['categoryname','categoryslug','metakeywords','metadescription'];
    use HasFactory;
}
