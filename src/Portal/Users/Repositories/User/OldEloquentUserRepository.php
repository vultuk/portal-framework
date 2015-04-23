<?php namespace Portal\Users\Repositories\User;

use MySecurePortal\OldPortal\Helpers;
use Portal\Users\Contracts\UserRepository;
use MySecurePortal\OldPortal\Domain\Users\Models\User as User;

class OldEloquentUserRepository implements UserRepository
{

    /**
     * Gets the details for the user
     *
     * @param integer $userId
     *
     * @return mixed
     */
    public function getUserDetails($userId = null)
    {
        $query = User::find($userId);

        return $query;
    }

    /**
     * Gets the URL to the users Image
     *
     * @param integer $userId
     *
     * @return mixed
     */
    public function getUserImage($userId = null)
    {
        // TODO: Implement getUserImage() method.
    }

    /**
     * Gets a list of all active users for the specified company
     *
     * @return mixed
     */
    public function getUserList()
    {
        $query = User::all();

        return $query;
    }



    /**
     * Gets the dialler ID for this user
     *
     * @param integer $userId
     *
     * @return mixed
     *
     * @deprecated From launch of the new portal based dialler
     */
    public function getDiallerId($userId = null)
    {
        $userDetails = $this->getUserDetails($userId);

        return rand(40,120);
    }

    /**
     * Returns the correct theme for the user.
     *
     * @param integer $userId
     *
     * @return mixed
     */
    public function getUserTheme($userId = null)
    {
        return 'portal.theme.';
    }
}