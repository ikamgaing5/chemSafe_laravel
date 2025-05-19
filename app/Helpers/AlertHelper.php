<?php

namespace App\Helpers;

class AlertHelper
{
    public static function message($message, $type)
    {
        if ($type === 'success') {
            $color = 'success';
            $alert = 'Succès';
            $icon = "<svg viewBox='0 0 24 24' width='24' height='24' stroke='currentColor' stroke-width='2' fill='none' stroke-linecap='round' stroke-linejoin='round' class='me-2'><polyline points='9 11 12 14 22 4'></polyline><path d='M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11'></path></svg>";
        } else {
            $color = 'danger';
            $alert = 'Échec';
            $icon = '<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>';
        }

        return "<div class='mx-1'>
                    <div class='alert alert-{$color} solid alert-dismissible fade show'>
                        {$icon} <strong>{$alert} !</strong> {$message} !
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='btn-close'></button>
                    </div>
                </div>";
    }
}
