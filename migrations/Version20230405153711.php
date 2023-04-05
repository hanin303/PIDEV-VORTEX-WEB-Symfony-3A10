<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230405153711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonces (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date_annonce VARCHAR(255) NOT NULL, INDEX IDX_CB988C6F79F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commune (id INT AUTO_INCREMENT NOT NULL, nom_commune VARCHAR(255) NOT NULL, long_alt VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE iteneraire (id INT AUTO_INCREMENT NOT NULL, pts_depart VARCHAR(255) NOT NULL, pts_arrive VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne (id INT AUTO_INCREMENT NOT NULL, nom_ligne VARCHAR(255) NOT NULL, type_ligne VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE moyen_transport (id INT AUTO_INCREMENT NOT NULL, id_ligne_id INT NOT NULL, station_id INT NOT NULL, matricule INT NOT NULL, num INT NOT NULL, capacite INT NOT NULL, type_vehicule VARCHAR(255) NOT NULL, marque VARCHAR(255) NOT NULL, etat VARCHAR(255) NOT NULL, INDEX IDX_F42537D8A9862E3 (id_ligne_id), INDEX IDX_F42537D821BDB235 (station_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, objet VARCHAR(255) NOT NULL, message_rec VARCHAR(255) NOT NULL, statut VARCHAR(255) NOT NULL, date_rec DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, id_client_id INT NOT NULL, id_moy_id INT NOT NULL, id_it_id INT NOT NULL, date_reservation DATE NOT NULL, heure_depart VARCHAR(255) NOT NULL, heure_arrive VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, type_ticket VARCHAR(255) NOT NULL, INDEX IDX_42C8495599DED506 (id_client_id), INDEX IDX_42C84955B7CA1B62 (id_moy_id), INDEX IDX_42C84955C1D888F8 (id_it_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE station (id INT AUTO_INCREMENT NOT NULL, long_alt VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, id_reservation_id INT NOT NULL, status VARCHAR(255) NOT NULL, prix VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_97A0ADA385542AE1 (id_reservation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trajet (id INT AUTO_INCREMENT NOT NULL, id_it_id INT NOT NULL, temps_parcours VARCHAR(255) NOT NULL, pts_depart VARCHAR(255) NOT NULL, pts_arrive VARCHAR(255) NOT NULL, INDEX IDX_2B5BA98CC1D888F8 (id_it_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, id_role_id INT NOT NULL, id_state_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, num_tel INT NOT NULL, cin INT NOT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_8D93D64989E8BDC (id_role_id), INDEX IDX_8D93D6495503D054 (id_state_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_state (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6F79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE moyen_transport ADD CONSTRAINT FK_F42537D8A9862E3 FOREIGN KEY (id_ligne_id) REFERENCES ligne (id)');
        $this->addSql('ALTER TABLE moyen_transport ADD CONSTRAINT FK_F42537D821BDB235 FOREIGN KEY (station_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495599DED506 FOREIGN KEY (id_client_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955B7CA1B62 FOREIGN KEY (id_moy_id) REFERENCES moyen_transport (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955C1D888F8 FOREIGN KEY (id_it_id) REFERENCES iteneraire (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA385542AE1 FOREIGN KEY (id_reservation_id) REFERENCES reservation (id)');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98CC1D888F8 FOREIGN KEY (id_it_id) REFERENCES iteneraire (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64989E8BDC FOREIGN KEY (id_role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495503D054 FOREIGN KEY (id_state_id) REFERENCES user_state (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6F79F37AE5');
        $this->addSql('ALTER TABLE moyen_transport DROP FOREIGN KEY FK_F42537D8A9862E3');
        $this->addSql('ALTER TABLE moyen_transport DROP FOREIGN KEY FK_F42537D821BDB235');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495599DED506');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955B7CA1B62');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955C1D888F8');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA385542AE1');
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98CC1D888F8');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64989E8BDC');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495503D054');
        $this->addSql('DROP TABLE annonces');
        $this->addSql('DROP TABLE commune');
        $this->addSql('DROP TABLE iteneraire');
        $this->addSql('DROP TABLE ligne');
        $this->addSql('DROP TABLE moyen_transport');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE station');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE trajet');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_state');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
