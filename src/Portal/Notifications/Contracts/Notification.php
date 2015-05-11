<?php namespace Portal\Notifications\Contracts;

use MySecurePortal\OldPortal\Domain\Users\Models\User;

interface Notification {

    public function send($message, array $settings = [], User $user = null);

}