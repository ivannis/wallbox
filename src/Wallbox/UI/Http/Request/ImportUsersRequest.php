<?php

declare(strict_types=1);

namespace Wallbox\UI\Http\Request;

use Doblio\Core\ValueObject\Geography\CountryCode;
use Hyperf\Validation\Request\FormRequest;

class ImportUsersRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'limit' => 'integer',
            'async' => 'bool',
            'delay' => 'integer',
        ];
    }
}
