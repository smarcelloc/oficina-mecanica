<?php

return [

    'ADMIN_PATH' => 'admin',

    'USER_TABLE' => 'cms_users',

    'UPLOAD_TYPES' => 'jpg,png,jpeg,gif,bmp',

    'DEFAULT_THUMBNAIL_WIDTH' => 0,

    'DEFEAULT_UPLOAD_MAX_SIZE' => 1000, //in KB

    'IMAGE_EXTENSIONS' => 'jpg,png,jpeg,gif,bmp',

    'MAIN_DB_DATABASE' => env('DB_DATABASE'), //Very useful if you use config:cache

    'MULTIPLE_DATABASE_MODULE' => [],

    /*
    * NOTE :
    * Make sure yo clear your config cache by using command : php artisan config:clear
    */
];