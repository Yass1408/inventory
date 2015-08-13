<?php
require_once 'vendor/autoload.php';
use Maatwebsite\Excel\Excel;

Excel::create('Filename', function($excel) {

    // Set the title
    $excel->setTitle('Our new awesome title');

    // Chain the setters
    $excel->setCreator('Maatwebsite')
        ->setCompany('Maatwebsite');

    // Call them separately
    $excel->setDescription('A demonstration to change the file properties');

})->export('xls');