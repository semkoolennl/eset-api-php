<?php


namespace Eset\Api\Resources;


class ObjectParser
{
    public function createArrayFromObject(object $object)
    {
        return $this->loopObject($object);
    }

    private function loopObject(object $object)
    {
        $array = get_object_vars($object);
        foreach ($array as $property => $value)
        {
            if (is_array($value))
            {
                $array[$property] = $this->loopArray($value);
            }
        }
        return $array;
    }

    private function loopArray(array $array)
    {
        $newArray = [];
        foreach ($array as $property => $value)
        {
            if (is_array($value))
            {
                $newArray[$property] = $this->loopArray($value);
            } else if (is_object($value))
            {
                $newArray[$property] = $this->createArrayFromObject($value);
            } else
            {
                $newArray[$property] = $value;
            }
        }
        return $newArray;
    }
}