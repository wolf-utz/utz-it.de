<?php

namespace App\Entity;

use App\Repository\InquiryRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: InquiryRepository::class)]
class Inquiry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'validation.error.not_blank')]
    #[Assert\Email(message: 'validation.error.invalidEmail')]
    private string $email = '';

    #[ORM\Column(length: 255)]
    private string $name = '';

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank(message: 'validation.error.not_blank')]
    private string $message = '';

    #[Assert\IsTrue(message: 'validation.error.not_true')]
    private bool $acceptDataPrivacy = false;

    #[ORM\Column(type: 'datetime')]
    private DateTime $createAt;

    public function __construct()
    {
        $this->createAt = new DateTime();
    }

    public static function build(string $email, string $name, string $message): self
    {
        $inquiry = new Inquiry();
        $inquiry->setEmail($email);
        $inquiry->setName($name);
        $inquiry->setMessage($message);
        $inquiry->setCreateAt(new DateTime());

        return $inquiry;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function isAcceptDataPrivacy(): bool
    {
        return $this->acceptDataPrivacy;
    }

    public function setAcceptDataPrivacy(bool $acceptDataPrivacy): void
    {
        $this->acceptDataPrivacy = $acceptDataPrivacy;
    }

    public function getCreateAt(): DateTime
    {
        return $this->createAt;
    }

    public function setCreateAt(DateTime $createAt): void
    {
        $this->createAt = $createAt;
    }
}