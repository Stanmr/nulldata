<?php

namespace App\Http\Transformers;

use Illuminate\Database\Eloquent\Model;

abstract class Transformer
{
    public function transformCollection($items)
    {
        return (clone $items)
            ->transform(function ($item, $key){
                return $this->transform($item);
            })
            ->toArray();
    }

    public abstract function transform(Model $item);
}
