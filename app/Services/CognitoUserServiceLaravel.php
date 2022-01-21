<?php

namespace App\Services;

use App\Traits\LocalGroupsTrait;
use Illuminate\Support\Facades\File;
use App\User;
use Pfizer\CognitoAuthLaravel\Exceptions\OpenRegistrationClosedException;
use Pfizer\CognitoAuthLaravel\Services\CognitoUserServiceLaravel as CognitoUserServiceLaravelOriginal;

class CognitoUserServiceLaravel extends CognitoUserServiceLaravelOriginal
{

    use LocalGroupsTrait;


    /**
     * @param object $id_token
     * @return User
     * @throws \Exception
     */
    public function mapToUser(object $id_token): User
    {
        $parsed = $this->parseIncomingUser($id_token);

        if ($user_found = $this->findUser($parsed['email'])) {
            $this->addUserToGroups($user_found);
            return $user_found;
        }

        if (!$this->openRegistrationIsOn()) {
            throw new OpenRegistrationClosedException();
        }

        $userCreated = $this->user->create($parsed);
        $this->addUserToGroups($userCreated);
        return $userCreated;
    }

    /** @phpstan-ignore-next-line */
    protected function formatCustomFields($user)
    {
        if (property_exists($user, "custom:ntid")) {
            $this->ntid = $user->{"custom:ntid"};
        }

        if (property_exists($user, "custom:grouplist")) {
            $group_list = $user->{"custom:grouplist"};
            $group_list = str_replace([
                ']',
                '['
            ], "", $group_list);
            /** @phpstan-ignore-next-line */
            $this->group_list = explode(",", $group_list);
            $this->group_list = array_map('trim', $this->group_list);
            $this->updateLocalGroups($this->group_list);
        }
    }
}
