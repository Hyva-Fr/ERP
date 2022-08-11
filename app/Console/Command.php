<?php

namespace App\Console;

use Illuminate\Console\Command as IlluminateCommand;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends IlluminateCommand
{
    public function run(InputInterface $input, OutputInterface $output)
    {
        // Set extra colors.
        // The most problem is $output->getFormatter() don't work...
        // So create new formatter to add extra color.

        $formatter = new OutputFormatter($output->isDecorated());
        $formatter->setStyle('red', new OutputFormatterStyle('red'));
        $formatter->setStyle('green', new OutputFormatterStyle('green'));
        $formatter->setStyle('yellow', new OutputFormatterStyle('yellow'));
        $formatter->setStyle('blue', new OutputFormatterStyle('blue'));
        $formatter->setStyle('magenta', new OutputFormatterStyle('magenta'));
        $output->setFormatter($formatter);

        $result = parent::run($input, $output);
    }
}