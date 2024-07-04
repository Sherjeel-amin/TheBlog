<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240704044149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE addresses (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, city_id_id INT NOT NULL, state_id_id INT NOT NULL, country_id_id INT NOT NULL, street VARCHAR(255) NOT NULL, pincode INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_6FCA75169D86650F (user_id_id), INDEX IDX_6FCA75163CCE3900 (city_id_id), INDEX IDX_6FCA7516DD71A5B (state_id_id), INDEX IDX_6FCA7516D8A48BBD (country_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blogs (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, title VARCHAR(100) NOT NULL, body LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_F41BCA709D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cities (id INT AUTO_INCREMENT NOT NULL, state_id_id INT NOT NULL, name VARCHAR(100) NOT NULL, INDEX IDX_D95DB16BDD71A5B (state_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, blog_id_id INT NOT NULL, user_id_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_5F9E962A8FABDD9F (blog_id_id), INDEX IDX_5F9E962A9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE countries (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE states (id INT AUTO_INCREMENT NOT NULL, country_id_id INT NOT NULL, name VARCHAR(100) NOT NULL, INDEX IDX_31C2774DD8A48BBD (country_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(50) NOT NULL, email VARCHAR(100) NOT NULL, bio VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, gender VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE addresses ADD CONSTRAINT FK_6FCA75169D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE addresses ADD CONSTRAINT FK_6FCA75163CCE3900 FOREIGN KEY (city_id_id) REFERENCES cities (id)');
        $this->addSql('ALTER TABLE addresses ADD CONSTRAINT FK_6FCA7516DD71A5B FOREIGN KEY (state_id_id) REFERENCES states (id)');
        $this->addSql('ALTER TABLE addresses ADD CONSTRAINT FK_6FCA7516D8A48BBD FOREIGN KEY (country_id_id) REFERENCES countries (id)');
        $this->addSql('ALTER TABLE blogs ADD CONSTRAINT FK_F41BCA709D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cities ADD CONSTRAINT FK_D95DB16BDD71A5B FOREIGN KEY (state_id_id) REFERENCES states (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A8FABDD9F FOREIGN KEY (blog_id_id) REFERENCES blogs (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE states ADD CONSTRAINT FK_31C2774DD8A48BBD FOREIGN KEY (country_id_id) REFERENCES countries (id)');
        $this->addSql('DROP TABLE posts');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE posts (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE addresses DROP FOREIGN KEY FK_6FCA75169D86650F');
        $this->addSql('ALTER TABLE addresses DROP FOREIGN KEY FK_6FCA75163CCE3900');
        $this->addSql('ALTER TABLE addresses DROP FOREIGN KEY FK_6FCA7516DD71A5B');
        $this->addSql('ALTER TABLE addresses DROP FOREIGN KEY FK_6FCA7516D8A48BBD');
        $this->addSql('ALTER TABLE blogs DROP FOREIGN KEY FK_F41BCA709D86650F');
        $this->addSql('ALTER TABLE cities DROP FOREIGN KEY FK_D95DB16BDD71A5B');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A8FABDD9F');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A9D86650F');
        $this->addSql('ALTER TABLE states DROP FOREIGN KEY FK_31C2774DD8A48BBD');
        $this->addSql('DROP TABLE addresses');
        $this->addSql('DROP TABLE blogs');
        $this->addSql('DROP TABLE cities');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE countries');
        $this->addSql('DROP TABLE states');
        $this->addSql('DROP TABLE user');
    }
}
