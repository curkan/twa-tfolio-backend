<?php

declare(strict_types=1);

namespace App\Containers\Common\UploadImage\UI\Api\Requests;

use App\Ship\Parents\Requests\Request;

final class UploadImageRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        // return Gate::allows('update', Profile::find(Auth::id()));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'picture' => 'file|image|mimes:jpg,jpeg,png,gif|max:20480',
        ];
    }
}
