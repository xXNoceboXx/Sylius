<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\Bundle\CoreBundle\Tests\Fixture;

use Doctrine\Persistence\ObjectManager;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use PHPUnit\Framework\TestCase;
use Sylius\Bundle\CoreBundle\Fixture\ChannelFixture;
use Sylius\Bundle\CoreBundle\Fixture\Factory\ExampleFactoryInterface;

final class ChannelFixtureTest extends TestCase
{
    use ConfigurationTestCaseTrait;

    /**
     * @test
     */
    public function channels_are_optional(): void
    {
        $this->assertConfigurationIsValid([[]], 'custom');
    }

    /**
     * @test
     */
    public function channels_can_be_generated_randomly(): void
    {
        $this->assertConfigurationIsValid([['random' => 4]], 'random');
        $this->assertPartialConfigurationIsInvalid([['random' => -1]], 'random');
    }

    /**
     * @test
     */
    public function channel_code_is_optional(): void
    {
        $this->assertConfigurationIsValid([['custom' => [['code' => 'CUSTOM']]]], 'custom.*.code');
    }

    /**
     * @test
     */
    public function channel_hostname_is_optional(): void
    {
        $this->assertConfigurationIsValid([['custom' => [['hostname' => 'custom.localhost']]]], 'custom.*.hostname');
    }

    /**
     * @test
     */
    public function channel_color_is_optional(): void
    {
        $this->assertConfigurationIsValid([['custom' => [['color' => 'pink']]]], 'custom.*.color');
    }

    /**
     * @test
     */
    public function channel_may_be_toggled(): void
    {
        $this->assertConfigurationIsValid([['custom' => [['enabled' => false]]]], 'custom.*.enabled');
    }

    /**
     * @test
     */
    public function channel_locales_are_optional(): void
    {
        $this->assertConfigurationIsValid([['custom' => [['locales' => ['en_US', 'pl_PL']]]]], 'custom.*.locales');
        $this->assertProcessedConfigurationEquals(
            [['custom' => [['locales' => []]]]],
            ['custom' => [['locales' => []]]],
            'custom.*.locales',
        );
        $this->assertProcessedConfigurationEquals(
            [['custom' => [['locales' => null]]]],
            ['custom' => [[]]],
            'custom.*.locales',
        );
    }

    /**
     * @test
     */
    public function channel_currencies_are_optional(): void
    {
        $this->assertConfigurationIsValid([['custom' => [['currencies' => ['USD', 'PLN']]]]], 'custom.*.currencies');
        $this->assertProcessedConfigurationEquals(
            [['custom' => [['currencies' => []]]]],
            ['custom' => [['currencies' => []]]],
            'custom.*.currencies',
        );
        $this->assertProcessedConfigurationEquals(
            [['custom' => [['currencies' => null]]]],
            ['custom' => [[]]],
            'custom.*.currencies',
        );
    }

    /**
     * @test
     */
    public function channel_contact_email_is_optional(): void
    {
        $this->assertConfigurationIsValid(
            [['custom' => [['contact_email' => 'contact@example.com']]]],
            'custom.*.contact_email',
        );
    }

    /**
     * @test
     */
    public function authentication_required_may_be_toggled(): void
    {
        $this->assertConfigurationIsValid([['custom' => [['account_verification_required' => false]]]], 'custom.*.account_verification_required');
    }

    protected function getConfiguration(): ChannelFixture
    {
        return new ChannelFixture(
            $this->getMockBuilder(ObjectManager::class)->getMock(),
            $this->getMockBuilder(ExampleFactoryInterface::class)->getMock(),
        );
    }
}
