<?php


namespace Modules\UserManagement\Services;


use Modules\UserManagement\Repositories\CreatedUsersRepository;

class CreatedUsersService
{
    private $rep;


    /**
     * CreatedUsersService constructor.
     */
    public function __construct()
    {
        $this->rep = new CreatedUsersRepository();

    }


    public function create($createdUser)
    {
        return $this->rep->create($createdUser);
    }

    public function updateOrCreate($where, $createdUser)
    {
        return $this->rep->updateOrCreate($where, $createdUser);
    }

    public function getAllWhereMailShouldBeSent()
    {
        return $this->rep->getAllWhereMailShouldBeSent();
    }

    public function markAsSent($id)
    {
        return $this->rep->markAsSent($id);

    }

    public function deleteByPortalUserId($portalUserId)
    {
        return $this->rep->deleteByPortalUserId($portalUserId);
    }

}