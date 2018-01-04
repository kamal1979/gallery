<?php
  class User extends Db_object {
    protected static $db_table = "users";
    protected static $db_table_fields =array('username','first_name','last_name','password');
    public $id;
    public $username;
    public $first_name;
    public $last_name;
    public $password;



    public static function verify_user($username,$password) {
        global $database;

        $username = $database->escape_string($username);
        $password = $database->escape_string($password);

        $sql = "select * from ".self::$db_table." where ";
        $sql = $sql . "username='{$username}' ";
        $sql = $sql . "and password='{$password}' ";
        $sql = $sql . "LIMIT 1";
        //echo $sql; exit;
        $result_set = self::find_by_query($sql);
        //var_dump($result_set); exit;
        return !empty($result_set) ? array_shift($result_set) : false;

    }




  }

 ?>
