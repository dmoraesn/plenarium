<?php

return [

    'pdf' => [
        'enabled' => true,
        // Pode deixar hardcoded ou via .env; escolha uma das linhas abaixo:
        // 'binary' => 'C:/Program Files/wkhtmltopdf/bin/wkhtmltopdf.exe',
        'binary' => env('WKHTMLTOPDF_BINARY', 'C:/Program Files/wkhtmltopdf/bin/wkhtmltopdf.exe'),
        'timeout' => 120,
        'options' => [
            'encoding' => 'utf-8',
        ],
        'env' => [],
    ],

    'image' => [
        'enabled' => true,
        // 'binary' => 'C:/Program Files/wkhtmltopdf/bin/wkhtmltoimage.exe',
        'binary' => env('WKHTMLTOIMAGE_BINARY', 'C:/Program Files/wkhtmltopdf/bin/wkhtmltoimage.exe'),
        'timeout' => 120,
        'options' => [],
        'env' => [],
    ],

];
