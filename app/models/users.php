<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of users
 *
 * @author engin
 */
class users extends model {

    private $_isLoggenIn, $_sessionName, $_cookieName;
    public static $currentLoggedInUser = null;
    public $_userInfo;

    public function __construct($user = "") {
        $table = "users";

        parent::__construct($table);

        $this->_sessionName = CURRENT_USER_SESSION_NAME;
        $this->_cookieName = REMEMBER_ME_COOKIE_NAME;
        $this->_softDelete = true;

        if ($user != "") {
            if (is_numeric($user)) {
                $u = $this->_db->findFirst($table, ["condition" => "{$table}_id = ?", "bind" => [$user]]);
            } else {
                $u = $this->_db->findFirst($table, ["condition" => "fname_sef = ?", "bind" => [$user]]);
            }
            if ($u) {
                foreach ($u as $key => $val) {
                    $this->$key = $val;
                }
            }
        }
    }

    public function setID($id) {
        return $this->id = $id;
    }

    public function findByUsername($username) {
        return $this->findFirst(["condition" => "fname_sef = ?", "bind" => [$username]]);
    }

    public function findByEmail($user_email) {
        return $this->findFirst(["condition" => "email = ?", "bind" => [$user_email]]);
    }

    public function findByID($user_id) {
        return $this->findFirst(["condition" => "{$table}_id = ?", "bind" => [$user_id]]);
    }

    public function currentLoggedInUser() {
        if (!isset(self::$currentLoggedInUser) && session::exists(CURRENT_USER_SESSION_NAME)) {
            $u = new users((int) session::get(CURRENT_USER_SESSION_NAME));
            self::$currentLoggedInUser = $u;
        }
        return self::$currentLoggedInUser;
    }

    public function login($rememberme = false, $id) {
        session::set($this->_sessionName, $id);
        if ($rememberme) {
            $hash = md5(uniqid() + time());
            $user_agent = session::uagent_no_version();
            cookie::set($this->_cookieName, $hash, REMEMBER_ME_COOKIE_EXPIRY);
            $fields = ["session" => $hash, "user_agent" => $user_agent, "users_id" => $this->{$this->_table . "_id"}];
            $this->_db->query("DELETE FROM user_session WHERE users_id= ? AND user_agent= ?", [$this->{$this->_table . "_id"}, $user_agent]);
            $this->_db->insert("user_session", $fields);
        }
    }

    public static function loginUserFromCookie() {

        $user_sesion = UserSession::getFromCookie();
        if ($user_sesion->users_id != "") {
            $user_model = new self($user_sesion->users_id);
        }
        $user_model->id = $user_sesion->users_id;
        $user_model->login(false, $user_model->id);
        // router::redirect($location)
        //dnd($user_sesion);
        return $user_model;
    }

    public function logout() {

        $user_agent = session::uagent_no_version();
        $this->_db->query("DELETE FROM user_session WHERE user_id = ? AND user_agent = ?", [$this->id, $user_agent]);
        session::delete(CURRENT_USER_SESSION_NAME);
        if (cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
            cookie::delete(REMEMBER_ME_COOKIE_NAME);
        }
        self::$currentLoggedInUser = null;
        return true;
    }

}
