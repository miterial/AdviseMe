<?php
/**
 * 
 */
class AM_User
{
    protected $id;
    protected $name;
    protected $email;
    protected $about;

    function __construct()
    {
        $curauth = wp_get_current_user();
        $this->name = $curauth->user_login;
    }

    function getUserInfoFromDB($param) {
        
        $conn = db_connect();
        $sqlUser = sprintf("SELECT * FROM users WHERE login ='%s'", $this->name);
        $result = $conn->query($sqlUser);
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              $res = $row[$param];
            }
        }
        else mysqli_error($conn);
        $conn->close();
        return $res;
    }
}
