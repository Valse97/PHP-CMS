<?php require_once ('Db.php') ?>
<?php require_once ('DbInit.php') ?>
<?php
class Session {
    protected $sessionId = null;
    protected $userId = null;
    protected $user = null;

    public function __construct() {
        if(!isset($_SESSION))
        {
            session_start();
        }
        $this->sessionId = session_id();
    }
    
    public function getSessionId() {
        return $this->sessionId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
        $_SESSION['user_id'] = $userId;
    }

    public function setRole($newRole) {
        $_SESSION['role'] = $newRole;
        if (isset($_SESSION['user'])) {
            $this->user = unserialize($_SESSION['user']);
            $this->user->ruolo = $newRole;
            $_SESSION['user'] = serialize($this->user);
        }
    }

    public function destroy() {
        session_destroy();
    }

    public function isLogged() {
        return isset($_SESSION['user_id']);
    }

    public function getUserId() {
        if (!isset($this->user_id)) {
            $this->userId = $_SESSION['user_id'];
        }
        return $this->userId;
    }

    public function getUser() {
        if (!isset($this->user)) {
            if (!isset($_SESSION['user']) || strlen($_SESSION['user'])<5) {
                $user_id = self::getUserId();
                $db = Db::instance();
                $this->user = $db->raw(sprintf("select u.*, r.ruolo 
                    from utenti u inner join utenti_ruoli r on u.id=r.utente_id 
                    where u.id=%d limit 1",$user_id))->fetch();
                $_SESSION['user'] = serialize($this->user);
                $_SESSION['role'] = $this->user->ruolo;
            } else {
                $this->user = unserialize($_SESSION['user']);
            }
        }
        return $this->user;
    }

    public function unsetUser() {
        unset($_SESSION['user']);
    }

    public function setVar($var, $value) {
        $_SESSION[$var] = $value;
    }

    public function getVar($var) {
        return $_SESSION[$var];
    }

    public function unsetVar($var) {
        unset($_SESSION[$var]);
    }
}