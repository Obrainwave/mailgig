<?php 

namespace App\Repositories;

use App\Models\Users\EmailAccount;

class EmailRepository
{
    /**
     * @var EmailAccount
     */
    protected $email;

    /**
     * EmailRepository constructor
     * 
     * @param EmailAccount $email
     */
    public function __construct(EmailAccount $email)
    {
        $this->email = $email;
    }

    public function getAllEmail()
    {
        return $this->email->get();
    }

    public function save($data)
    {
        $this->email::create($data);
    }
}