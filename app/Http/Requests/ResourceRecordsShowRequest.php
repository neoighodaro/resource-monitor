<?php

namespace App\Http\Requests;

use Exception;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class ResourceRecordsShowRequest extends FormRequest
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
            //
        ];
    }

    /**
     * Get the start date from the request.
     *
     * @return Carbon
     */
    public function startDate() : Carbon
    {
        try {
            $startDate = Carbon::parse($this->get('start'))->startOfDay();

            if ($startDate->gte($this->endDate())) {
                throw new Exception("Start date cannot be after the end date!");
            }

            return $startDate;
        } catch (Exception $e) {
            return Carbon::now()->startOfDay();
        }
    }

    /**
     * Get the end date from the request.
     *
     * @return Carbon
     */
    public function endDate() : Carbon
    {
        try {
            return Carbon::parse($this->get('end'))->endOfDay();
        } catch (Exception $e) {
            return Carbon::now()->endOfDay();
        }
    }

    /**
     * Check if its a valid date range
     *
     * @return bool
     */
    protected function validDate() : bool
    {
        return $this->startDate()->lt($this->endDate());
    }
}
