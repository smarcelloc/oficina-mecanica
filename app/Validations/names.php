<?php

Validator::extend('names', function ($attribute, $value) {
    return preg_match('/^[\pL\s]+$/u', $value); 
},'O :attribute deve ser apenas letras e espaços');