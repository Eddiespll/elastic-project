<?php

namespace App\Http\Controllers;
use App\Classes\ElasticIndex;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public $client;

	/**
     * @return void
     */
    public function __construct()
    {  

        die("teste");
       /*
        $indexSearch = new ElasticIndex('index_search'); 
        $indexTags = new ElasticIndex('index_tags');	
        $indexList = new ElasticIndex('index_list');


        if(!$indexSearch->exists()) $indexSearch->create();
        if(!$indexTags->exists()) $indexTags->create();
        if(!$indexList->exists()) $indexList->create();
        */
    }

    public function getQuery($name, $target, $search){

        include __DIR__."/../../../elasticsearch/queries.$name.php";

        return $queries[$target]; 
    }

}
