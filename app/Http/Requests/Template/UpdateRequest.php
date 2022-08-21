<?php

namespace App\Http\Requests\Template;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'title' => [
                'required',
            ],
            'sender' => [
                'required',
            ],
            'content' => [
                'required'
            ],
            'date' => [
                'nullable'
            ],
            'time' => [
                'nullable'
            ],
            'repeat_time' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (
                        (empty($this->repeat_time) && empty($this->time) && empty($this->date)) ||
                        (empty($this->repeat_time) && empty($this->date)) ||
                        (empty($this->repeat_time) && empty($this->time))
                    ) {
                        return $fail('Thời gian không hợp lệ');
                    }
                },
            ],
            'banner' => [
                'nullable',
            ],
        ];
    }
}
