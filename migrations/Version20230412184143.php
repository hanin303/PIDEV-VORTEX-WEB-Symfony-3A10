<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230412184143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE moyen_transport CHANGE station_id station_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation CHANGE heure_depart heure_depart TIME NOT NULL, CHANGE heure_arrive heure_arrive TIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE moyen_transport CHANGE station_id station_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservation CHANGE heure_depart heure_depart VARCHAR(255) NOT NULL, CHANGE heure_arrive heure_arrive VARCHAR(255) NOT NULL');
    }
}
