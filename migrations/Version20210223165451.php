<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210223165451 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE depot (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE caissier ADD depot_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE caissier ADD CONSTRAINT FK_1F038BC28510D4DE FOREIGN KEY (depot_id) REFERENCES depot (id)');
        $this->addSql('CREATE INDEX IDX_1F038BC28510D4DE ON caissier (depot_id)');
        $this->addSql('ALTER TABLE comptes DROP FOREIGN KEY FK_5673580156CF4096');
        $this->addSql('DROP INDEX IDX_5673580156CF4096 ON comptes');
        $this->addSql('ALTER TABLE comptes DROP caissiers_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE caissier DROP FOREIGN KEY FK_1F038BC28510D4DE');
        $this->addSql('DROP TABLE depot');
        $this->addSql('DROP INDEX IDX_1F038BC28510D4DE ON caissier');
        $this->addSql('ALTER TABLE caissier DROP depot_id');
        $this->addSql('ALTER TABLE comptes ADD caissiers_id INT NOT NULL');
        $this->addSql('ALTER TABLE comptes ADD CONSTRAINT FK_5673580156CF4096 FOREIGN KEY (caissiers_id) REFERENCES caissier (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_5673580156CF4096 ON comptes (caissiers_id)');
    }
}
