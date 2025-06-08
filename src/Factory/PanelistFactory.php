<?php

namespace App\Factory;

use App\Entity\Panelist;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Panelist>
 */
final class PanelistFactory extends PersistentProxyObjectFactory
{
    public function __construct()
    {
        parent::__construct();
    }

    public static function class(): string
    {
        return Panelist::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'firstname' => self::faker()->firstName(),
            'lastname' => self::faker()->lastName(),
            'email' => self::faker()->unique()->safeEmail(),
            'phone' => self::faker()->optional()->numerify('+###-#########'),
            'country' => self::faker()->countryCode(),
            'newsletterAgreement' => self::faker()->boolean(),
            'createdAt' => \DateTimeImmutable::createFromMutable(
                self::faker()->dateTimeBetween('-1 year', 'now')
            ),
            'deletedAt' => self::faker()->boolean(15) ? \DateTimeImmutable::createFromMutable(
                self::faker()->dateTimeBetween('-6 months', '-1 week')
            ) : null,
        ];
    }

    protected function initialize(): static
    {
        return $this// ->afterInstantiate(function(Panelist $panelist): void {})
            ;
    }
}
