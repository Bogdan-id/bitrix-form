<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferUpdateRequest extends JsonRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
            return [
                'offer_id' => 'required|integer|exists:offers,id',
                'non_standart_comment' => 'string',
                'front_manager_comment' => 'string',
                'availability_leasing_object' => 'string',
                'supplier_prepayment' => 'string',
                'contact_name' => 'string',
                'contact_position' => 'string',
                'contact_phone' => 'string',
                'contact_email' => 'string',
                'service_agreement' => 'string',
                'fuel_card_agreement' => 'string',
                'signing_agreement_date' => 'string',
                'advance_payment_date' => 'string',
                'shipment_leasing_object' => 'string',
                'shipment_city' => 'string',
            ];
    }
}
