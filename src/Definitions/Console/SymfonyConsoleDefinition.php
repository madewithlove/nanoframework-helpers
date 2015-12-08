<?php

/*
 * This file is part of Glue
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\Glue\Definitions\Console;

use Assembly\ObjectDefinition;
use Assembly\Reference;
use Interop\Container\Definition\DefinitionProviderInterface;
use League\Container\ContainerAwareInterface;
use League\Container\ContainerAwareTrait;
use Madewithlove\Glue\Console\Commands\BootstrapCommand;
use Madewithlove\Glue\Console\Commands\ConfigurationCommand;
use Madewithlove\Glue\Console\Commands\TinkerCommand;
use Madewithlove\Glue\Glue;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;

class SymfonyConsoleDefinition extends \Madewithlove\Definitions\Console\SymfonyConsoleDefinition
{
    /**
     * @var Command[]|string[]
     */
    protected $commands;

    /**
     * @param string[]|Command[] $commands
     */
    public function __construct($commands = [])
    {
        parent::__construct('Glue', Glue::VERSION, $commands);
    }

    /**
     * Create a new instance of SymfonyConsoleDefintion
     * with Glue's default commands.
     *
     * @param array $commands
     *
     * @return SymfonyConsoleDefinition
     */
    public static function withDefaultCommands(array $commands = [])
    {
        return new self(array_merge($commands, [
            BootstrapCommand::class,
            TinkerCommand::class,
            ConfigurationCommand::class,
        ]));
    }
}
