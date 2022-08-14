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

use TYPO3\CMS\Extbase\Domain\Model\Category;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Annotation\Validate;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;

/**
 * A blog post
 */
class Post extends AbstractEntity
{
    protected Blog $blog;

    /**
     * @Validate("StringLength", options={"minimum": 3, "maximum": 50})
     */
    protected string $title = '';

    /**
     * @var \DateTime
     */
    protected \DateTime $date;

    /**
     * @var Person
     */
    protected Person $author;
    protected ?Person $secondAuthor = null;
    protected ?Person $reviewer = null;

    /**
     * @Validate("StringLength", options={"minimum": 3})
     */
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
     * @Lazy
     * @Cascade("remove")
     */
    public ObjectStorage $comments;

    /**
     * @var ObjectStorage<Post>
     * @Lazy
     */
    public ObjectStorage $relatedPosts;

    /**
     * 1:1 optional relation
     * @Cascade("remove")
     */
    public ?Info $additionalName;

    /**
     * 1:1 optional relation
     * @Cascade("remove")
     */
    protected ?Info $additionalInfo;

    /**
     * 1:n relation stored as CSV value
     * @var ObjectStorage<Comment>
     * @Lazy
     */
    public ObjectStorage $additionalComments;

    /**
     * Constructs this post
     */
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
     * Setter for tags
     *
     * @param ObjectStorage $tags One or more Tag objects
     */
    public function setTags(ObjectStorage $tags)
    {
        $this->tags = $tags;
    }

    /**
     * Adds a tag to this post
     *
     * @param Tag $tag
     */
    public function addTag(Tag $tag)
    {
        $this->tags->attach($tag);
    }

    /**
     * Removes a tag from this post
     *
     * @param Tag $tag
     */
    public function removeTag(Tag $tag)
    {
        $this->tags->detach($tag);
    }

    /**
     * Remove all tags from this post
     */
    public function removeAllTags()
    {
        $this->tags = new ObjectStorage();
    }

    /**
     * Getter for tags
     * Note: We return a clone of the tags because they must not be modified as they are Value Objects
     *
     * @return ObjectStorage A storage holding objects
     */
    public function getTags()
    {
        return clone $this->tags;
    }

    /**
     * Add category to a post
     */
    public function addCategory(Category $category)
    {
        $this->categories->attach($category);
    }

    /**
     * Set categories
     *
     * @param ObjectStorage $categories
     */
    public function setCategories(ObjectStorage $categories)
    {
        $this->categories = $categories;
    }

    /**
     * Get categories
     *
     * @return ObjectStorage
     */
    public function getCategories(): ObjectStorage
    {
        return $this->categories;
    }

    /**
     * Remove category from post
     */
    public function removeCategory(Category $category)
    {
        $this->categories->detach($category);
    }

    /**
     * Sets the author for this post
     */
    public function setAuthor(Person $author)
    {
        $this->author = $author;
    }

    /**
     * Getter for author
     */
    public function getAuthor(): Person
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

    public function setReviewer(Person $reviewer)
    {
        $this->reviewer = $reviewer;
    }

    /**
     * Setter for the comments to this post
     *
     * @param ObjectStorage $comments An Object Storage of related Comment instances
     */
    public function setComments(ObjectStorage $comments)
    {
        $this->comments = $comments;
    }

    /**
     * Adds a comment to this post
     */
    public function addComment(Comment $comment)
    {
        $this->comments->attach($comment);
    }

    /**
     * Removes Comment from this post
     */
    public function removeComment(Comment $commentToDelete)
    {
        $this->comments->detach($commentToDelete);
    }

    /**
     * Remove all comments from this post
     */
    public function removeAllComments()
    {
        $comments = clone $this->comments;
        $this->comments->removeAll($comments);
    }

    /**
     * Returns the comments to this post
     *
     * @return ObjectStorage holding instances of Comment
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Setter for the related posts
     *
     * @param ObjectStorage $relatedPosts An Object Storage containing related Posts instances
     */
    public function setRelatedPosts(ObjectStorage $relatedPosts)
    {
        $this->relatedPosts = $relatedPosts;
    }

    /**
     * Adds a related post
     *
     * @param Post $post
     */
    public function addRelatedPost(Post $post)
    {
        $this->relatedPosts->attach($post);
    }

    /**
     * Remove all related posts
     */
    public function removeAllRelatedPosts()
    {
        $relatedPosts = clone $this->relatedPosts;
        $this->relatedPosts->removeAll($relatedPosts);
    }

    /**
     * Returns the related posts
     *
     * @return ObjectStorage holding instances of Post
     */
    public function getRelatedPosts()
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
    public function setAdditionalComments(ObjectStorage $additionalComments
    ): void {
        $this->additionalComments = $additionalComments;
    }

    /**
     * @param Comment $comment
     */
    public function addAdditionalComment(Comment $comment)
    {
        $this->additionalComments->attach($comment);
    }

    /**
     * Remove all additional Comments
     */
    public function removeAllAdditionalComments()
    {
        $comments = clone $this->additionalComments;
        $this->additionalComments->removeAll($comments);
    }

    public function removeAdditionalComment(Comment $comment)
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
     *
     * @return string
     */
    public function __toString()
    {
        return $this->title . chr(10) .
            ' written on ' . $this->date->format('Y-m-d') . chr(10) .
            ' by ' . $this->author->getFullName() . chr(10) .
            wordwrap($this->content, 70, chr(10)) . chr(10) .
            implode(', ', $this->tags->toArray());
    }
}
