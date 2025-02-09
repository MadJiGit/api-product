<?php

include_once "Methods.php";

class EnumMethods
{
    /**
     * @return string
     */
    public static function getMethodsResource(): string
    {
        return implode(', ', (array_column(MethodsResource::cases(), 'value')));
    }

    /**
     * @return string
     */
    public static function getMethodsRequests(): string
    {
        return implode(', ', (array_column(MethodsRequest::cases(), 'value')));
    }
}
