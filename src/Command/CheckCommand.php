<?php

namespace App\Command;

use Spatie\SslCertificate\SslCertificate;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CheckCommand extends Command
{
    protected static $defaultName = 'check';
    protected static $defaultDescription = 'check certs for domain';

    protected function configure(): void
    {
        $this
            ->addArgument('domains', InputArgument::IS_ARRAY, 'Domains list')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $domainsList = array_unique(array_filter($input->getArgument('domains')));

        foreach ($domainsList as $domain) {
            $io->note('check domain: '. $domain);
            try {
                $sslCert = SslCertificate::createForHostName($domain);
                $isValid = $sslCert->isValid();
                if (!$isValid) {
                    $io->warning([
                        'domain' => $domain,
                        'message' => 'is not valid'
                    ]);
                }
            } catch (\Exception $exception) {
                $io->caution($exception->getMessage());
            }
        }

        $io->success('All domains are checked');

        return Command::SUCCESS;
    }
}
