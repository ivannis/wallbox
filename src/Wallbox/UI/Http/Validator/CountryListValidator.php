<?php

declare(strict_types=1);

namespace Wallbox\UI\Http\Validator;

use Doblio\Core\ValueObject\Geography\CountryCode;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

class CountryListValidator
{
    private ValidatorFactoryInterface $validationFactory;

    public function __construct(ValidatorFactoryInterface $validationFactory)
    {
        $this->validationFactory = $validationFactory;
    }

    public function validate($attribute, $value, array $parameters)
    {
        if (is_string($value)) {
            $value = explode(',', $value);
        }

        if (!is_array($value)) {
            $value = [$value];
        }

        $rules = [
            'country' => 'required|string|in:'.implode(',', CountryCode::names())
        ];

        if (!empty($value)) {
            foreach ($value as $country) {
                $validator = $this->validationFactory->make(['country' => $country], $rules);

                if ($validator->fails()) {
                    return false;
                }
            }
        }

        return true;
    }
}
