<?php

namespace App\Command;

use App\Services\CountryCsvService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


class CountryCsvImportCommand extends Command
{
    protected static $defaultName = 'csv:importCountry';
    private CountryCsvService $countryCsvService;

    public function __construct(CountryCsvService $countryCsvService)
    {
        parent::__construct();
        $this->countryCsvService = $countryCsvService;
    }

    protected function configure()
    {
        $this->setDescription('Import countries by csv');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int 1
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $hasImportedCsv = $this->countryCsvService->convertCsvToCountry('country.csv');
        $io = new SymfonyStyle($input, $output);
        if ($hasImportedCsv) {
            $io->success('Country imported!');
            return Command::SUCCESS;
        } else {
            $io->error('Country don\'t imported');
            return Command::FAILURE;
        }
    }

}