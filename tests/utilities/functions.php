<?php

function create($class, $attributes=[], $count = null)
{
    return $class::factory($count)->create($attributes);
}

function make($class, $attributes=[], $count = null)
{
    return $class::factory($count)->make($attributes);
}
