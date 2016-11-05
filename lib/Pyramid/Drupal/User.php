<?php

/**
 * @file
 *
 * ����D7/D8��User
 * D7һ��ֻ��������ȡֵ,��������ֻ��װȡֵ���
 */

namespace Pyramid\Drupal;

class User {

    protected $user;

    public function __construct($user) {
        $this->user = $user;
    }

    public function id() {
        return $this->user->uid;
    }
    
    public function __get($key) {
        return isset($this->user[$key]) ? $this->user[$key] : null;
    }

    function __call($method, $param) {
        static $keys = array(
            'username' => 'name',
            'email'    => 'mail',
            'lastaccessedtime' => 'access',
        );
        $key = preg_replace('/^get/', '', strtolower($method));
        $key = isset($keys[$key]) ? $keys[$key] : $key;
        return isset($this->user[$key]) ? $this->user[$key] : null;
    }

    public static function compat() {
        global $user;
        if (class_exists('Drupal\Core\Session\UserSession')) {
            return $user;
        } else {
            return new static($user);
        }
    }

}
