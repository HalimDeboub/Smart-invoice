<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceProduct extends Model
{
    protected $guarded= [];

    protected $table = "invoice_product";
    use HasFactory;



    public function product()
    {
       return $this->belongsTo(Product::class);
    }
}
