<?php

namespace App\Services;

use App\Repositories\EmailRepository;

class EmailService
{
    /**
     * @var $emailRepository
     */
    protected $emailRepostory;

    /**
     * EmailService constructor
     * 
     * @param EmailRepository $emailRepository
     */

    public function __construct(EmailRepository $emailRepository)
    {
        $this->emailRepostory = $emailRepository;
    }

    public function getAll()
    {
        return $this->emailRepostory->getAllEmail();
    }

    public function saveEmail($data)
    {
        $result = $this->emailRepostory->save($data);

        return $result;
    }
}