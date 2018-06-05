<?php
declare(strict_types=1);

namespace Mleko\LetsPlay\Entity;


use Mleko\LetsPlay\ValueObject\Uuid;

class MatchSet
{
    /** @var Uuid */
    private $id;
    /** @var Uuid */
    private $ownerId;
    /** @var string */
    private $name;
    /** @var Match[] */
    private $matches = [];

    /**
     * MatchSet constructor.
     * @param string $name
     * @param Uuid $ownerId
     * @param Match[] $matches
     * @param Uuid $id
     */
    public function __construct(string $name, Uuid $ownerId, array $matches = [], Uuid $id = null) {
        $this->name = $name;
        $this->ownerId = $ownerId;
        $this->matches = $matches;
        $this->id = $id ?: new Uuid();
    }

    public function getId(): Uuid {
        return $this->id;
    }

    public function getOwnerId(): Uuid {
        return $this->ownerId;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    /**
     * @return Match[]
     */
    public function getMatches(): array {
        $matches = $this->matches;
        \usort($matches, function (Match $a, Match $b) {
            return $a->getStartDate() <=> $b->getStartDate();
        });
        return $matches;
    }

    public function addMatch(Match $match, int $position = -1): void {
        if (-1 === $position) {
            $this->matches[] = $match;
        } else {
            $this->matches = \array_splice($this->matches, $position, 0, [$match]);
        }
    }

    public function removeMatch(Match $match): void {
        $this->matches = \array_filter($this->matches, function ($e) use ($match) {
            return $e !== $match;
        });
    }
}
