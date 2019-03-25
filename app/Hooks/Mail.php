<?php

namespace App\Hooks;

use Themosis\Hook\Hookable;
use Themosis\Support\Facades\Action;
use Themosis\Support\Facades\Filter;

class Mail extends Hookable
{
    /**
     * WordPress SMTP configuration.
     */
    public function register()
    {
        Action::add('phpmailer_init', function ($phpmailer) {
            $phpmailer->isSMTP();
            $phpmailer->Host = config('mail.host');
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = config('mail.port');
            $phpmailer->Username = config('mail.username');
            $phpmailer->Password = config('mail.password');
            $phpmailer->SMTPSecure = false;
        });

        Filter::add('wp_mail_from', function () {
            return config('mail.from.address');
        });

        Filter::add('wp_mail_from_name', function () {
            return config('mail.from.name');
        });
    }
}
