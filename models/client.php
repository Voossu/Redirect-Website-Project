<?php namespace model;

use DBRowR;
use ErrorException;

class Client {
    use DBRowR;

    static function new($client_key, $client_agent, $client_ip) {
        global $_DATABASE;
        $_DATABASE->beginTransaction();
        $client_id = $_DATABASE->prepare("
          INSERT INTO clients (client_key, client_agent) 
          VALUES (:client_key, :client_agent);
        ")->execute([
            'client_key' => $client_key,
            'client_agent' => $client_agent
        ]) ? $_DATABASE->lastInsertId() : null;
        $_DATABASE->prepare("
          INSERT INTO clientip (client_id, client_ip) 
          VALUES (:client_id, :client_ip);
        ")->execute([
            'client_id' => $client_id,
            'client_ip' => $client_ip
        ]);
        $_DATABASE->commit();
        return $client_id;
    }

    static function delete($options, $params) {
        global $_DATABASE;
        $statement = [
            'where' => "", 'limit' => ""
        ];
        if (is_array($options)) {
            foreach ($options as $key => $value) {
                switch (strtolower($key)) {
                    case 'where':
                        $statement['where'] = " WHERE " . $value;
                        break;
                    case 'limit':
                        $statement['limit'] = " LIMIT " . $value;
                        break;
                    default:
                        throw new ErrorException("Invalid keyword \"{$key}\" in the query.");
                        break;
                }
            }
        }
        return $_DATABASE->prepare("DELETE FROM clients".implode("", $statement).";")->execute($params);
    }


    static function get_row($client_id) {
        global $_DATABASE;
        $stmt = $_DATABASE->prepare("
           SELECT * FROM clients
           WHERE client_id = :client_id;
        ");
        $stmt->execute([
            'client_id' => $client_id
        ]);
        $fields = $stmt->fetch();
        return empty($fields) ? null : new Client($fields);
    }

    static function get_rows($options = [], $params = []) {
        global $_DATABASE;
        $statement = [
            'where' => "", 'order' => "", 'limit' => ""
        ];
        if (is_array($options)) {
            foreach ($options as $key => $value) {
                switch (strtolower($key)) {
                    case 'where':
                        $statement['where'] = " WHERE " . $value;
                        break;
                    case 'order':
                        $statement['order'] = " ORDER BY " . $value;
                        break;
                    case 'limit':
                        $statement['limit'] = " LIMIT " . $value;
                        break;
                    default:
                        throw new ErrorException("Invalid keyword \"{$key}\" in the query.");
                        break;
                }
            }
        }
        $stmt = $_DATABASE->prepare("SELECT * FROM clients".implode("", $statement).";");
        $stmt->execute($params);
        $rows = $stmt->fetchAll();
        array_walk($rows, function (&$row) {
            $row = new Client($row);
        });
        return $rows;
    }


    function add_ip($client_ip) {
        global $_DATABASE;
        return $_DATABASE->prepare("
          INSERT INTO clientip (client_id, client_ip) 
          VALUES (:client_id, :client_ip);
        ")->execute([
            'client_id' => $this->fields['client_id'],
            'client_ip' => $client_ip
        ]);
    }

    function get_ip_list($options = [], $params = []) {
        global $_DATABASE;
        $statement = [
            'where' => " WHERE client_id = :client_id", 'order' => "", 'limit' => ""
        ];
        if (is_array($options)) {
            foreach ($options as $key => $value) {
                switch (strtolower($key)) {
                    case 'where':
                        $statement['where'] .= " AND " . $value;
                        break;
                    case 'order':
                        $statement['order'] = " ORDER BY " . $value;
                        break;
                    case 'limit':
                        $statement['limit'] = " LIMIT " . $value;
                        break;
                    default:
                        throw new ErrorException("Invalid keyword \"{$key}\" in the query.");
                        break;
                }
            }
        }
        $stmt = $_DATABASE->prepare("SELECT client_ip, client_date FROM clientip".implode("", $statement).";");
        $stmt->execute(array_merge($params, ['client_id' => $this->fields['client_id']]));
        return $stmt->fetchAll();
    }

}