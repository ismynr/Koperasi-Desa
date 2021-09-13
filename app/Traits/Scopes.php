<?php

namespace App\Traits;

trait Scopes
{

    /**
     * Merging with() and whereHas() method models
     * 
     * @param mixed $query
     * @param mixed $relation
     * @param null $constraint
     * 
     * @return $query
     */
    public function scopeWithWhereHas($query, $relation, $constraint = null)
    {
        if($constraint){
            return $query->whereHas($relation, $constraint)
                     ->with([$relation => $constraint]);
        }

        return $query->whereHas($relation)
                     ->with($relation);
    }

}