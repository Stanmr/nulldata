<?php

namespace App\Http\Transformers;

/**
 * Class SkillTransformer
 *
 * @package \App\Http\Transformers
 */
class SkillTransformer extends Transformer
{

    public function transform($skill) : array
    {
        return [
            'id' => $skill->id,
            'name' => $skill->name,
            'level' => $skill->pivot->level
        ];
    }
}
