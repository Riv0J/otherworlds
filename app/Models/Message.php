<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message {
    const TYPE_INFO = 'info';
    const TYPE_SUCCESS = 'success';
    const TYPE_ALERT = 'warning';
    const TYPE_ERROR = 'danger';
    const TYPE_OTHER = 'other';
    const TYPE_BAN = 'ban';

    public $type, $icon, $text;

    public function __construct($type, $text) {
        $this->type = $type;
        $this->text = $text;

        // assign icon
        switch ($type) {
            case self::TYPE_INFO:
                $this->icon = 'fa-circle-info';
                break;
            case self::TYPE_SUCCESS:
                $this->icon = 'fa-check';
                break;
            case self::TYPE_ALERT:
                $this->icon = 'fa-circle-exclamation';
                break;
            case self::TYPE_ERROR:
                $this->icon = 'fa-triangle-exclamation';
                break;
            case self::TYPE_BAN:
                $this->type = self::TYPE_ERROR;
                $this->icon = 'fa-ban';
                break;
            default:
                $this->icon = 'fa-question';
                break;
        }
    }
}
