<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171222185059 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE authors (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE languages (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE books (id INT AUTO_INCREMENT NOT NULL, author INT DEFAULT NULL, genre INT DEFAULT NULL, language INT DEFAULT NULL, title VARCHAR(255) NOT NULL, image_name VARCHAR(255) NOT NULL, publication_date DATETIME NOT NULL, isbnnumber VARCHAR(255) NOT NULL, INDEX IDX_4A1B2A92BDAFD8C8 (author), INDEX IDX_4A1B2A92835033F8 (genre), INDEX IDX_4A1B2A92D4DB71B5 (language), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genres (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE books ADD CONSTRAINT FK_4A1B2A92BDAFD8C8 FOREIGN KEY (author) REFERENCES authors (id)');
        $this->addSql('ALTER TABLE books ADD CONSTRAINT FK_4A1B2A92835033F8 FOREIGN KEY (genre) REFERENCES genres (id)');
        $this->addSql('ALTER TABLE books ADD CONSTRAINT FK_4A1B2A92D4DB71B5 FOREIGN KEY (language) REFERENCES languages (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE books DROP FOREIGN KEY FK_4A1B2A92BDAFD8C8');
        $this->addSql('ALTER TABLE books DROP FOREIGN KEY FK_4A1B2A92D4DB71B5');
        $this->addSql('ALTER TABLE books DROP FOREIGN KEY FK_4A1B2A92835033F8');
        $this->addSql('DROP TABLE authors');
        $this->addSql('DROP TABLE languages');
        $this->addSql('DROP TABLE books');
        $this->addSql('DROP TABLE genres');
    }
}
