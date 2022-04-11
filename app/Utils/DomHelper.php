<?php

namespace App\Utils;

class DomHelper
{

    public function filterBody(string $body){

        $body = html_entity_decode($body, ENT_QUOTES, 'UTF-8');
        $body = strip_tags($body);
        $body = preg_replace( "/\r|\n/", "", $body);
        $body= preg_replace('/\t+/', ' ', $body);
        $body = preg_replace('/\s+/', ' ', $body);
        return trim($body);
    }

    public function filterPDF(string $content){
        return $this->tornaTextoPesquisavel($content);
    }

    public function filterTag(string $tag){
        $tag = strip_tags($tag);
        return trim($tag);
    }

    public function tornaTextoPesquisavel($texto){


        $texto = html_entity_decode($texto);
        $texto = trim($texto);
        $texto = strip_tags($texto);

        $texto = str_replace("_", " ", $texto); // transformo underline em espaço  
        $texto = str_replace(",", " ", $texto); 
        $texto = str_replace("\r"," ", $texto);  

        $texto = str_replace(";", "", $texto);
        $texto= str_replace(":","", $texto);
        $texto= str_replace("→","", $texto);
        
        $texto= str_replace("/","", $texto);
        $texto= str_replace("\\","", $texto);
        $texto= str_replace("*","", $texto);
       
        $texto = str_replace('"', "", $texto);
        $texto = str_replace('“', "", $texto);
        $texto = str_replace('”', "", $texto);
        $texto = str_replace("'", "", $texto);
        $texto = str_replace("(", "", $texto);
        $texto = str_replace(")", "", $texto);
        $texto = str_replace(">", "", $texto);
        $texto = str_replace("<", "", $texto);
        $texto = str_replace("HTTP:WWW", "", $texto);
        $texto = str_replace("§", "", $texto);
        $texto = str_replace("?", "", $texto);
        $texto = str_replace("+", "", $texto);
        $texto = str_replace("#", "", $texto);
        $texto = str_replace("$", "", $texto);
        $texto = str_replace("@", "", $texto);

        return trim($texto);
    }
}
