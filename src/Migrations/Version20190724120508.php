<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190724120508 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE duckuser (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, email VARCHAR(64) NOT NULL, duckname VARCHAR(64) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json_array)\', photo VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_4386BC59E7927C74 (email), UNIQUE INDEX UNIQ_4386BC5990361416 (duckname), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quack (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, parent_id INT DEFAULT NULL, content LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT NULL, tags VARCHAR(255) DEFAULT NULL, photo VARCHAR(500) DEFAULT NULL, INDEX IDX_83D44F6FF675F31B (author_id), INDEX IDX_83D44F6F727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quack ADD CONSTRAINT FK_83D44F6FF675F31B FOREIGN KEY (author_id) REFERENCES duckuser (id)');
        $this->addSql('ALTER TABLE quack ADD CONSTRAINT FK_83D44F6F727ACA70 FOREIGN KEY (parent_id) REFERENCES quack (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE quack DROP FOREIGN KEY FK_83D44F6FF675F31B');
        $this->addSql('ALTER TABLE quack DROP FOREIGN KEY FK_83D44F6F727ACA70');
        $this->addSql('DROP TABLE duckuser');
        $this->addSql('DROP TABLE quack');
    }
}
