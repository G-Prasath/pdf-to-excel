<?php
set_time_limit(300);

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Utils;

$pdf_file_path = './emailPdfs.pdf';  // Corrected file path

// Check if the file exists
if (!file_exists($pdf_file_path)) {
    die("File does not exist: $pdf_file_path");
}

$client = new Client();
$headers = [
    'Api-Key' => 'da097676-1ced-4d04-8df2-2ecb869d6b74'
];
$options = [
    'multipart' => [
        [
            'name' => 'file',
            'contents' => Utils::tryFopen($pdf_file_path, 'r'),
            'filename' => basename($pdf_file_path),
            'headers'  => [
                'Content-Type' => 'application/pdf'  // Corrected Content-Type
            ]
        ],
        [
            'name' => 'output',
            'contents' => 'xlsx'  // Changed to 'xlsx' as the API expects format, not a file
        ]
    ]
];

$request = new Request('POST', 'https://api.pdfrest.com/excel', $headers);
$res = $client->sendAsync($request, $options)->wait();
echo $res->getBody();
