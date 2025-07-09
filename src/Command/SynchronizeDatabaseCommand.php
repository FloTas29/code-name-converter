<?php

namespace Cordon\CodeNameConverterBundle\Command;

use Cordon\CodeNameConverterBundle\Entity\MarketDevice;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SynchronizeDatabaseCommand extends Command
{
    protected static $defaultName = 'app:synchronize-database';
    protected static $defaultDescription = 'Synchronise la base de données de modèles';

    private EntityManagerInterface $em;
    private HttpClientInterface $httpClient;

    public function __construct(
        HttpClientInterface $httpClient,
        EntityManagerInterface $em
    ) {
        $this->httpClient = $httpClient;
        $this->em = $em;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName(self::$defaultName)
            ->setDescription(self::$defaultDescription)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $url = 'https://storage.googleapis.com/play_public/supported_devices.csv';

        $response = $this->httpClient->request('GET', $url);
        $csvContent = $response->getContent();
        $csvContent = mb_convert_encoding($csvContent, 'UTF-8', 'UTF-16LE');

        $lines = preg_split("/\R/", $csvContent);

        if (empty($lines)) {
            $output->writeln('<error>Le fichier CSV est vide.</error>');
            return 1;
        }

        // On met les index en durs parce que array_search ne trouve aps les valeurs
        $constructorIndex = 0;
        $marketingNameIndex = 1;
        $modelIndex = 3;

        $repo = $this->em->getRepository(MarketDevice::class);
        $updated = 0;

        $nbLines = count($lines);
        $output->writeln("<info>$nbLines modèles présents dans le fichier Google</info>");

        foreach ($lines as $key => $line) {
            $columns = str_getcsv($line);

            // On ignore les entêtes de colonnes
            if (count($columns) == 4) {
                /** @var MarketDevice|null $device */
                $device = $repo->findOneBy(['techModel' => $columns[$modelIndex]]);

                if (is_null($device)) {
                    $marketDevice = new MarketDevice();
                    $marketDevice->setManufacturer($columns[$constructorIndex]);
                    $marketDevice->setTechModel($columns[$modelIndex]);
                    $marketDevice->setMarketingModel($columns[$marketingNameIndex]);
                    $this->em->persist($marketDevice);
                    $updated++;
                }
            }
        }

        $this->em->flush();

        $output->writeln("<info>$updated appareils mis à jour</info>");
        return 0;
    }
}
