<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
   // protected $guarded = [];

    protected $fillable = [
        'Product_name',
        'description',
        'section_id'
    ];

    public function sections()
    {
        return $this->belongsTo('App\sections','section_id','id');
        //return $this->belongsTo('App\sections');
    }
}
