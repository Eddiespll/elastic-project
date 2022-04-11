<?php

$queries = array(

	'query' => array(
		'function_score' => [  

		    "query"=>[
		       	"bool"=> [

		            "must"=> [

		                'multi_match' => [
		                    "query" => $search,
		                    "fields" => ["title", "main_content","conteudo_pdf"],
		                    "fuzziness" => 1,
							"prefix_length"=>3,
		                    "analyzer" => "analyzer_brazilian",
		                ]
		            ],

		            "should"=> [

		                'multi_match' => [
		                    "query" => $search,
		                    "fields" => ["title", "main_content","conteudo_pdf"],
		                    "type"=>'phrase',
		                    "slop"=>2,
		                    "analyzer" => "analyzer_brazilian",
		                ]
		            ]
		        ]
		    ],

		    "script_score"=>[
		        'script' => [
		            'source' => " _score * (1  +(doc['popularidade'].value*0.01))"
		        ]
		    ],
	     	'boost_mode' => 'replace'
		]
	),


   'highlight' => array(

   		"max_analyzed_offset" => 1000000,
   	    "pre_tags" => ["<b>"],
   		"post_tags" => ["</b>"],
    	"order"=> "score",
        "fields"=> [
      		"main_content"=> [
      			"type"=> "fvh",
        		"fragment_size"=> 300,
        	//"fragment_offset" => 100,
        		"no_match_size" => 300,
        		"number_of_fragments"=> 1,
        		"highlight_query"=> [
          			"bool"=> [
           				"must"=> [
              				"match"=> [
                				"main_content"=> [
                  					"query"=> $search,
                  					"fuzziness" => 1,
                  					"prefix_length"=>3,
                  					"analyzer" => "analyzer_brazilian",
                				]
              				]
            			],
            
	            		"should"=> [
		                	"match_phrase"=> [
		                		"main_content"=> [
		                  			"query"=> $search,
		                  			"slop"=> 1,
		                  			"boost"=> 10.0,
		                  			"analyzer" => "analyzer_brazilian"
	                			]
	              			]
	            		],
            			"minimum_should_match"=> 0
            		]
            	]
            ],

      		"conteudo_pdf"=> [
      			"type"=> "fvh",
        		"fragment_size"=> 300,
        	//"fragment_offset" => 100,
        		//"no_match_size" => 250,
        		"number_of_fragments"=> 1,
        		"highlight_query"=> [
          			"bool"=> [
           				"must"=> [
              				"match"=> [
                				"conteudo_pdf"=> [
                  					"query"=> $search,
                				]
              				]
            			],
            
	            	"should"=> [
	                	"match_phrase"=> [
	                		"conteudo_pdf"=> [
	                  			"query"=> $search,
	                  			"slop"=> 1,
	                  			"boost"=> 10.0
                			]
              			]
            		],
            		
            		"minimum_should_match"=> 0
            		]
            	]
            ]

        ]
    ),
);