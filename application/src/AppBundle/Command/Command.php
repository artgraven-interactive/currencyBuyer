<?php

/* 
 * Created by Jacques Artgraven
 * 33a homestead, Rivonia
 * http://github.com/artgraven-interactive
 */

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('currency:update')
            ->setDescription('updating the Rates table from the jsonrates api')
            ->addOption(
                'currency',
                null,
                InputOption::VALUE_NONE,
                'If set, then only that currency will be updated'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
        if ($input->getOption('currency')) {
            //update this one currency
        }else{
            //update all currencies
        }

        $output->writeln('Rates table has been updated with the latest exchange rates completed');
    }
}