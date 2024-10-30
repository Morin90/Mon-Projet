<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241030091430 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE frame (id INT AUTO_INCREMENT NOT NULL, size VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE frame_velo (frame_id INT NOT NULL, velo_id INT NOT NULL, INDEX IDX_E17112083FA3C347 (frame_id), INDEX IDX_E1711208EC6AC5BD (velo_id), PRIMARY KEY(frame_id, velo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transmission (id INT AUTO_INCREMENT NOT NULL, number INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transmission_velo (transmission_id INT NOT NULL, velo_id INT NOT NULL, INDEX IDX_5AF6C10678D28519 (transmission_id), INDEX IDX_5AF6C106EC6AC5BD (velo_id), PRIMARY KEY(transmission_id, velo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wheel (id INT AUTO_INCREMENT NOT NULL, size VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wheel_velo (wheel_id INT NOT NULL, velo_id INT NOT NULL, INDEX IDX_805921649AF5772F (wheel_id), INDEX IDX_80592164EC6AC5BD (velo_id), PRIMARY KEY(wheel_id, velo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE frame_velo ADD CONSTRAINT FK_E17112083FA3C347 FOREIGN KEY (frame_id) REFERENCES frame (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE frame_velo ADD CONSTRAINT FK_E1711208EC6AC5BD FOREIGN KEY (velo_id) REFERENCES velo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transmission_velo ADD CONSTRAINT FK_5AF6C10678D28519 FOREIGN KEY (transmission_id) REFERENCES transmission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transmission_velo ADD CONSTRAINT FK_5AF6C106EC6AC5BD FOREIGN KEY (velo_id) REFERENCES velo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wheel_velo ADD CONSTRAINT FK_805921649AF5772F FOREIGN KEY (wheel_id) REFERENCES wheel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wheel_velo ADD CONSTRAINT FK_80592164EC6AC5BD FOREIGN KEY (velo_id) REFERENCES velo (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE frame_velo DROP FOREIGN KEY FK_E17112083FA3C347');
        $this->addSql('ALTER TABLE frame_velo DROP FOREIGN KEY FK_E1711208EC6AC5BD');
        $this->addSql('ALTER TABLE transmission_velo DROP FOREIGN KEY FK_5AF6C10678D28519');
        $this->addSql('ALTER TABLE transmission_velo DROP FOREIGN KEY FK_5AF6C106EC6AC5BD');
        $this->addSql('ALTER TABLE wheel_velo DROP FOREIGN KEY FK_805921649AF5772F');
        $this->addSql('ALTER TABLE wheel_velo DROP FOREIGN KEY FK_80592164EC6AC5BD');
        $this->addSql('DROP TABLE frame');
        $this->addSql('DROP TABLE frame_velo');
        $this->addSql('DROP TABLE transmission');
        $this->addSql('DROP TABLE transmission_velo');
        $this->addSql('DROP TABLE wheel');
        $this->addSql('DROP TABLE wheel_velo');
    }
}
