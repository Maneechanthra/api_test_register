<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


    $app->get('/user',function(Request $request, Response $response){
        $conn = $GLOBALS['connect'];
        $sql = 'SELECT * FROM account';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = array();
        foreach($result as $row){
            array_push($data, $row);
        }

        $response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK));
        return $response->withHeader('Content-Type', 'application/json; charset=utf-8')->withStatus(200);
    });

    $app->post('/user', function (Request $request, Response $response, $args) {
        $json = $request->getBody();
        $jsonData = json_decode($json, true);
        $conn = $GLOBALS['connect'];
        
        // Corrected SQL query
        $sql = "INSERT INTO `account`(`fname`, `lname`, `email`, `password`, `tel_number`) VALUES (?,?,?,?,?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssss', $jsonData['fname'], $jsonData['lname'], $jsonData['email'], $jsonData['password'], $jsonData['tel_number']);
        $stmt->execute();
    
        $affected = $stmt->affected_rows;
        if ($affected > 0) {
            $data = ["affected_rows" => $affected, "last_idx" => $conn->insert_id];
            $response->getBody()->write(json_encode($data));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        }
    });
