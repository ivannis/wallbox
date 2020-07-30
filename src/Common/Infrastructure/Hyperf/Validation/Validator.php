<?php

declare(strict_types=1);

namespace Common\Infrastructure\Hyperf\Validation;

use Hyperf\Validation\Contract\ValidatorFactoryInterface;

abstract class Validator
{
    private array $errors = [];
    private ValidatorFactoryInterface $validationFactory;

    public function __construct(ValidatorFactoryInterface $validationFactory)
    {
        $this->validationFactory = $validationFactory;
    }

    public function isValid(array $payload): bool
    {
        $this->errors = [];
        $validator = $this->validationFactory->make(
            $payload,
            $this->rules()
        );

        if ($validator->fails()){
            foreach ($validator->errors()->keys() as $key) {
                if ($validator->errors()->has($key)) {
                    $this->errors[$key] = $validator->errors()->get($key);
                }
            }

            return false;
        }

        return true;
    }

    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    abstract public function rules(): array;
}
