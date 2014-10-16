<?php
/**
 * Created by PhpStorm.
 * User: zerg
 * Date: 10/15/14
 * Time: 9:35 AM
 */


namespace Model;

use \stdClass;

class Data{
    private $db;
    private $data;
    public function __construct($db) {
        $this->db = $db;
        $this->data = json_decode(file_get_contents('php://input'));
        $this->requestData = &$_GET;
    }

    public function saveData() {

        $time = time();
        if (!empty($this->data->binary)) {
            $value = base64_decode($this->data->binary, true);
            $insert = "INSERT INTO binary_data (value, time)
                VALUES (:value, :time)";
        } else {
            $value = !empty($this->data->string) ? $this->data->string : '';
            $insert = "INSERT INTO string_data (value, time)
                VALUES (:value, :time)";
        }
        $stmt = $this->db->prepare($insert);

        $stmt->bindParam(':value', $value);
        $stmt->bindParam(':time', $time);

        $this->output($stmt->execute());
    }

    public function getData() {
        if (empty($this->requestData['search'])) {
            throw new \Exception('no search parameter');
        }
        $searchFor = $this->requestData['search'];
        $searchFor = sprintf('%%%s%%', $searchFor);
        $select = 'SELECT id, value, time FROM string_data WHERE value like :searchFor order by time limit 10';
        $stmt = $this->db->prepare($select);
        $stmt->bindParam(':searchFor', $searchFor);
        $stmt->execute();

        $this->output($stmt->fetchAll(\PDO::FETCH_ASSOC));
    }

    private function output($data) {
        echo json_encode(array('result'=>$data));
    }
}