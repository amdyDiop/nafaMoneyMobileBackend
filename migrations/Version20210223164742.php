<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210223164742 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin_agence (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin_systeme (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agences (id INT AUTO_INCREMENT NOT NULL, admin_agence_id INT DEFAULT NULL, telephone VARCHAR(14) NOT NULL, adresse VARCHAR(255) NOT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_B46015DD3ED2363F (admin_agence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE caissier (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clients (id INT AUTO_INCREMENT NOT NULL, nom_complet VARCHAR(255) NOT NULL, telephone VARCHAR(14) NOT NULL, cni VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comptes (id INT AUTO_INCREMENT NOT NULL, admin_systeme_id INT DEFAULT NULL, agence_id INT NOT NULL, caissiers_id INT NOT NULL, numero VARCHAR(255) NOT NULL, solde INT NOT NULL, created_at DATETIME NOT NULL, statut TINYINT(1) NOT NULL, INDEX IDX_56735801FC51D1AB (admin_systeme_id), UNIQUE INDEX UNIQ_56735801D725330D (agence_id), INDEX IDX_5673580156CF4096 (caissiers_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transactions (id INT AUTO_INCREMENT NOT NULL, en_cours_id INT DEFAULT NULL, complete_id INT DEFAULT NULL, montant INT NOT NULL, date_trans DATETIME NOT NULL, frais INT NOT NULL, frais_etat INT NOT NULL, frais_depot INT NOT NULL, frais_retrait INT NOT NULL, frais_systeme INT NOT NULL, INDEX IDX_EAA81A4C332C962B (en_cours_id), INDEX IDX_EAA81A4CEA40C2F (complete_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transactions_complete (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transactions_en_cours (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_agence (id INT AUTO_INCREMENT NOT NULL, agences_id INT DEFAULT NULL, INDEX IDX_19381949917E4AB (agences_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agences ADD CONSTRAINT FK_B46015DD3ED2363F FOREIGN KEY (admin_agence_id) REFERENCES admin_agence (id)');
        $this->addSql('ALTER TABLE comptes ADD CONSTRAINT FK_56735801FC51D1AB FOREIGN KEY (admin_systeme_id) REFERENCES admin_systeme (id)');
        $this->addSql('ALTER TABLE comptes ADD CONSTRAINT FK_56735801D725330D FOREIGN KEY (agence_id) REFERENCES agences (id)');
        $this->addSql('ALTER TABLE comptes ADD CONSTRAINT FK_5673580156CF4096 FOREIGN KEY (caissiers_id) REFERENCES caissier (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4C332C962B FOREIGN KEY (en_cours_id) REFERENCES transactions_en_cours (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CEA40C2F FOREIGN KEY (complete_id) REFERENCES transactions_complete (id)');
        $this->addSql('ALTER TABLE user_agence ADD CONSTRAINT FK_19381949917E4AB FOREIGN KEY (agences_id) REFERENCES agences (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agences DROP FOREIGN KEY FK_B46015DD3ED2363F');
        $this->addSql('ALTER TABLE comptes DROP FOREIGN KEY FK_56735801FC51D1AB');
        $this->addSql('ALTER TABLE comptes DROP FOREIGN KEY FK_56735801D725330D');
        $this->addSql('ALTER TABLE user_agence DROP FOREIGN KEY FK_19381949917E4AB');
        $this->addSql('ALTER TABLE comptes DROP FOREIGN KEY FK_5673580156CF4096');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4CEA40C2F');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4C332C962B');
        $this->addSql('DROP TABLE admin_agence');
        $this->addSql('DROP TABLE admin_systeme');
        $this->addSql('DROP TABLE agences');
        $this->addSql('DROP TABLE caissier');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE comptes');
        $this->addSql('DROP TABLE transactions');
        $this->addSql('DROP TABLE transactions_complete');
        $this->addSql('DROP TABLE transactions_en_cours');
        $this->addSql('DROP TABLE user_agence');
    }
}
