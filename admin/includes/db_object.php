<?php

class Db_object {

    public static function find_all() {
      return static::find_by_query("Select * from ".static::$db_table);
    }

    public static function find_by_id($id) {
      $result_set = static::find_by_query("Select * from ".static::$db_table." where id=".$id .  " LIMIT 1");
      return !empty($result_set) ? array_shift($result_set) : false;
      // if (!empty($result_set)) {
      //     $first_item = array_shift($result_set);
      //     return $first_item;
      // } else {
      //     return false;
      // }
    }

    public function find_by_query($sql) {
      global $database;
      $result_set = $database->query($sql);
      $object_array = array();
      while($row = mysqli_fetch_array($result_set)) {
          $object_array[] = static::instantiation($row);
      }
      return $object_array;
    }

    public static function instantiation($the_record) {
        $calling_class = get_called_class();
      $the_object = new $calling_class;
      // $the_object->id         = $found_user['id'];
      // $the_object->username   = $found_user['username'];
      // $the_object->password   = $found_user['password'];
      // $the_object->first_name = $found_user['first_name'];
      // $the_object->last_name  = $found_user['last_name'];

      foreach ($the_record as $key => $property) {
          # code...
          if ($the_object->has_the_attribute($key)) {
              $the_object->$key = $property;
          }
      }

      return $the_object;
    }

    private function has_the_attribute($attribute) {
        $object_properties = get_object_vars($this);
        return array_key_exists($attribute,$object_properties);
    }

    protected function clean_properties() {
        global $database;
        $clean_properties = array();
        foreach ($this->properties() as $key => $value) {
            $clean_properties[$key]=$database->escape_string($value);
        }
        return $clean_properties;
    }

    public function create() {
        global $database;
        $properties = $this->clean_properties();



        $sql = "INSERT INTO ".static::$db_table." (". implode(",",array_keys($properties)).") ";
        $sql = $sql . "VALUES ('".implode("','",array_values($properties))."')";
        // $sql = $sql . $database->escape_string($this->username) . "', '";
        // $sql = $sql . $database->escape_string($this->password) . "', '";
        // $sql = $sql . $database->escape_string($this->first_name) . "', '";
        // $sql = $sql . $database->escape_string($this->last_name) . "')";

        if ($database->query($sql)) {
            $this->id = $database->the_insert_id();
            return true;
        } else {
            return false;
        }

    }

    public function save() {
        return isset($this->id) ? $this->update() : $this->create();
    }

    public function update() {
        global $database;
        $properties = $this->clean_properties();
        $properties_pairs = array();

        foreach ($properties as $key => $value) {
            # code...
            $properties_pairs[] = "{$key}='{$value}'";
        }

        $sql = "update ".static::$db_table." SET ";
        $sql = $sql . implode(", ",$properties_pairs);
        // $sql = $sql . "username='".$database->escape_string($this->username) . "', ";
        // $sql = $sql . "password='".$database->escape_string($this->password) . "', ";
        // $sql = $sql . "first_name='".$database->escape_string($this->first_name) . "', ";
        // $sql = $sql . "last_name='".$database->escape_string($this->last_name) . "'  ";
        $sql = $sql . " where id=".$database->escape_string($this->id);
        //echo $sql; exit;
        $database->query($sql);
        return (mysqli_affected_rows($this->connection)==1) ? true:false;
    }

    public function delete() {
        global $database;
        $sql = "delete from ".static::$db_table. " ";
        $sql = $sql . "where id=".$database->escape_string($this->id);
        $database->query($sql);
        return (mysqli_affected_rows($this->connection)==1) ? true:false;
    }

    protected function properties() {
        //return get_object_vars($this

        $properties = array();
        foreach (static::$db_table_fields as $db_field) {
            if (property_exists($this,$db_field)) {
                $properties[$db_field] = $this->$db_field;
            }
        }
        return $properties;
    }




}
 ?>
