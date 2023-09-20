<?php

namespace App\Models;

use App\Notifications\FcmNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Notification as NotificationsNotification;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'user_id'];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::created(function (Notification $notification) {
            NotificationsNotification::send($notification->user, new FcmNotification($notification->title, $notification->body, [], null));
        });
    }

    /**
     * Get the user that owns the Notification
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
