<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220624105946 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE player_tank RENAME INDEX idx_d793fbf0a76ed395 TO IDX_F08E70A99E6F5DF');
        $this->addSql('ALTER TABLE player_tank RENAME INDEX idx_d793fbf015c652b5 TO IDX_F08E70A15C652B5');
        $this->addSql('ALTER TABLE player_battle RENAME INDEX idx_76cb0c09a76ed395 TO IDX_8C9981EA99E6F5DF');
        $this->addSql('ALTER TABLE player_battle RENAME INDEX idx_76cb0c09c9732719 TO IDX_8C9981EAC9732719');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE player_battle RENAME INDEX idx_8c9981ea99e6f5df TO IDX_76CB0C09A76ED395');
        $this->addSql('ALTER TABLE player_battle RENAME INDEX idx_8c9981eac9732719 TO IDX_76CB0C09C9732719');
        $this->addSql('ALTER TABLE player_tank RENAME INDEX idx_f08e70a15c652b5 TO IDX_D793FBF015C652B5');
        $this->addSql('ALTER TABLE player_tank RENAME INDEX idx_f08e70a99e6f5df TO IDX_D793FBF0A76ED395');
    }
}
