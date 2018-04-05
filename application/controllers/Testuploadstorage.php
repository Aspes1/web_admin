<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Google\Cloud\Storage\StorageClient;
use League\Flysystem\Filesystem;
use Superbalist\Flysystem\GoogleStorage\GoogleStorageAdapter;

class Testuploadstorage extends CI_Controller{
    public function __construct()
    {
      parent::__construct();
    }

    public function index(){

        $storageClient = new StorageClient([
            'projectId'   => 'ascendant-volt-161906',
            'keyFilePath' => APPPATH. '/libraries/json_key.json',
        ]);
        
        $bucket     = $storageClient->bucket('payinm_db');

        $adapter    = new GoogleStorageAdapter($storageClient, $bucket);
        $filesystem = new Filesystem($adapter);


        // $stream = fopen(APPPATH. '/libraries/data/stcloud.txt', 'r+'); 
        // $filesystem->writeStream('backups/stcloud.txt', $stream);

        /*  Read the docs
         *  http://flysystem.thephpleague.com/api/ 
         */

        // Write or Update Files

        // $filesystem->put('path/to/file.txt', 'contents');
        // Read Files

        // $contents = $filesystem->read('path/to/file.txt');
        // Check if a file exists

        // $exists = $filesystem->has('path/to/file.txt');

        $exists = $filesystem->has('backups/stcloud1.txt');
        print_r($exists);

    }
}