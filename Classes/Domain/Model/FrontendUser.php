<?php

declare(strict_types=1);

namespace T3docs\BlogExample\Domain\Model;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * A frontend user
 */
class FrontendUser extends AbstractEntity
{
    /**
     * @var ObjectStorage<FrontendUserGroup>|null
     */
    protected ObjectStorage|null $usergroup;
    public string $name = '';
    public string $email = '';
    public \DateTime|null $lastlogin;

    public function __construct()
    {
        $this->usergroup = new ObjectStorage();
    }

    /**
     * Called again with initialize object, as fetching an entity from the DB does not use the constructor
     */
    public function initializeObject(): void
    {
        $this->usergroup = $this->usergroup ?? new ObjectStorage();
    }

    /**
     * Sets the usergroups. Keep in mind that the property is called "usergroup"
     * although it can hold several usergroups.
     *
     * @param ObjectStorage<FrontendUserGroup> $usergroup
     */
    public function setUsergroup(ObjectStorage $usergroup): void
    {
        $this->usergroup = $usergroup;
    }

    /**
     * Adds a usergroup to the frontend user
     */
    public function addUsergroup(FrontendUserGroup $usergroup): void
    {
        $this->usergroup?->attach($usergroup);
    }

    /**
     * Removes a usergroup from the frontend user
     */
    public function removeUsergroup(FrontendUserGroup $usergroup): void
    {
        $this->usergroup?->detach($usergroup);
    }

    /**
     * Returns the usergroups. Keep in mind that the property is called "usergroup"
     * although it can hold several usergroups.
     *
     * @return ObjectStorage<FrontendUserGroup> An object storage containing the usergroup
     */
    public function getUsergroup(): ObjectStorage
    {
        $this->usergroup = $this->usergroup ?? new ObjectStorage();
        return $this->usergroup;
    }
}
