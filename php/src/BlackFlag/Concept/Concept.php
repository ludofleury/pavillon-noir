<?php

namespace BlackFlag\Concept;

use BlackFlag\Concept\Event\ConceptCreated;
use BlackFlag\Concept\Event\SetBackground;
use BlackFlag\Concept\Event\SpentCharacteristicsPoints;
use BlackFlag\Concept\Event\SpentExtraCharacteristicPoint;
use EventSourcing\AggregateRoot;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class Concept extends AggregateRoot
{
    const CHARACTERISTICS_POINTS = 45;

    private string $name;

    private array $characteristics;
    private int $characteristicsPoints;

    private string $background;
    private array $extraCharacteristicsPointsToSpend;

    protected function __construct()
    {
    }

    public static function create(string $name): Concept
    {
        $concept = new self();
        $concept->id = Uuid::uuid4();
        $event = new ConceptCreated($name);
        $concept->apply($event);

        return $concept;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function spendCharacteristicsPoints(string $characteristic, int $points)
    {
        $event = new SpentCharacteristicsPoints($characteristic, $points);
        $this->apply($event);
    }

    public function setBackground(string $background)
    {
        $event = new SetBackground($background);
        $this->apply($event);
    }

    public function spendExtraCharacteristicPoint(int $extraPointIndex, string $value)
    {
        $event = new SpentExtraCharacteristicPoint($extraPointIndex, $value);
        $this->apply($event);
    }

    protected function applyConceptCreated(ConceptCreated $event)
    {
        $this->name = $event->getName();
        $this->characteristics = [
            'Power' => 0,
            'Dexterity' => 0,
            'Strength' => 0,
            'Constitution' => 0,
            'Adaptability' => 0,
            'Knowledge' => 0,
            'Charisma' => 0,
            'Perception' => 0,
            'Expression' => 0,
        ];
        $this->characteristicsPoints = self::CHARACTERISTICS_POINTS;
        $this->extraCharacteristicsPointsToSpend = [];
    }

    protected function applySpentCharacteristicsPoints(SpentCharacteristicsPoints $event)
    {
        $characteristic = $event->getCharacteristic();
        $value = $event->getPoints();

        if ($characteristic === 'Constitution' && $value < 5) {
            throw new Exception('Constitution must be at least 5');
        }
        else if ($value < 3) {
            throw new Exception('No characteristic can be under 3');
        }

        if ($value > 7) {
            throw new Exception('No characteristic can be naturally over 7');
        }

        $this->characteristics[$characteristic] += $value;

        if ($value > 8) {
            throw new Exception('No characteristic can be over 8');
        }

        $this->characteristicsPoints -= $value;

        if ($this->characteristicsPoints < 0) {
            throw new Exception('You spent too many CharacteristicsPoints');
        }

    }

    protected function applySetBackground(SetBackground $event)
    {
        $this->background = $event->getBackground();

        if ($this->background === 'Noble') {
            $this->extraCharacteristicsPointsToSpend[] = ['Power', 'Perception'];
        } else {
            throw new Exception('Background not available');
        }
    }

    protected function applySpentExtraCharacteristicPoint(SpentExtraCharacteristicPoint $event) {
        $extraPointIndex = $event->getExtraPointIndex();
        $value = $event->getValue();

        if (!isset($this->extraCharacteristicsPointsToSpend[$extraPointIndex])) {
            throw new Exception('Extra point index not available');
        }

        if (!in_array($value, $this->extraCharacteristicsPointsToSpend[$extraPointIndex])) {
            throw new Exception('Selected value not available for this extra point');
        }

        $this->characteristics[$value] += 1;
        $this->extraCharacteristicsPointsToSpend[$extraPointIndex] = null;
     }
}