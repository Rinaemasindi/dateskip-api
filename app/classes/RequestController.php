<?php
require 'UserPreferences.php';
class RequestController
{
    public function __construct(private $method, private $resource, private $id)
    {
    }
    function processRequest()
    {
        switch ($this->resource) {
            case 'settings':
                $userPreferences = new UserPreferences();
                if ($this->method == "GET") {
                    
                    echo json_encode([
                        "results" => $userPreferences->getUserPreferences($this->id),
                    ]); 

                }if($this->method == "POST"){
                    
                    $data = $_POST;
                    echo json_encode([
                        "results" => $userPreferences->updateUserPrefences($this->id , $data),
                    ]);

                }else{

                }

                break;
            case 'reportuser':

                break;
            case 'notifications':

                break;
        }
    }
}