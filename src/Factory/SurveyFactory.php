<?php

namespace App\Factory;

use App\Entity\Survey;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Survey>
 */
final class SurveyFactory extends PersistentProxyObjectFactory
{
    public function __construct()
    {
        parent::__construct();
    }

    public static function class(): string
    {
        return Survey::class;
    }

    /**
     * Defines the default values for the Survey entity.
     */
    protected function defaults(): array|callable
    {
        return [
            'name' => self::faker()->words(3, true).' Survey',
            'status' => self::faker()->randomElement(['active', 'inactive']),
            'createdAt' => \DateTimeImmutable::createFromMutable(
                self::faker()->dateTimeBetween('-6 months', 'now')
            ),
            'deletedAt' => self::faker()->boolean(20) ? \DateTimeImmutable::createFromMutable(
                self::faker()->dateTimeBetween('-3 months', '-1 week')
            ) : null,
        ];
    }

    /**
     * Initialization hook for post-instantiation logic.
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Survey $survey): void {
            //     // Custom logic here
            // })
        ;
    }
}
