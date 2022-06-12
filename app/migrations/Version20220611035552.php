<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use App\Services\CountryCsvService as countryCsvService;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220611035552 extends AbstractMigration implements ContainerAwareInterface
{

    private ContainerInterface $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Country (id INT AUTO_INCREMENT NOT NULL, name LONGTEXT NOT NULL, abbreviation LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE Country');
    }

    public function postUp(Schema $schema): void
    {
        $this->loadCountries();
    }

    public function loadCountries()
    {
        $kernel = $this->container->get('kernel');
        $application = new \Symfony\Bundle\FrameworkBundle\Console\Application($kernel);
        $application->setAutoExit(false);

        //Loading Fixtures
        $options = array('command' => 'csv:importCountry', 'fileName' => 'country.csv');
        $application->run(new \Symfony\Component\Console\Input\ArrayInput($options));
    }
}
