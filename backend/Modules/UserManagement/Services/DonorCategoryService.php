<?php
/**
 * Created by IntelliJ IDEA.
 * User: notebook
 * Date: 18. 9. 2019
 * Time: 15:43
 */

namespace Modules\UserManagement\Services;


use Modules\UserManagement\Repositories\DonorCategoryRepository;

class DonorCategoryService
{
    protected $rep;

    public function __construct(DonorCategoryRepository $rep)
    {
        $this->rep = $rep;

    }

    public function get()
    {
        return $this->rep->get();
    }

    public function getById()
    {
        return $this->rep->get();
    }

}