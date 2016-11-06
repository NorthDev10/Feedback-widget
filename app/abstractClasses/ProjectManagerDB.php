<?php
defined('CONTACT_DETAILS') or die('Access denied');

abstract class ProjectManagerDB {
    
    private static $numberProjects;
    
    public function countProjects() {
        if(!self::$numberProjects) {
            $sqlCode = "SELECT COUNT(apiKeyId) ";
            $sqlCode .= "FROM tableApiKeys AS tA, users ";
            $sqlCode .= "WHERE users.userId = tA.userId AND users.userId = '%d'";
            $sqlCode = sprintf($sqlCode, $this->getUserId());
            if($result = $this->mysqli->query($sqlCode)) {
                self::$numberProjects = $result->fetch_row()[0];
            }
        }
        return self::$numberProjects;
    }

    protected function fetchAll($currentPage=1, $number=10) {
        if(($this->getUserId() == $_SESSION['userId'])
            || ($_SESSION['myRights'] & RIGHT_READ_ALL_DATA)) {
            $sqlCode = 'SELECT tA.* ';
            $sqlCode .= 'FROM tableApiKeys AS tA, users ';
            $sqlCode .= "WHERE users.userId = tA.userId AND users.userId = '%d' ";
            $sqlCode .= 'ORDER BY tA.dateRegistration DESC LIMIT %d, %d';
            $page = ($currentPage-1) * $number;
            $sqlCode = sprintf($sqlCode, $this->getUserId(), $page, $number);
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
    
    protected function fetchById() {
        if(($this->getUserId() == $_SESSION['userId'])
            || ($_SESSION['myRights'] & RIGHT_READ_ALL_DATA)) {
            $sqlCode = 'SELECT * FROM tableApiKeys ';
            $sqlCode .= "WHERE userId='%d' AND apiKeyId='%d'";
            $sqlCode = sprintf(
                $sqlCode, 
                $this->getUserId(),
                $this->getApiKeyId()
            );
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
    }
    
    protected function fetchByApiKey() {
        $sqlCode = 'SELECT * FROM tableApiKeys ';
        $sqlCode .= "WHERE apiKey='%s'";
        $sqlCode = sprintf(
            $sqlCode,
            $this->mysqli->real_escape_string($this->getApiKey())
        );
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
    
    protected function save() {
        if(($this->getUserId() == $_SESSION['userId'])
            || ($_SESSION['myRights'] & RIGHT_WRITE_ALL_DATA)) {
                $sqlCode = "UPDATE tableApiKeys SET ";
                $sqlCode .= "domain = '%s', managerPhone = '%s', timeZone = '%s', daylightSavingTime = '%d',";
                $sqlCode .= "timeZoneId = '%s', workingDays = '%s', widgetSettings = '%s' ";
                $sqlCode .= "WHERE userId = '%d' AND apiKeyId = '%d'";
                $sqlCode = sprintf(
                    $sqlCode, 
                    $this->mysqli->real_escape_string($this->getDomain()),
                    $this->mysqli->real_escape_string($this->getManagerPhone()),
                    $this->mysqli->real_escape_string($this->getTimeZone()),
                    $this->getDaylightSavingTime(),
                    $this->mysqli->real_escape_string($this->getTimeZoneId()),
                    $this->mysqli->real_escape_string($this->getWorkingDaysJSON()),
                    $this->mysqli->real_escape_string($this->getWidgetSettingsJSON()),
                    $this->getUserId(),
                    $this->getApiKeyId()
                );
                if($this->mysqli->query($sqlCode)) {
                    return true;
                }
        }
    }
    
    protected function delete() {
        if(($this->getUserId() == $_SESSION['userId'])
            || ($_SESSION['myRights'] & RIGHT_DELETE_ALL_DATA)) {
            $sqlCode = 'DELETE tableApiKeys, contactDetails FROM tableApiKeys ';
            $sqlCode .= 'LEFT JOIN contactDetails ON (contactDetails.apiKeyId = tableApiKeys.apiKeyId)';
            $sqlCode .= 'WHERE tableApiKeys.userId = \'%d\' AND tableApiKeys.apiKeyId = \'%d\'';
            $sqlCode = sprintf(
                $sqlCode,
                $this->getUserId(),
                $this->getApiKeyId()
            );
            $this->mysqli->query($sqlCode);
            return $this->mysqli->affected_rows;
        }
    }
    
    protected function createNewProject(Users $users) {
        if(($this->getUserId() == $_SESSION['userId'])
            || ($_SESSION['myRights'] & RIGHT_ADD_ALL_DATA)) {
            $sqlCode = "INSERT INTO tableApiKeys (";
            $sqlCode .= "userId, apiKey, domain, managerPhone, dateRegistration,";
            $sqlCode .= "timeZone, daylightSavingTime, timeZoneId, workingDays, widgetSettings";
            $sqlCode .= ") VALUES ('%d','%s','%s','%s','%s','%s', '%d','%s','%s','%s')";
            $this->setApiKey(md5(
                $this->getUserId().
                $users->getEmail().
                $users->getUserPwd().
                time().
                rand(1024, 32767)
            ));
            $this->setDateRegistration(date("Y-m-d H:i:s"));
            $sqlCode = sprintf(
                $sqlCode,
                $this->getUserId(),
                $this->mysqli->real_escape_string($this->getApiKey()),
                $this->mysqli->real_escape_string($this->getDomain()),
                $this->mysqli->real_escape_string($this->getManagerPhone()),
                $this->mysqli->real_escape_string($this->getDateRegistration()),
                $this->mysqli->real_escape_string($this->getTimeZone()),
                $this->getDaylightSavingTime(),
                $this->mysqli->real_escape_string($this->getTimeZoneId()),
                $this->mysqli->real_escape_string($this->getWorkingDaysJSON()),
                $this->mysqli->real_escape_string($this->getWidgetSettingsJSON())
            );
            if($this->mysqli->query($sqlCode)) {
                $this->setApiKeyId($this->mysqli->insert_id);
                return true;
            }
        }
    }
    
    protected function setOptions(array $options) {
        $methods = get_class_methods($this);
        foreach($options as $key => $value) {
            $method = 'set'.ucfirst($key);
            if(in_array($method, $methods)) {
                $this->$method($value);
            }
        }
    }
}