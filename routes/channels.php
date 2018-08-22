<?php

use App\Broadcasting\LobbyChannel;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// ---> Broadcasting Events
Broadcast::routes();
Broadcast::channel('lobby.{session}', LobbyChannel::class);
