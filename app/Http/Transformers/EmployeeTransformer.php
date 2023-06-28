<?php

namespace App\Http\Transformers;

/**
 * Class EmployeeTransformer
 *
 * @package \App\Http\Transformers
 */
class EmployeeTransformer extends Transformer
{
    protected $skillTransformer;

    public function __construct(SkillTransformer $skillTransformer) {
        $this->skillTransformer = $skillTransformer;
    }

    public function transform($employee) : array
    {
        return [
            'id' => $employee->id,
            'name' => $employee->name,
            'email' => $employee->email,
            'position' => $employee->position,
            'dateOfBirth' => $employee->date_of_birth,
            'address' => $employee->address,
            'skills' => $this->skillTransformer->transformCollection($employee->skills)
        ];
    }
}
