<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240916142427 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE forum (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, picture LONGBLOB DEFAULT NULL, description VARCHAR(300) NOT NULL, location VARCHAR(255) NOT NULL, INDEX IDX_852BBECDA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stand (id INT AUTO_INCREMENT NOT NULL, forum_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, picture LONGBLOB DEFAULT NULL, description VARCHAR(255) NOT NULL, capacity INT NOT NULL, duration TIME NOT NULL, INDEX IDX_64B918B629CCBAD0 (forum_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE timeslot (id INT AUTO_INCREMENT NOT NULL, stand_id INT DEFAULT NULL, start_date_time TIME NOT NULL, INDEX IDX_3BE452F79734D487 (stand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE timeslot_team (timeslot_id INT NOT NULL, team_id INT NOT NULL, INDEX IDX_908C0A24F920B9E9 (timeslot_id), INDEX IDX_908C0A24296CD8AE (team_id), PRIMARY KEY(timeslot_id, team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_team (user_id INT NOT NULL, team_id INT NOT NULL, INDEX IDX_BE61EAD6A76ED395 (user_id), INDEX IDX_BE61EAD6296CD8AE (team_id), PRIMARY KEY(user_id, team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE forum ADD CONSTRAINT FK_852BBECDA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE stand ADD CONSTRAINT FK_64B918B629CCBAD0 FOREIGN KEY (forum_id) REFERENCES forum (id)');
        $this->addSql('ALTER TABLE timeslot ADD CONSTRAINT FK_3BE452F79734D487 FOREIGN KEY (stand_id) REFERENCES stand (id)');
        $this->addSql('ALTER TABLE timeslot_team ADD CONSTRAINT FK_908C0A24F920B9E9 FOREIGN KEY (timeslot_id) REFERENCES timeslot (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE timeslot_team ADD CONSTRAINT FK_908C0A24296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_team ADD CONSTRAINT FK_BE61EAD6A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_team ADD CONSTRAINT FK_BE61EAD6296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD owned_teams_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649EA66177E FOREIGN KEY (owned_teams_id) REFERENCES team (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649EA66177E ON user (owned_teams_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649EA66177E');
        $this->addSql('ALTER TABLE forum DROP FOREIGN KEY FK_852BBECDA76ED395');
        $this->addSql('ALTER TABLE stand DROP FOREIGN KEY FK_64B918B629CCBAD0');
        $this->addSql('ALTER TABLE timeslot DROP FOREIGN KEY FK_3BE452F79734D487');
        $this->addSql('ALTER TABLE timeslot_team DROP FOREIGN KEY FK_908C0A24F920B9E9');
        $this->addSql('ALTER TABLE timeslot_team DROP FOREIGN KEY FK_908C0A24296CD8AE');
        $this->addSql('ALTER TABLE user_team DROP FOREIGN KEY FK_BE61EAD6A76ED395');
        $this->addSql('ALTER TABLE user_team DROP FOREIGN KEY FK_BE61EAD6296CD8AE');
        $this->addSql('DROP TABLE forum');
        $this->addSql('DROP TABLE stand');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE timeslot');
        $this->addSql('DROP TABLE timeslot_team');
        $this->addSql('DROP TABLE user_team');
        $this->addSql('DROP INDEX IDX_8D93D649EA66177E ON `user`');
        $this->addSql('ALTER TABLE `user` DROP owned_teams_id');
    }
}
