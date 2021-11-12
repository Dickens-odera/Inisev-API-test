<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSubscriptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => ['string','required','min:3','max:10'],
            'last_name'  => ['string','required','min:3','max:10'],
            'email'      => ['email','required','unique:subscribers','min:4','max:60'],
            'website_id' => ['required','integer','exists:websites,id','not_in:0']
        ];
    }
}
