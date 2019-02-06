<?php namespace model;

use DBRowW;
use ErrorException;

class Redirect {
    use DBRowW;

    static function new($redirect_url, $redirect_visitor) {
        global $_DATABASE;
        return $_DATABASE->prepare("
          INSERT INTO redirects (redirect_url, redirect_visitor) 
          VALUES (:redirect_url,  :redirect_visitor);
        ")->execute([
            'redirect_url' => $redirect_url,
            'redirect_visitor' => $redirect_visitor
        ]) ? $_DATABASE->lastInsertId() : null;
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
        return $_DATABASE->prepare("DELETE FROM visitors".implode("", $statement).";")->execute($params);
    }


    static function get_row($redirect_id) {
        global $_DATABASE;
        $stmt = $_DATABASE->prepare("
           SELECT *
           FROM redirects
           WHERE redirect_id = :redirect_id;
        ");
        $stmt->execute([
            'redirect_id' => $redirect_id
        ]);
        $fields = $stmt->fetch();
        return empty($fields) ? null : new Redirect($fields);
    }

    static function get_rows($options, $params) {
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
        $stmt = $_DATABASE->prepare("SELECT * FROM redirects".implode("", $statement).";");
        $stmt->execute($params);
        $rows = $stmt->fetchAll();
        array_walk($rows, function (&$row) {
            $row = new Redirect($row);
        });
        return $rows;
    }

    private $allow_update = [
        'redirect_disable'
    ];

    function save() {
        global $_DATABASE;

        $sql = "UPDATE Redirects";
        $params = [];
        foreach ($this->updates as $field) {
            $sql .= " {$field} = :{$field}";
            $params[$field] = $this->fields[$field];
        }
        $field = 'rewrite_id';
        $sql .= " WHERE {$field} = :{$field};";
        $params[$field] = $this->fields[$field];

        return $_DATABASE->prepare($sql)->execute($params);
    }


    function shift_redirect($client_id) {
        global $_DATABASE;
        return $_DATABASE->prepare("
          INSERT INTO redirectmeta (redirect_id, redirect_client) 
          VALUES (:redirect_id, :redirect_client);
        ")->execute([
            'redirect_id' => $this->fields['redirect_id'],
            'redirect_client' => $client_id
        ]) ? $_DATABASE->lastInsertId() : null;
    }

    function get_redirects($options = [], $params = []) {
        global $_DATABASE;
        $statement = [
            'where' => " WHERE redirect_id = :redirect_id", 'order' => "", 'limit' => ""
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
        $stmt = $_DATABASE->prepare("SELECT redirect_client, redirect_date FROM redirectmeta".implode("", $statement).";");
        $stmt->execute(array_merge($params, ['redirect_id' => $this->fields['redirect_id']]));
        return $stmt->fetchAll();
    }

}

