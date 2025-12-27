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
use TYPO3\CMS\Extbase\Attribute\Validate;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * A blog post comment
 */
class Comment extends AbstractEntity implements \Stringable
{
    protected \DateTime $date;

    #[Validate(validator: 'NotEmpty')]
    protected string $author = '';

    #[Validate(validator: 'EmailAddress')]
    protected string $email = '';

    #[Validate(validator: 'StringLength', options: ['maximum' => 500])]
    protected string $content = '';

    protected bool $hidden = true;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
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
     * Sets the authors email for this comment
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function isHidden(): bool
    {
        return $this->hidden;
    }

    public function setHidden(bool $hidden): void
    {
        $this->hidden = $hidden;
    }

    /**
     * Returns this comment as a formatted string
     */
    public function __toString(): string
    {
        return $this->author . ' (' . $this->email . ') said on ' . $this->date->format('Y-m-d') . ':' . chr(10) .
            $this->content . chr(10);
    }
}
