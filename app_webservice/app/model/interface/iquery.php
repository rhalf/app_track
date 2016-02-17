<?php

interface IQuery
{
    public static function onSelect($get);
    public static function onInsert($post);
    public static function onUpdate($put);
    public static function onDelete($delete);

}


?>