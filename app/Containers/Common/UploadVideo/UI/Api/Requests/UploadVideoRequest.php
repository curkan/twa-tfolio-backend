<?php

declare(strict_types=1);

namespace App\Containers\Common\UploadVideo\UI\Api\Requests;

use App\Ship\Parents\Requests\Request;

final class UploadVideoRequest extends Request
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'file' => 'required|file|max:35000',
        ];
    }
}
