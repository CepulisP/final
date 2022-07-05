<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    public function type()
    {
        return $this->hasOne(InvoiceType::class, 'id', 'type_id');
    }

    public function seller_bank()
    {
        return $this->hasOne(Bank::class, 'id', 'seller_bank_id');
    }

    public function client()
    {
        return $this->hasOne(Client::class, 'id', 'client_id');
    }

    public function currency()
    {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }
}
