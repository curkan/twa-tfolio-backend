<?php

declare(strict_types=1);

namespace App\Containers\Common\Node\UI\Api\Requests;

use App\Ship\Parents\Models\Node;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Facades\Gate;

final class UpdateNodeRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $node = Node::findOrFail($this->route('id'));

        return Gate::allows('update', [Node::class, $node]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'description' => 'max:2200',
        ];
    }
}
