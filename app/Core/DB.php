<?php
require_once 'app/Config/DBC.php';

class DB extends DBC
{
    private static $_instance = [0 => null];
    private $mysqli;
    private $db_name, $db_user, $db_pass;

    public function __construct($db = 0)
    {
        $this->db_name = DBC::dbm[$db]['db'];
        $this->db_user = DBC::dbm[$db]['user'];
        $this->db_pass = DBC::dbm[$db]['pass'];
        $this->mysqli = new mysqli(DBC::db_host, $this->db_user, $this->db_pass, $this->db_name) or die('DB Error');
    }

    public static function getInstance($db = 0)
    {
        if (!isset(self::$_instance[$db])) {
            self::$_instance[$db] = new DB($db);
        }

        return self::$_instance[$db];
    }

    public function get($table, $index, $group)
    {
        $reply = [];
        $query = "SELECT * FROM $table";
        $result = $this->mysqli->query($query);

        if ($result) {
            $no = 0;
            while ($row = $result->fetch_assoc())
                if ($index == "") {
                    $reply[] = $row;
                } else {
                    if ($group == 0) {
                        $reply[$row[$index]] = $row;
                    } else {
                        $no += 1;
                        $reply[$row[$index]][$no] = $row;
                    }
                }
        }

        return $reply;
    }

    public function get_where($table, $where, $index, $group)
    {
        $reply = [];
        $query = "SELECT * FROM $table WHERE $where";
        $result = $this->mysqli->query($query);

        if ($result) {
            $no = 0;
            while ($row = $result->fetch_assoc())
                if ($index == "") {
                    $reply[] = $row;
                } else {
                    if ($group == 0) {
                        $reply[$row[$index]] = $row;
                    } else {
                        $no += 1;
                        $reply[$row[$index]][$no] = $row;
                    }
                }
        }

        return $reply;
    }

    public function get_cols($table, $cols, $row = 1, $index = "")
    {
        $reply = [];
        $query = "SELECT $cols FROM $table";
        $result = $this->mysqli->query($query);
        if ($result) {
            switch ($row) {
                case "0":
                    $reply = $result->fetch_assoc();
                case "1";
                    while ($row = $result->fetch_assoc())
                        if ($index == "")
                            $reply[] = $row;
                        else
                            $reply[$row[$index]] = $row;
                    break;
            }

            if (is_array($reply)) {
                return $reply;
            } else {
                return [];
            }
        } else {
            return array('query' => $query, 'error' => $this->mysqli->error, 'errno' => $this->mysqli->errno);
        }
    }

    public function get_cols_where($table, $cols, $where, $row = 1, $index = "")
    {
        $reply = [];
        $query = "SELECT $cols FROM $table WHERE $where";
        $result = $this->mysqli->query($query);
        if ($result) {
            switch ($row) {
                case "0":
                    $reply = $result->fetch_assoc();
                case "1";
                    while ($row = $result->fetch_assoc())
                        if ($index == "")
                            $reply[] = $row;
                        else
                            $reply[$row[$index]] = $row;
                    break;
            }

            if (is_array($reply)) {
                return $reply;
            } else {
                return [];
            }
        } else {
            return array('query' => $query, 'error' => $this->mysqli->error, 'errno' => $this->mysqli->errno);
        }
    }

    public function get_cols_groubBy($table, $cols, $groupBy)
    {
        $reply = [];
        $query = "SELECT $cols FROM $table GROUP BY $groupBy";
        $result = $this->mysqli->query($query);

        while ($row = $result->fetch_assoc())
            $reply[] = $row;

        return $reply;
    }

    public function get_order($table, $order)
    {
        $reply = [];
        $query = "SELECT * FROM $table ORDER BY $order";
        $result = $this->mysqli->query($query);

        while ($row = $result->fetch_assoc())
            $reply[] = $row;

        return $reply;
    }


    public function get_where_order($table, $where, $order)
    {
        $reply = [];
        $query = "SELECT * FROM $table WHERE $where ORDER BY $order";
        $result = $this->mysqli->query($query);

        while ($row = $result->fetch_assoc())
            $reply[] = $row;

        return $reply;
    }

    public function get_where_row($table, $where)
    {
        $reply = [];
        $query = "SELECT * FROM $table WHERE $where";
        $result = $this->mysqli->query($query);
        $reply = $result->fetch_assoc();
        if ($result) {
            if (is_array($reply)) {
                return $reply;
            } else {
                return [];
            }
        } else {
            return [];
        }
    }

    public function insert($table, $values, $update = "")
    {
        if ($update == "") {
            $query = "INSERT INTO $table VALUES($values)";
        } else {
            $query = "INSERT INTO $table VALUES($values) ON DUPLICATE KEY UPDATE $update;";
        }

        try {
            $this->mysqli->query($query);
            return array('query' => $query, 'error' => $this->mysqli->error, 'errno' => $this->mysqli->errno);
        } catch (\Throwable $th) {
            return array('query' => $query, 'error' => $this->mysqli->error, 'errno' => $this->mysqli->errno);
        }
    }

    public function insertCols($table, $columns, $values, $update = "")
    {

        if ($update == "") {
            $query = "INSERT INTO $table($columns) VALUES($values)";
        } else {
            $query = "INSERT INTO $table($columns) VALUES($values) ON DUPLICATE KEY UPDATE $update";
        }

        try {
            $this->mysqli->query($query);
            return array('query' => $query, 'error' => $this->mysqli->error, 'errno' => $this->mysqli->errno);
        } catch (\Throwable $th) {
            return array('query' => $query, 'error' => $this->mysqli->error, 'errno' => $this->mysqli->errno);
        }
    }

    public function delete_where($table, $where)
    {
        $query = "DELETE FROM $table WHERE $where";
        $this->mysqli->query($query);
        return array('query' => $query, 'error' => $this->mysqli->error, 'errno' => $this->mysqli->errno);
    }

    public function update($table, $set, $where)
    {
        $query = "UPDATE $table SET $set WHERE $where";
        try {
            $this->mysqli->query($query);
            return array('query' => $query, 'error' => $this->mysqli->error, 'errno' => $this->mysqli->errno, 'db' => $this->db_name);
        } catch (\Throwable $th) {
            return array('query' => $query, 'error' => $this->mysqli->error, 'errno' => $this->mysqli->errno, 'db' => $this->db_name);
        }
    }

    public function count($table)
    {
        $query = "SELECT COUNT(*) FROM $table";
        $result = $this->mysqli->query($query);

        $reply = $result->fetch_array();
        if ($reply) {
            return $reply[0];
        } else {
            return array('query' => $query, 'info' => $this->mysqli->error);
        }
    }

    public function count_where($table, $where)
    {
        $query = "SELECT COUNT(*) FROM $table WHERE $where";
        $result = $this->mysqli->query($query);

        $reply = $result->fetch_array();
        if ($reply) {
            return $reply[0];
        } else {
            return array('query' => $query, 'info' => $this->mysqli->error);
        }
    }

    public function count_distinct_where($table, $distinct, $where)
    {
        $query =  "SELECT COUNT(DISTINCT $distinct) as count FROM $table WHERE $where";
        $result = $this->mysqli->query($query);

        $reply = $result->fetch_array();
        if ($reply) {
            return $reply['count'];
        } else {
            return array('query' => $query, 'info' => $this->mysqli->error);
        }
    }

    public function query($query)
    {
        $query = $this->mysqli->query($query);
        try {
            $this->mysqli->query($query);
            return array('query' => $query, 'error' => $this->mysqli->error, 'errno' => $this->mysqli->errno);
        } catch (\Throwable $th) {
            return array('query' => $query, 'error' => $this->mysqli->error, 'errno' => $this->mysqli->errno);
        }
    }

    public function innerJoin1($table, $tb_join, $join_where)
    {
        $query = "SELECT * FROM $table INNER JOIN $tb_join ON $join_where";
        $result = $this->mysqli->query($query);
        if ($result) {
            $reply = [];
            while ($row = $result->fetch_assoc())
                $reply[] = $row;
            return $reply;
        } else {
            return FALSE;
        }
    }

    public function innerJoin2($table, $tb_join1, $join_where1, $tb_join2, $join_where2)
    {
        $query = "SELECT * FROM $table INNER JOIN $tb_join1 ON $join_where1 INNER JOIN $tb_join2 ON $join_where2";
        $result = $this->mysqli->query($query);
        if ($result) {
            $reply = [];
            while ($row = $result->fetch_assoc())
                $reply[] = $row;
            return $reply;
        } else {
            return FALSE;
        }
    }

    public function innerJoin2_where($table, $tb_join1, $join_where1, $tb_join2, $join_where2, $where)
    {
        $query = "SELECT * FROM $table INNER JOIN $tb_join1 ON $join_where1 INNER JOIN $tb_join2 ON $join_where2 WHERE $where";
        $result = $this->mysqli->query($query);
        if ($result) {
            $reply = [];
            while ($row = $result->fetch_assoc())
                $reply[] = $row;
            return $reply;
        } else {
            return FALSE;
        }
    }

    public function innerJoin1_where($table, $tb_join, $join_where, $where)
    {
        $query = "SELECT * FROM $table INNER JOIN $tb_join ON $join_where WHERE $where";
        $result = $this->mysqli->query($query);
        if ($result) {
            $reply = [];
            while ($row = $result->fetch_assoc())
                $reply[] = $row;
            return $reply;
        } else {
            return FALSE;
        }
    }
    public function innerJoin1_orderBy($table, $tb_join, $join_where, $orderBy)
    {
        $query = "SELECT * FROM $table INNER JOIN $tb_join ON $join_where ORDER BY $orderBy";
        $result = $this->mysqli->query($query);
        if ($result) {
            $reply = [];
            while ($row = $result->fetch_assoc())
                $reply[] = $row;
            return $reply;
        } else {
            return FALSE;
        }
    }

    //============================================

    public function sum_col_where($table, $col, $where)
    {
        $query = "SELECT SUM($col) as Total FROM $table WHERE $where";
        $result = $this->mysqli->query($query);

        $reply = $result->fetch_assoc();
        if ($result) {
            if ($reply["Total"] == '') {
                $reply["Total"] = 0;
            }

            return $reply["Total"];
        } else {
            return array('query' => $query, 'error' => $this->mysqli->error, 'errno' => $this->mysqli->errno, 'db' => $this->db_name);
        }
    }
}
