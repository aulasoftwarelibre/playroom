<?php

namespace App\Command;

use App\Entity\Degree;
use App\Repository\DegreeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

#[AsCommand(
    name: 'app:degrees:update',
    description: 'Actualiza la lista de títulos de la Universidad',
)]
final class DegreesUpdateCommand extends Command
{
    public function __construct(
        private DegreeRepository $degreeRepository,
        private EntityManagerInterface $manager,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $browser = new HttpBrowser(HttpClient::create());

        foreach (self::getLinks() as $link) {
            $degrees = $this->getDegreesFromWeb($browser, $link);

            foreach ($degrees as $degreeName) {
                $this->addDegree($degreeName, $link);
            }

            $this->manager->flush();
        }

        $io->success('Lista actualizada.');

        return Command::SUCCESS;
    }


    private static function getLinks(): array
    {
        return [
            [
                "type" => Degree::TYPE_DEGREE,
                "family" => Degree::FAMILY_ARTS,
                "url" => "https://www.uco.es/docencia/grados/artes-y-humanidades",
                "filter" => '.item-page > div > ul > li > a:first-child',
            ],
            [
                "type" => Degree::TYPE_DEGREE,
                "family" => Degree::FAMILY_SCIENCE,
                "url" => "https://www.uco.es/docencia/grados/grados-ciencias",
                "filter" => '.item-page > div > ul > li > a:first-child',
            ],
            [
                "type" => Degree::TYPE_DEGREE,
                "family" => Degree::FAMILY_HEALTH,
                "url" => "https://www.uco.es/docencia/grados/grados-ciencias-salud",
                "filter" => '.item-page > div > ul > li > a:first-child',
            ],
            [
                "type" => Degree::TYPE_DEGREE,
                "family" => Degree::FAMILY_SOCIAL,
                "url" => "https://www.uco.es/docencia/grados/grados-sociales-juridicas",
                "filter" => '.item-page > div > ul > li > a:first-child',
            ],
            [
                "type" => Degree::TYPE_DEGREE,
                "family" => Degree::FAMILY_ENGINEERING,
                "url" => "https://www.uco.es/docencia/grados/grados-ingenierias-arquitectura",
                "filter" => '.item-page > div > ul > li > a:first-child',
            ],
            [
                "type" => Degree::TYPE_MASTER,
                "family" => Degree::FAMILY_ARTS,
                "url" => "https://www.uco.es/estudios/idep/arte-y-humanidades",
                "filter" => 'tr > td > a:first-child',
            ],
            [
                "type" => Degree::TYPE_MASTER,
                "family" => Degree::FAMILY_SCIENCE,
                "url" => "https://www.uco.es/estudios/idep/ciencias",
                "filter" => 'tr > td > a:first-child',
            ],
            [
                "type" => Degree::TYPE_MASTER,
                "family" => Degree::FAMILY_HEALTH,
                "url" => "https://www.uco.es/estudios/idep/ciencias-de-la-salud",
                "filter" => 'tr > td > a:first-child',
            ],
            [
                "type" => Degree::TYPE_MASTER,
                "family" => Degree::FAMILY_SOCIAL,
                "url" => "https://www.uco.es/estudios/idep/ciencias-sociales-y-juridicas",
                "filter" => 'tr > td > a:first-child',
            ],
            [
                "type" => Degree::TYPE_MASTER,
                "family" => Degree::FAMILY_ENGINEERING,
                "url" => "https://www.uco.es/estudios/idep/ingenieria-y-arquitectura",
                "filter" => 'tr > td > a:first-child',
            ],
            [
                "type" => Degree::TYPE_DOCTOR,
                "family" => null,
                "url" => "https://www.uco.es/estudios/idep/menu-doctorado/programas-doctorado",
                "filter" => 'tr > td > ul > li > a:first-child',
            ],
            [
                "type" => Degree::TYPE_OTHERS,
                "family" => null,
                "url" => "https://www.uco.es/idep/menu-formacion-permanente/oferta-titulos-propios",
                "filter" => 'tr > td > a:first-child',
            ],
        ];
    }


    /**
     * @return string[]
     */
    protected function getDegreesFromWeb(HttpBrowser $browser, array $link): array
    {
        $crawler = $browser->request('GET', $link["url"]);

        return $crawler
            ->filter($link['filter'])
            ->each(fn(Crawler $node) => $node->text());
    }

    /**
     * @param array $link
     */
    protected function addDegree(string $degreeName, array $link): void
    {
        $degreeName = preg_replace('/\([\s\S]+?\)/', '', $degreeName);

        if ($this->degreeRepository->findOneBy(['name' => $degreeName, 'type' => $link['type']])) {
            return;
        }

        $degree = new Degree();
        $degree
            ->setName($degreeName)
            ->setType($link["type"])
            ->setFamily($link["family"]);

        $this->manager->persist($degree);
    }
}
