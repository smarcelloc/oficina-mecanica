<?php

Validator::extend('password', function ($attribute, $value) {
    return preg_match('/^(?=.*[\pNd])(?=.*[\pL])(?=.*[^\pNd^\pL]).{0,}$/i', $value);
}, 'O campo :attribute deve ter letras, números e símbolos especiais');
