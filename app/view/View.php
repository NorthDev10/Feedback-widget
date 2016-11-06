<?php
defined('CONTACT_DETAILS') or die('Access denied');

class View {
    public static function getAuthPage() {
        require_once VIEW.'theme/authPage.php';
    }
    public static function getControlPanel() {
        require_once VIEW.'theme/controlPanel.php';
    }
    public static function getMainPage() {
        require_once VIEW.'theme/mainPage.php';
    }
    public static function getNewAccount() {
        require_once VIEW.'theme/createNewAccount.php';
    }
    public static function getRestorePwd() {
        require_once VIEW.'theme/restorePwd.php';
    }
    public static function getInfoPage($message) {
        require_once VIEW.'theme/infoPage.php';
    }
    public static function getListAllUsers() {
        require_once VIEW.'theme/listAllUsers.php';
    }
    public static function getUserProfile(Users $Users) {
        require_once VIEW.'theme/userProfile.php';
    }
    public static function getProjectSettings(ProjectManager $ProjectSettings) {
        require_once VIEW.'theme/projectSettings.php';
    }
    public static function getContactsList() {
        require_once VIEW.'theme/contactsList.php';
    }
}