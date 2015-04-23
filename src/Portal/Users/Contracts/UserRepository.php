<?php namespace Portal\Users\Contracts;

/**
 * Interface UserRepository
 *
 * @package Portal\Users\Contracts
 */
interface UserRepository {

    /**
     * Gets the details for the user
     *
     * @param integer $userId
     *
     * @return mixed
     */
    public function getUserDetails($userId = null);

    /**
     * Gets the URL to the users Image
     *
     * @param integer $userId
     *
     * @return mixed
     */
    public function getUserImage($userId = null);

    /**
     * Gets a list of all active users for the specified company
     *
     * @return mixed
     */
    public function getUserList();

    /**
     * Returns the correct theme for the user.
     *
     * @param integer $userId
     *
     * @return mixed
     */
    public function getUserTheme($userId = null);

    /**
     * Gets the dialler ID for this user
     *
     * @param integer $userId
     *
     * @return mixed
     *
     * @deprecated From launch of the new portal based dialler
     */
    public function getDiallerId($userId = null);

}
