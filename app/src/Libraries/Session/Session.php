<?php

namespace Luna\Session;

/**
 * Session Class Utilities
 *
 * @author leonnguyenit
 */
final class Session
{
    /**
     * Regenerate new session id
     */
    public static function regenerate()
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
    }

    /**
     * Destroy current session instance
     */
    public static function destroy()
    {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }

    /**
     * Get a session value
     *
     * @param $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
        }
        return $default;
    }

    /**
     * Set a session value
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Delete a session by key
     *
     * @param $key
     */
    public function delete($key)
    {
        if (array_key_exists($key, $_SESSION)) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Clear all session item
     */
    public function clearAll()
    {
        $_SESSION = [];
    }

    /**
     * Secret set session method
     *
     * @param $key
     * @param $value
     */
    public function __set($key, $value)
    {
        $this->set($key, $value);
    }

    /**
     * Secret get session item method
     *
     * @param $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * Secret check exists session item
     *
     * @param $key
     * @return bool
     */
    public function __isset($key)
    {
        return array_key_exists($key, $_SESSION);
    }

    /**
     * Secret unset session item
     *
     * @param $key
     */
    public function __unset($key)
    {
        $this->delete($key);
    }
}
