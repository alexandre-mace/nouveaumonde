<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProposalRepository")
 */
class Proposal
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $economic;

    /**
     * @ORM\Column(type="text")
     */
    private $juridic;

    /**
     * @ORM\Column(type="text")
     */
    private $environmental;

    /**
     * @ORM\Column(type="text")
     */
    private $education;

    /**
     * @ORM\Column(type="text")
     */
    private $cultural;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="likedProposals")
     * @ORM\JoinTable(name="proposal_likes")
     */
    private $likes;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="dislikedProposals")
     * @ORM\JoinTable(name="proposal_dislikes")
     */
    private $dislikes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="ownedProposals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    public function __construct()
    {
        $this->likes = new ArrayCollection();
        $this->dislikes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getEconomic(): ?string
    {
        return $this->economic;
    }

    public function setEconomic(string $economic): self
    {
        $this->economic = $economic;

        return $this;
    }

    public function getJuridic(): ?string
    {
        return $this->juridic;
    }

    public function setJuridic(string $juridic): self
    {
        $this->juridic = $juridic;

        return $this;
    }

    public function getEnvironmental(): ?string
    {
        return $this->environmental;
    }

    public function setEnvironmental(string $environmental): self
    {
        $this->environmental = $environmental;

        return $this;
    }

    public function getEducation(): ?string
    {
        return $this->education;
    }

    public function setEducation(string $education): self
    {
        $this->education = $education;

        return $this;
    }

    public function getCultural(): ?string
    {
        return $this->cultural;
    }

    public function setCultural(string $cultural): self
    {
        $this->cultural = $cultural;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(User $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
        }

        return $this;
    }

    public function removeLike(User $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getDislikes(): Collection
    {
        return $this->dislikes;
    }

    public function addDislike(User $dislike): self
    {
        if (!$this->dislikes->contains($dislike)) {
            $this->dislikes[] = $dislike;
        }

        return $this;
    }

    public function removeDislike(User $dislike): self
    {
        if ($this->dislikes->contains($dislike)) {
            $this->dislikes->removeElement($dislike);
        }

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
}
