<?php


  function fetch_all_events($searchKeyword = '') {
  global $db;


  $sqlAll = "SELECT events.name, events.desc, events.id, events.created_at, result.types FROM ( SELECT events.id, GROUP_CONCAT(types.name) AS types FROM events INNER JOIN event_types ON events.id = event_types.event_id INNER JOIN type_events ON event_types.type_id = type_events.id INNER JOIN event_types AS has_types ON events.id = has_types.event_id INNER JOIN type_events AS types ON has_types.type_id = types.id GROUP BY events.id ) AS result INNER JOIN events USING(id);";
  $sqlSearch = "SELECT events.name, events.desc, events.id, events.created_at, result.types FROM ( SELECT events.id, GROUP_CONCAT(types.name) AS types FROM events INNER JOIN event_types ON events.id = event_types.event_id INNER JOIN type_events ON event_types.type_id = type_events.id INNER JOIN event_types AS has_types ON events.id = has_types.event_id INNER JOIN type_events AS types ON has_types.type_id = types.id  WHERE events.name LIKE '%$searchKeyword%' GROUP BY events.id ) AS result INNER JOIN events USING(id);";

  $sql = $searchKeyword ? $sqlSearch : $sqlAll;
  $result = mysqli_query($db, $sql);
  confirm_result_set($result, $sql);
  return $result;
  }
  function fetch_standout_events() {
    global $db;

    $sql = "SELECT events.name, events.desc, events.id,  result.types FROM ( SELECT events.id, GROUP_CONCAT(types.name) AS types FROM events INNER JOIN event_types ON events.id = event_types.event_id  AND event_types.type_id IN (2,3) INNER JOIN type_events ON event_types.type_id = type_events.id INNER JOIN event_types AS has_types ON events.id = has_types.event_id INNER JOIN type_events AS types ON has_types.type_id = types.id GROUP BY events.id ) AS result INNER JOIN events USING(id) ;";

    $result = mysqli_query($db, $sql);
    confirm_result_set($result, $sql);
    return $result;
  }
  function search_events() {
  global $db;
  $string = 'Frontend Jamstack';

  $sql = "SELECT events.name, events.desc, events.id, events.created_at, result.types FROM ( SELECT events.id, GROUP_CONCAT(types.name) AS types FROM events WHERE MATCH (`name`) AGAINST $string; INNER JOIN event_types ON events.id = event_types.event_id INNER JOIN type_events ON event_types.type_id = type_events.id INNER JOIN event_types AS has_types ON events.id = has_types.event_id INNER JOIN type_events AS types ON has_types.type_id = types.id GROUP BY events.id ) AS result INNER JOIN events USING(id);";

  $result = mysqli_query($db, $sql);
  confirm_result_set($result, $sql);
  return $result;
}
  function find_other_events() {
    global $db;

    $sql = "SELECT *, type.name as typeName, events.name as eventName FROM events ";
    $sql .= "INNER JOIN type ON events.type_id=type.id AND events.type_id NOT IN (2,3,6) ";
    $sql .= "ORDER BY type.name ASC;";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result, $sql);
//    $events = mysqli_fetch_assoc($result);
//    mysqli_free_result($result);
    return $result;
  }

  function fetch_types() {
    global $db;

    $sql = "SELECT * FROM type_events ";
    $sql .= "ORDER BY type_events.name ASC;";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result, $sql);
    return $result;
  }

  function update_event($subject) {
    global $db;


    $sql = "UPDATE events SET ";
    $sql .= "title='" . $subject['title'] . "', ";
    $sql .= "desc='" . $subject['desc'] . "', ";
    $sql .= "type_id='" . $subject['type_id'] . "' ";
    $sql .= "WHERE id='" . $subject['id'] . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    if($result) {
      return true;
    } else {
      // UPDATE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }

  }

  function validate_event($event) {
    $errors = [];

    // Title
    if(is_blank($event['title'])) {
      $errors[] = "Title cannot be blank.";
    }

    // Desc
    if(is_blank($event['desc'])) {
      $errors[] = "Description cannot be blank.";
    }

    // Desc
    if(is_blank($event['type'])) {
      $errors[] = "Type cannot be blank.";
    }


    return $errors;
  }

  function insert_event($event) {
    global $db;


    $sql = "INSERT INTO events ";
    $sql .= "(title, desc) ";
    $sql .= "VALUES (";
    $sql .= "'" . $event['title'] . "',";
    $sql .= "'" . $event['desc'] . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    if($result) {
      return true;
    } else {
      // INSERT failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function insert_type($type) {
    global $db;


    $sql = "INSERT INTO type ";
    $sql .= "(name, created_at) ";
    $sql .= "VALUES (";
    $sql .= "'" . $type. "', ";
    $sql .= "'" . date('d-m-y h:i:s') . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    if($result) {
      return true;
    } else {
      // INSERT failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function apply_to_event($event_id) {
    global  $db;
    $userID = $_SESSION['id'];
    if (!$userID) {
      return;
    };

    $sql = "INSERT INTO applied ";
    $sql .= "(`user_id`, `event_id`) ";
    $sql .= "VALUES (";
    $sql .= "'" . $userID . "',";
    $sql .= "'" . $event_id . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result, $sql);

    if($result) {
      $cookie_name = "toast";
      $cookie_message = "success";
      setcookie($cookie_name, $cookie_message, time()+3);

      $to = "xyz@mailinator.com";
      $subject = "Eveents applied succesfully";

      $message = "<b>Application successful.</b>";
      $message .= "<h1>This is headline.</h1>";

      $header = "From:abc@somedomain.com \r\n";
      $header .= "Cc:afgh@somedomain.com \r\n";
      $header .= "MIME-Version: 1.0\r\n";
      $header .= "Content-type: text/html\r\n";

      $retval = mail($to, $subject, $message, $header);

      if ($retval == true) {
        return "Message sent successfully...";
      } else {
        return "Message could not be sent...";
      }
    } else {
      // INSERT failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function check_login_status() {
    global  $db;
    if ($_SESSION['id']) {
      return true;
    } else {
      return false;
    };


  }
?>




