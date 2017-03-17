<?php

/*
 * This file is part of Glue
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\Glue;

use Assembly\ArrayDefinitionProvider;
use Assembly\ParameterDefinition;
use Assembly\Reference;
use Madewithlove\Glue\Dummies\Definitions\DummyServiceProvider;
use Madewithlove\Glue\ServiceProviders\DefinitionTypes\ExtendDefinition;
use Mockery;

class ContainerTest extends TestCase
{
    public function testDoesntResolveDefinitionTwice()
    {
        $container = new Container();
        $container->addServiceProvider(new DummyServiceProvider());

        $container->get('foo');
        $container->add('foo', 'baz');
        $container->get('foo');

        $this->assertEquals('baz', $container->get('foo'));
    }

    public function testCanAddExtensionsToProvider()
    {
        $service = Mockery::mock('foobar');
        $service->shouldReceive('someMethod')->once()->with('bar');

        $container = new Container();

        $container->addServiceProvider(new ArrayDefinitionProvider([
            'foobar' => (new ParameterDefinition($service)),
            'foo' => 'bar',
            'extenstion' => (new ExtendDefinition('foobar'))->addPropertyAssignment('foo', 'bar')->addMethodCall('someMethod', new Reference('foo')),
        ]));

        $container->get('foobar');
        $this->assertEquals('bar', $service->foo);
    }
}
