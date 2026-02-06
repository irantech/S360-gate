<?php

require_once ('./resource/resource.php');

abstract class resourceAbstract extends resource
{
    abstract function collection($inner_data);
}