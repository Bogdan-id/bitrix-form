<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'non_standart_comment',
        'front_manager_comment',
        'availability_leasing_object',
        'supplier_prepayment',
        'contact_name',
        'contact_position',
        'contact_phone',
        'contact_email',
        'service_agreement',
        'fuel_card_agreement',
        'signing_agreement_date',
        'advance_payment_date',
        'shipment_leasing_object',
        'shipment_city',
     ];
}
