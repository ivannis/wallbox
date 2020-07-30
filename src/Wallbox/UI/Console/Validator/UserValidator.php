<?php

declare(strict_types=1);

namespace Wallbox\UI\Console\Validator;

use Common\Infrastructure\Hyperf\Validation\Validator;
use Doblio\Core\ValueObject\Geography\CountryCode;

class UserValidator extends Validator
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'id' => 'required|integer',
            'name' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|email',
            'country' => 'required|string|in:'.implode(',', CountryCode::names()),
            'createAt' => 'required|date_format:Y-m-d',
            'activateAt' => 'required|date_format:Y-m-d',
            'chargerId' => 'required|integer',
        ];
    }
}
