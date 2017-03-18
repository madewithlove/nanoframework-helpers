<?php

/*
 * This file is part of Glue
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\Glue\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProcessHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class ServeCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        return $this
            ->setName('serve')
            ->setDescription('Run a small web server')
            ->addOption('host', 'H', InputOption::VALUE_REQUIRED, 'The host to run on', 'localhost')
            ->addOption('port', 'P', InputOption::VALUE_REQUIRED, 'The port to run on', '8123');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $host = $input->getOption('host');
        $port = $input->getOption('port');
        $address = $host.':'.$port;

        $output->writeln('Starting webserver at http://'.$address);

        // Create process
        $process = new Process(sprintf('php -S %s public/index.php', $address));
        $process->setTimeout(null);
        $process->setIdleTimeout(null);

        /** @var ProcessHelper $processes */
        $processes = $this->getHelperSet()->get('process');
        $processes->mustRun($output, $process);
    }
}
