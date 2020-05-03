<?php


namespace Modules\UserManagement\Repositories;


use Carbon\Carbon;
use Modules\UserManagement\Entities\CreatedUser;

class CreatedUsersRepository
{

    public function create($createdUser)
    {
        return CreatedUser::query()->create($createdUser);
    }

    public function updateOrCreate($where, $createdUser)
    {
        return CreatedUser::query()->updateOrCreate($where, $createdUser);
    }

    public function deleteByPortalUserId($portalUserId)
    {
        return CreatedUser::query()->where('portal_user_id', $portalUserId)->delete();
    }

    public function getAllWhereMailShouldBeSent()
    {
        return CreatedUser::query()
            ->with(['trackingShow.donation', 'portalUser.user', 'portalUser.variableSymbol'])
            ->whereNull('email_was_sent_at')
            ->whereDate('send_mail_at', '<=', Carbon::now())
            ->get();
    }

    public function markAsSent($id)
    {
        return CreatedUser::query()
            ->where('id', $id)
            ->update(['email_was_sent_at' =>Carbon::now()]);
    }
}
