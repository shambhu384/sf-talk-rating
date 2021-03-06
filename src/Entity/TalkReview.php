<?php

namespace App\Entity;

use App\Model\TalkTags;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TalkReviewRepository")
 */
class TalkReview
{
    const STATUS_PENDING_MODERATION = 'pending_moderation';
    const STATUS_ONLINE = 'online';
    const STATUS_REFUSED = 'refused';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Talk", inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $talk;

    /**
     * @ORM\Embedded(class="App\Entity\SfConnectUser", columnPrefix="author_")
     */
    private $author;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $postedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="integer")
     */
    private $rating;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $selectedTags = [];

    /**
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $contentRating;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $deliveryRating;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $relevanceRating;

    public function __construct(Talk $talk, SfConnectUser $author)
    {
        $this->talk = $talk;
        $this->author = $author;
        $this->postedAt = new \DateTimeImmutable();
        $this->status = self::STATUS_PENDING_MODERATION;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTalk(): ?Talk
    {
        return $this->talk;
    }

    public function getAuthor(): SfConnectUser
    {
        return $this->author;
    }

    public function getPostedAt(): ?\DateTimeImmutable
    {
        return $this->postedAt;
    }

    public function setPostedAt(\DateTimeImmutable $postedAt): self
    {
        $this->postedAt = $postedAt;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getSelectedTags(): ?array
    {
        return $this->selectedTags;
    }

    public function setSelectedTags(?array $selectedTags): self
    {
        $this->selectedTags = $selectedTags;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getContentRating(): ?int
    {
        return $this->contentRating;
    }

    public function setContentRating(?int $contentRating): self
    {
        $this->contentRating = $contentRating;

        return $this;
    }

    public function getDeliveryRating(): ?int
    {
        return $this->deliveryRating;
    }

    public function setDeliveryRating(?int $deliveryRating): self
    {
        $this->deliveryRating = $deliveryRating;

        return $this;
    }

    public function getRelevanceRating(): ?int
    {
        return $this->relevanceRating;
    }

    public function setRelevanceRating(?int $relevanceRating): self
    {
        $this->relevanceRating = $relevanceRating;

        return $this;
    }

    public function getPrettyHighlights(): string
    {
        $labels = [];

        foreach ($this->selectedTags as $tag) {
            if (isset(TalkTags::getAllWithLabel()[$tag])) {
                $labels[] = TalkTags::getAllWithLabel()[$tag];
            }
        }

        return $labels ? implode(', ', $labels) : 'None';
    }
}
