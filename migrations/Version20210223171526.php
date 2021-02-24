<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210223171526 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin_agence CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE admin_agence ADD CONSTRAINT FK_3909AB50BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE admin_systeme CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE admin_systeme ADD CONSTRAINT FK_5145EF6ABF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE caissier CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE caissier ADD CONSTRAINT FK_1F038BC2BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user_agence CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE user_agence ADD CONSTRAINT FK_1938194BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin_agence DROP FOREIGN KEY FK_3909AB50BF396750');
        $this->addSql('ALTER TABLE admin_agence CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE admin_systeme DROP FOREIGN KEY FK_5145EF6ABF396750');
        $this->addSql('ALTER TABLE admin_systeme CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE caissier DROP FOREIGN KEY FK_1F038BC2BF396750');
        $this->addSql('ALTER TABLE caissier CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE `user` DROP type');
        $this->addSql('ALTER TABLE user_agence DROP FOREIGN KEY FK_1938194BF396750');
        $this->addSql('ALTER TABLE user_agence CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
