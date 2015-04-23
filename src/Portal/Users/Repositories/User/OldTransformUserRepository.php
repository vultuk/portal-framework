<?php namespace Portal\Users\Repositories\User;

use IlluminateExtensions\Support\Collection;
use Portal\Users\Contracts\UserRepository;

class OldTransformUserRepository implements UserRepository {

    protected $repository;

    function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Gets the details for the user
     *
     * @param integer $userId
     *
     * @return mixed
     */
    public function getUserDetails($userId = null)
    {
        return $this->transformUserDetails($this->repository->getUserDetails($userId));
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
        return $this->repository->getUserImage($userId);
    }

    /**
     * Gets a list of all active users for the specified company
     *
     * @return mixed
     */
    public function getUserList()
    {
        // Get the user list from the repository
        $userList = $this->repository->getUserList();

        // Create a new Collection
        $collection = new Collection();

        // Add all results into the collection
        array_map(function($c) use(&$collection) {
            $collection->push($this->transformUserDetails($c));
        }, is_null($userList) ? [] : $userList->toArray());

        // Return the collection
        return $collection;
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
        return $this->repository->getUserTheme($userId);
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
        return $this->repository->getDiallerId($userId);
    }


    private function transformUserDetails($userClass = null)
    {
        return [
            'id' => $userClass['id'],
            'firstName' => $userClass['first_name'],
            'lastName' => $userClass['last_name'],
            'email' => $userClass['email'],
        ];
    }
}