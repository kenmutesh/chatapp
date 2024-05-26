<?php

    use App\Http\Resources\UserResource;
    use App\Models\Group;
    use App\Models\User;
    use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('online', function (User $user) {
    return $user ? new UserResource($user) : null;
});

Broadcast::channel('message.user.{userId1}-{userId2}', function (User $user, int $userId1, int $userId2){
    return $user->id  === $userId1 || $user->id === $userId2 ? $user : null;
});

Broadcast::channel('message.group.{group_id}', function (User $user, int $group_id){
   return $user->groups->contains('id', $group_id) ? $user : null;
});
