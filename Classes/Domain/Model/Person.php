<?php

declare(strict_types=1);

namespace FriendsOfTYPO3\BlogExample\Domain\Model;

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

use TYPO3\CMS\Extbase\Annotation\ORM\Transient;
use TYPO3\CMS\Extbase\Annotation\Validate;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * A person - acting as author
 */
class Person extends AbstractEntity
{
    /**
     * @Validate("StringLength", options={"maximum": 80})
     */
    protected string $firstname = '';

    /**
     * @Validate("StringLength", options={"minimum": 2, "maximum": 80})
     */
    protected string $lastname = '';

    /**
     * @Transient
     */
    protected string $fullname = '';

    /**
     * @Validate("EmailAddress")
     */
    protected string $email = '';

    /**
     * @var ObjectStorage<Tag>
     */
    protected ObjectStorage $tags;

    /**
     * @var ObjectStorage<Tag>
     */
    protected ObjectStorage $tagsSpecial;

    /**
     * Constructs a new Person
     */
    public function __construct(string $firstname, string $lastname, string $email)
    {
        $this->setFirstname($firstname);
        $this->setLastname($lastname);
        $this->setEmail($email);

        $this->tags = new ObjectStorage();
        $this->tagsSpecial = new ObjectStorage();
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getFullName(): string
    {
        $this->fullname = $this->firstname . ' ' . $this->lastname;
        return $this->fullname;
    }

    /**
     * @return ObjectStorage|Tag[]
     */
    public function getTags(): ObjectStorage|array
    {
        return $this->tags;
    }

    /**
     * @param ObjectStorage<Tag> $tags
     */
    public function setTags(ObjectStorage $tags): void
    {
        $this->tags = $tags;
    }

    public function addTag(Tag $tag): void
    {
        $this->tags->attach($tag);
    }

    public function removeTag(Tag $tag): void
    {
        $this->tags->detach($tag);
    }

    /**
     * @return ObjectStorage|Tag[]
     */
    public function getTagsSpecial(): ObjectStorage|array
    {
        return $this->tagsSpecial;
    }

    /**
     * @param ObjectStorage<Tag> $tagsSpecial
     */
    public function setTagsSpecial(ObjectStorage $tagsSpecial): void
    {
        $this->tagsSpecial = $tagsSpecial;
    }

    public function addTagSpecial(Tag $tag): void
    {
        $this->tagsSpecial->attach($tag);
    }

    public function removeTagSpecial(Tag $tag): void
    {
        $this->tagsSpecial->detach($tag);
    }
}
