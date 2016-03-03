<?php

interface IQuery
{
    public static function onSelect(Url $url, $get);
    public static function onInsert(Url $url, $post);
    public static function onUpdate(Url $url, $put);
    public static function onDelete(Url $url, $delete);

}


?>