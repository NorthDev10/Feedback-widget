<?php
defined('CONTACT_DETAILS') or die('Access denied');

abstract class UserDB {
    
    private static $countUsers;

    protected function fetchUserByEmail($password) {
        $sqlCode = 'SELECT * ';
        $sqlCode .= 'FROM users, groups';
        $sqlCode .= " WHERE	groups.groupsId=users.groupId AND email = '%s'";
        $sqlCode = sprintf($sqlCode, $this->mysqli->real_escape_string($this->getEmail()));
        if($result = $this->mysqli->query($sqlCode)) {
            $row = $result->fetch_assoc();
            if($row) {
                if (password_verify($password, $row['userPwd'])) {
                    $this->setOptions($row);
                    $result->close();
                    $this->setAuthorization(true);
                    $this->updateDateLastEntry();
                    return true;
                } else {
                    $result->close();
                }
            } else {
                $result->close();
            }
        }
    }
    
    protected function fetchUserById($userId) {
        $sqlCode = 'SELECT * ';
        $sqlCode .= 'FROM users, groups';
        $sqlCode .= " WHERE	groups.groupsId=users.groupId AND userId = '%d'";
        $sqlCode = sprintf($sqlCode, $userId);
        if($result = $this->mysqli->query($sqlCode)) {
            $row = $result->fetch_assoc();
            if($row) {
                $this->setOptions($row);
                $result->close();
                return true;
            } else {
                $result->close();
            }
        }
    }
    
    protected function fetchUserByVKId() {
        $sqlCode = 'SELECT * ';
        $sqlCode .= 'FROM users, groups';
        if(!empty($this->getEmail())) {
            $sqlCode .= " WHERE	groups.groupsId=users.groupId AND (vkUserId = '%s' OR email = '%s')";
            $sqlCode = sprintf($sqlCode, 
                $this->mysqli->real_escape_string($this->getVkUserId()), 
                $this->mysqli->real_escape_string($this->getEmail())
            );
        } else {
            $sqlCode .= " WHERE	groups.groupsId=users.groupId AND vkUserId = '%s'";
            $sqlCode = sprintf($sqlCode, $this->mysqli->real_escape_string($this->getVkUserId()));
        }
        $result = $this->mysqli->query($sqlCode);
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if($row) {
                $this->setOptions($row);
                $result->close();
                $this->setAuthorization(true);
                $this->updateDateLastEntry();
                return true;
            } else {
                $result->close();
            }
        } else {
            $sqlCode = "INSERT INTO users (";
            $sqlCode .= "email, emailConfirmation, vkAccessToken, vkUserId, firstName, lastName, mobilePhone,";
            $sqlCode .= "homePhone, skype, siteURL, dateRegistration, dateLastEntry, ipAddress, groupId";
            $sqlCode .= ") VALUES ('%s','1','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','2')";
            $sqlCode = sprintf(
                $sqlCode,
                $this->mysqli->real_escape_string($this->getEmail()),
                $this->mysqli->real_escape_string($this->getVkAccessToken()),
                $this->mysqli->real_escape_string($this->getVkUserId()),
                $this->mysqli->real_escape_string($this->getFirstName()),
                $this->mysqli->real_escape_string($this->getLastName()),
                $this->mysqli->real_escape_string($this->getMobilePhone()),
                $this->mysqli->real_escape_string($this->getHomePhone()),
                $this->mysqli->real_escape_string($this->getSkype()),
                $this->mysqli->real_escape_string($this->getSiteURL()),
                date("Y-m-d H:i:s"),
                date("Y-m-d H:i:s"),
                $this->mysqli->real_escape_string($this->getIpAddress())
            );
            if($this->mysqli->query($sqlCode)) {
                $this->setUserId($this->mysqli->insert_id);
                $this->setAuthorization(true);
                return true;
            }
        }
    }
    
    protected function fetchUserByGoogleId() {
        $sqlCode = 'SELECT * ';
        $sqlCode .= 'FROM users, groups';
        if(!empty($this->getEmail())) {
            $sqlCode .= " WHERE	groups.groupsId=users.groupId AND (googleUserId = '%s' OR email = '%s')";
            $sqlCode = sprintf($sqlCode, 
                $this->mysqli->real_escape_string($this->getGoogleUserId()),
                $this->mysqli->real_escape_string($this->getEmail())
            );
        } else {
            $sqlCode .= " WHERE	groups.groupsId=users.groupId AND googleUserId = '%s'";
            $sqlCode = sprintf($sqlCode, $this->mysqli->real_escape_string($this->getGoogleUserId()));
        }
        $result = $this->mysqli->query($sqlCode);
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if($row) {
                $this->setOptions($row);
                $result->close();
                $this->setAuthorization(true);
                $this->updateDateLastEntry();
                return true;
            } else {
                $result->close();
            }
        } else {
            $sqlCode = "INSERT INTO users (";
            $sqlCode .= "email, emailConfirmation, googleUserId, firstName, lastName, ";
            $sqlCode .= "dateRegistration, dateLastEntry, ipAddress, groupId";
            $sqlCode .= ") VALUES ('%s','%d','%s','%s','%s','%s','%s','%s','2')";
            $sqlCode = sprintf(
                $sqlCode,
                $this->mysqli->real_escape_string($this->getEmail()),
                $this->getEmailConfirmation(),
                $this->mysqli->real_escape_string($this->getGoogleUserId()),
                $this->mysqli->real_escape_string($this->getFirstName()),
                $this->mysqli->real_escape_string($this->getLastName()),
                date("Y-m-d H:i:s"),
                date("Y-m-d H:i:s"),
                $this->mysqli->real_escape_string($this->getIpAddress())
            );
            if($this->mysqli->query($sqlCode)) {
                $this->setUserId($this->mysqli->insert_id);
                $this->setAuthorization(true);
                return true;
            }
        }
    }
    
    // заполнят объект данными из БД
    protected function setOptions(array $options) {
        $methods = get_class_methods($this);
        foreach($options as $key => $value) {
            $method = 'set'.ucfirst($key);
            if(in_array($method, $methods)) {
                $this->$method($value);
            }
        }
    }
    
    protected function updateDateLastEntry() {
        $_SESSION['dateLastEntry'] = $this->getDateLastEntry();
        $sqlCode = "UPDATE users SET dateLastEntry = '%s' WHERE userId = '%d'";
        $sqlCode = sprintf($sqlCode, date("Y-m-d H:i:s"), $this->getUserId());
        $this->mysqli->query($sqlCode);
    }
    
    protected function createNewAccount() {
        $sqlCode = "INSERT INTO users (";
        $sqlCode .= "email, emailConfirmation, userPwd,";
        $sqlCode .= "dateRegistration, dateLastEntry, ipAddress, groupId";
        $sqlCode .= ") VALUES ('%s','0','%s','%s','%s','%s','2')";
        $sqlCode = sprintf(
            $sqlCode,
            $this->mysqli->real_escape_string($this->getEmail()),
            $this->mysqli->real_escape_string($this->getUserPwd()),
            date("Y-m-d H:i:s"),
            date("Y-m-d H:i:s"),
            $this->mysqli->real_escape_string($_SERVER["HTTP_X_FORWARDED_FOR"])
        );
        if($this->mysqli->query($sqlCode)) {
            $this->setUserId($this->mysqli->insert_id);
            $this->setAuthorization(true);
            $_SESSION['dateLastEntry'] = date("Y-m-d H:i:s");
            return true;
        }
    }
    
    protected function getHashForRestorePassword() {
        $sqlCode = 'SELECT userId, userPwd ';
        $sqlCode .= 'FROM users';
        $sqlCode .= " WHERE email = '%s'";
        $sqlCode = sprintf($sqlCode, $this->mysqli->real_escape_string($this->getEmail()));
        if($result = $this->mysqli->query($sqlCode)) {
            $row = $result->fetch_row();
            if($row) {
                $this->setUserId($row[0]);
                if(!empty($row[1])) {
                    return md5($row[0].$row[1].$this->getEmail().date("Y-m-d H"));
                } else {
                    $hashPwd = md5(time().rand(1024, 32767));
                    $sqlCode = "UPDATE users SET userPwd = '%s' WHERE userId = '%d'";
                    $sqlCode = sprintf($sqlCode, $hashPwd, $row[0]);
                    $this->mysqli->query($sqlCode);
                    return md5($row[0].$hashPwd.$this->getEmail().date("Y-m-d H"));
                }
            }
        }
    }
    
    protected function restorePassword($uid, $key) {
        $sqlCode = 'SELECT * ';
        $sqlCode .= 'FROM users, groups';
        $sqlCode .= " WHERE	groups.groupsId=users.groupId AND userId = '%d'";
        $sqlCode = sprintf($sqlCode, $uid);
        if($result = $this->mysqli->query($sqlCode)) {
            $row = $result->fetch_assoc();
            if($row) {
                $hashPwd = md5($row['userId'].$row['userPwd'].$row['email'].date("Y-m-d H"));
                if($hashPwd === $key) {
                    $this->setAuthorization(true);
                    $this->setOptions($row);
                    $_SESSION['userId'] = $this->getUserId();
                    $_SESSION['dateLastEntry'] = $this->getDateLastEntry();
                    $hashPwd = md5(time().rand(1024, 32767));
                    $sqlCode = "UPDATE users SET userPwd = '%s', dateLastEntry = '%s', ";
                    $sqlCode .= "emailConfirmation='1' WHERE userId = '%d'";
                    $sqlCode = sprintf($sqlCode, $hashPwd, date("Y-m-d H:i:s"), $this->getUserId());
                    $this->mysqli->query($sqlCode);
                    $result->close();
                    return true;
                } else {
                    $this->setAuthorization(false);
                    $result->close();
                }
            } else {
                $this->setAuthorization(false);
                $result->close();
            }
        }
    }
    
    protected function getHashForEmailConfirmation() {
        $sqlCode = 'SELECT userId, userPwd, dateRegistration ';
        $sqlCode .= 'FROM users';
        $sqlCode .= " WHERE email = '%s'";
        $sqlCode = sprintf($sqlCode, $this->mysqli->real_escape_string($this->getEmail()));
        if($result = $this->mysqli->query($sqlCode)) {
            $row = $result->fetch_row();
            if($row) {
                $this->setUserId($row[0]);
                if(!empty($row[1])) {
                    return md5($row[0].$row[1].$this->getEmail().$row[2].date("Y-m-d H"));
                } else {
                    $hashPwd = md5(time().rand(1024, 32767));
                    $sqlCode = "UPDATE users SET userPwd = '%s' WHERE userId = '%d'";
                    $sqlCode = sprintf($sqlCode, $hashPwd, $row[0]);
                    $this->mysqli->query($sqlCode);
                    return md5($row[0].$hashPwd.$this->getEmail().$row[2].date("Y-m-d H"));
                }
            }
        }
    }
    
    protected function emailConfirmation($uid, $key) {
        $sqlCode = 'SELECT userId, userPwd, email, dateRegistration ';
        $sqlCode .= 'FROM users';
        $sqlCode .= " WHERE userId = '%d'";
        $sqlCode = sprintf($sqlCode, $uid);
        if($result = $this->mysqli->query($sqlCode)) {
            $row = $result->fetch_row();
            if($row) {
                $hashPwd = md5($row[0].$row[1].$row[2].$row[3].date("Y-m-d H"));
                if($hashPwd === $key) {
                    $sqlCode = "UPDATE users SET dateLastEntry = '%s', ";
                    $sqlCode .= "emailConfirmation='1' WHERE userId = '%d'";
                    $sqlCode = sprintf($sqlCode, date("Y-m-d H:i:s"), $uid);
                    $this->mysqli->query($sqlCode);
                    $result->close();
                    return true;
                } else {
                    $result->close();
                }
            } else {
                $result->close();
            }
        }
    }
    
    public function getListAllGroups() {
        $sqlCode = 'SELECT groupsId, groupName FROM groups';
        if($result = $this->mysqli->query($sqlCode)) {
            $records = array();
            while ($row = $result->fetch_assoc()) {
                $records[] = $row;
            }
            $result->close();
            return $records;
        }
    }
    
    protected function fillColumnForUpdateDB(Users $oldUserInfo, Users $newUserInfo) {
        $fields = array(
            'userPwd','email','firstName','lastName','mobilePhone',
            'homePhone','skype','siteURL','groupId'
        );
        $colName = "";
        if($newUserInfo->getUserId() == $_SESSION['userId']) {
            unset($fields[8]); // пользователь не имеет права менять свой groupId
        }
        $methods = get_class_methods($oldUserInfo);
        foreach($fields as $value) {
            $method = 'get'.ucfirst($value);
            if(in_array($method, $methods)) {
                if(($oldUserInfo->$method() != $newUserInfo->$method()) 
                    && !empty($newUserInfo->$method())) {
                    $colName .= $value."='".$oldUserInfo->mysqli->real_escape_string(
                            $newUserInfo->$method()
                    )."',";
                    if($value == 'email') {
                        $colName .= "emailConfirmation='0',";
                    }
                }
            }
        }
        return trim($colName, ',');
    }
    
    protected function saveUserInfo(Users $object) {
        $colName = "";
        if($object->getUserId() == $_SESSION['userId']) {
            $colName = $this->fillColumnForUpdateDB($this, $object);
        } elseif($this->getRights() & RIGHT_WRITE_ALL_DATA) {
            $userFromDB = new $this();
            if($userFromDB->fetchUserById($object->getUserId())) {
                $colName = $this->fillColumnForUpdateDB($userFromDB, $object);
            }
        }
        if(!empty($colName)) {
            $sqlCode = "UPDATE users SET ";
            $sqlCode .= $colName;
            $sqlCode .= " WHERE userId = '%d'";
            $sqlCode = sprintf($sqlCode, $object->getUserId());
            if($this->mysqli->query($sqlCode)) {
                return true;
            }
        }
    }
    
    public function countUsers() {
        if(!self::$countUsers) {
            $sqlCode = "SELECT COUNT(userId) FROM users";
            if($result = $this->mysqli->query($sqlCode)) {
                self::$countUsers = $result->fetch_row()[0];
            }
        }
        return self::$countUsers;
    }
    
    protected function fetchAllUsers($currentPage=1, $numberUsers=10) {
        $sqlCode = 'SELECT * ';
        $sqlCode .= 'FROM users';
        $sqlCode .= ' ORDER BY dateRegistration DESC LIMIT %1$d, %2$d';
        $page = ($currentPage-1) * $numberUsers;
        $sqlCode = sprintf($sqlCode, $page, $numberUsers);
        if($result = $this->mysqli->query($sqlCode)) {
            $records = array();
            while ($row = $result->fetch_assoc()) {
                $temp = new $this();
                $temp->setOptions($row);
                $records[] = $temp;
            }
            $result->close();
            return $records;
        }
    }
}