<?php namespace App\Repos;

use App\User;

class UserRepo
{
    protected $user;

    /**
     * UserRepo constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function getByEmail($email)
    {
        return $this->user->where('email', '=', $email)->first();
    }

    /**
     * @param int $id
     * @return User
     */
    public function getById($id)
    {
        return $this->user->findOrFail($id);
    }



    /**
     * Creates a new user and attaches a role to them.
     * @param array $data
     * @return User
     */
    public function registerNew(array $data)
    {
        $user = $this->create($data);

        return $user;
    }


    /**
     * Create a new basic instance of user.
     * @param array $data
     * @return User
     */
    public function create(array $data)
    {
        return $this->user->forceCreate([
            'user'     => $data['user'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
