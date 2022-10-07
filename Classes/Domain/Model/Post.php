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

use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\Validate;
use TYPO3\CMS\Extbase\Domain\Model\Category;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * A blog post
 */
class Post extends AbstractEntity
{
    protected Blog $blog;

    #[Validate(['validator' => 'StringLength', 'options' => ['minimum' => 3, 'maximum' => 50]])]
    protected string $title = '';

    /**
     * @var \DateTime
     */
    protected \DateTime $date;

    /**
     * @var Person
     */
    protected ?Person $author = null;
    protected ?Person $secondAuthor = null;
    protected ?Person $reviewer = null;

    #[Validate(['validator' => 'StringLength', 'options' => ['minimum' => 3]])]
    protected string $content = '';

    /**
     * @var ObjectStorage<Tag>
     */
    public ObjectStorage $tags;

    /**
     * @var ObjectStorage<Category>
     */
    public ObjectStorage $categories;

    /**
     * @var ObjectStorage<Comment>
     */
    #[Extbase\ORM\Lazy()]
    #[Cascade(['value' => 'remove'])]
    public ObjectStorage $comments;

    /**
     * @var ObjectStorage<Post>
     */
    #[Extbase\ORM\Lazy()]
    public ObjectStorage $relatedPosts;

    /**
     * 1:1 optional relation
     */
    #[Cascade(['value' => 'remove'])]
    public ?Info $additionalName;

    /**
     * 1:1 optional relation
     */
    #[Cascade(['value' => 'remove'])]
    protected ?Info $additionalInfo;

    /**
     * 1:n relation stored as CSV value
     * @var ObjectStorage<Comment>
     */
    #[Extbase\ORM\Lazy()]
    public ObjectStorage $additionalComments;

    public function __construct()
    {
        $this->tags = new ObjectStorage();
        $this->categories = new ObjectStorage();
        $this->comments = new ObjectStorage();
        $this->relatedPosts = new ObjectStorage();
        $this->date = new \DateTime();
        $this->additionalComments = new ObjectStorage();
    }

    /**
     * Set one or more Tag objects
     *
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

    public function removeAllTags(): void
    {
        $this->tags = new ObjectStorage();
    }

    /**
     * Getter for tags, A storage holding objects
     * Note: We return a clone of the tags because they must not be modified as they are Value Objects
     *
     * @return ObjectStorage<Tag>
     */
    public function getTags(): ObjectStorage
    {
        return clone $this->tags;
    }

    /**
     * Add category to a post
     */
    public function addCategory(Category $category): void
    {
        $this->categories->attach($category);
    }

    /**
     * Set categories
     *
     * @param ObjectStorage<Category> $categories
     */
    public function setCategories(ObjectStorage $categories): void
    {
        $this->categories = $categories;
    }

    /**
     * Get categories
     *
     * @return ObjectStorage<Category>
     */
    public function getCategories(): ObjectStorage
    {
        return $this->categories;
    }

    /**
     * Remove category from post
     */
    public function removeCategory(Category $category): void
    {
        $this->categories->detach($category);
    }

    /**
     * Sets the author for this post
     */
    public function setAuthor(Person $author): void
    {
        $this->author = $author;
    }

    /**
     * Getter for author
     */
    public function getAuthor(): ?Person
    {
        return $this->author;
    }

    public function getSecondAuthor(): ?Person
    {
        return $this->secondAuthor;
    }

    public function setSecondAuthor(Person $secondAuthor): void
    {
        $this->secondAuthor = $secondAuthor;
    }

    public function getReviewer(): ?Person
    {
        return $this->reviewer;
    }

    public function setReviewer(Person $reviewer): void
    {
        $this->reviewer = $reviewer;
    }

    /**
     * Set the comments to this post, an Object Storage of related Comment instances
     *
     * @param ObjectStorage<Comment> $comments
     */
    public function setComments(ObjectStorage $comments): void
    {
        $this->comments = $comments;
    }

    /**
     * Adds a comment to this post
     */
    public function addComment(Comment $commentToAdd): void
    {
        $this->comments->attach($commentToAdd);
    }

    /**
     * Removes Comment from this post and deletes it due to annotation `@Cascade("remove")`
     */
    public function removeComment(Comment $commentToDelete): void
    {
        $this->comments->detach($commentToDelete);
    }

    /**
     * @TODO: explain what's done in the method an why
     */
    public function removeAllComments(): void
    {
        $comments = clone $this->comments;
        $this->comments->removeAll($comments);
    }

    /**
     * Returns the comments to this post
     *
     * @return ObjectStorage<Comment>
     */
    public function getComments(): ObjectStorage
    {
        return $this->comments;
    }

    /**
     * Set the related posts with ObjectStorage containing the instances of relatedPosts
     *
     * @param ObjectStorage<Post> $relatedPosts
     */
    public function setRelatedPosts(ObjectStorage $relatedPosts): void
    {
        $this->relatedPosts = $relatedPosts;
    }

    public function addRelatedPost(Post $post): void
    {
        $this->relatedPosts->attach($post);
    }

    public function removeAllRelatedPosts(): void
    {
        $relatedPosts = clone $this->relatedPosts;
        $this->relatedPosts->removeAll($relatedPosts);
    }

    /**
     * Returns the related posts
     *
     * @return ObjectStorage<Post>
     */
    public function getRelatedPosts(): ObjectStorage
    {
        return $this->relatedPosts;
    }

    /**
     * @return ObjectStorage
     */
    public function getAdditionalComments(): ObjectStorage
    {
        return $this->additionalComments;
    }

    /**
     * @param ObjectStorage $additionalComments
     */
    public function setAdditionalComments(ObjectStorage $additionalComments): void
    {
        $this->additionalComments = $additionalComments;
    }

    /**
     * @param Comment $comment
     */
    public function addAdditionalComment(Comment $comment): void
    {
        $this->additionalComments->attach($comment);
    }

    /**
     * Remove all additional Comments
     */
    public function removeAllAdditionalComments(): void
    {
        $comments = clone $this->additionalComments;
        $this->additionalComments->removeAll($comments);
    }

    public function removeAdditionalComment(Comment $comment): void
    {
        $this->additionalComments->detach($comment);
    }

    /**
     * @return Blog
     */
    public function getBlog(): Blog
    {
        return $this->blog;
    }

    /**
     * @param Blog $blog
     */
    public function setBlog(Blog $blog): void
    {
        $this->blog = $blog;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return Info|null
     */
    public function getAdditionalName(): ?Info
    {
        return $this->additionalName;
    }

    /**
     * @param Info|null $additionalName
     */
    public function setAdditionalName(?Info $additionalName): void
    {
        $this->additionalName = $additionalName;
    }

    public function getAdditionalInfo(): ?Info
    {
        return $this->additionalInfo;
    }

    public function setAdditionalInfo(?Info $additionalInfo): void
    {
        $this->additionalInfo = $additionalInfo;
    }

    /**
     * Returns this post as a formatted string
     */
    public function __toString(): string
    {
        return $this->title . chr(10) .
            ' written on ' . $this->date->format('Y-m-d') . chr(10) .
            ' by ' . $this->author->getFullName() . chr(10) .
            wordwrap($this->content, 70, chr(10)) . chr(10) .
            implode(', ', $this->tags->toArray());
    }
}
