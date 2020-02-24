<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200218152913 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, group_name VARCHAR(255) NOT NULL, INDEX IDX_6DC044C567B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `group` ADD CONSTRAINT FK_6DC044C567B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE friendship CHANGE user_id user_id INT DEFAULT NULL, CHANGE friend_id friend_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD mygroups_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64913A5EDE0 FOREIGN KEY (mygroups_id) REFERENCES `group` (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64913A5EDE0 ON user (mygroups_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64913A5EDE0');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('ALTER TABLE friendship CHANGE user_id user_id INT DEFAULT NULL, CHANGE friend_id friend_id INT DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_8D93D64913A5EDE0 ON user');
        $this->addSql('ALTER TABLE user DROP mygroups_id, CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
