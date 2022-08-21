<?php

namespace App\Http\Requests\Template;

use App\Http\Requests\BaseRequest;

class StoreRequest extends BaseRequest
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
                'required',
                function ($attribute, $value, $fail) {
                    $content_size = strlen($value);
                    if ($content_size > 20000000) {
                        return $fail('Nội dung quá lớn');
                    }
                },
            ],
            'date' => [
                'nullable'
            ],
            'time' => [
                'nullable'
            ],
            'cron_time' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (
                        (empty($attribute) && empty($this->time) && empty($this->date)) ||
                        (empty($attribute) && empty($this->date)) ||
                        (empty($attribute) && empty($this->time))
                    ) {
                        return $fail('Thời gian không hợp lệ');
                    }
                },
            ]
        ];

    }
}
