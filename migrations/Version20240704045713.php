<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240704045713 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blogs DROP FOREIGN KEY FK_F41BCA709D86650F');
        $this->addSql('DROP INDEX IDX_F41BCA709D86650F ON blogs');
        $this->addSql('ALTER TABLE blogs CHANGE user_id_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE blogs ADD CONSTRAINT FK_F41BCA70A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F41BCA70A76ED395 ON blogs (user_id)');
        $this->addSql('ALTER TABLE cities DROP FOREIGN KEY FK_D95DB16BDD71A5B');
        $this->addSql('DROP INDEX IDX_D95DB16BDD71A5B ON cities');
        $this->addSql('ALTER TABLE cities CHANGE state_id_id state_id INT NOT NULL');
        $this->addSql('ALTER TABLE cities ADD CONSTRAINT FK_D95DB16B5D83CC1 FOREIGN KEY (state_id) REFERENCES states (id)');
        $this->addSql('CREATE INDEX IDX_D95DB16B5D83CC1 ON cities (state_id)');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A8FABDD9F');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A9D86650F');
        $this->addSql('DROP INDEX IDX_5F9E962A8FABDD9F ON comments');
        $this->addSql('DROP INDEX IDX_5F9E962A9D86650F ON comments');
        $this->addSql('ALTER TABLE comments ADD blog_id INT NOT NULL, ADD user_id INT NOT NULL, DROP blog_id_id, DROP user_id_id');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962ADAE07E97 FOREIGN KEY (blog_id) REFERENCES blogs (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5F9E962ADAE07E97 ON comments (blog_id)');
        $this->addSql('CREATE INDEX IDX_5F9E962AA76ED395 ON comments (user_id)');
        $this->addSql('ALTER TABLE states DROP FOREIGN KEY FK_31C2774DD8A48BBD');
        $this->addSql('DROP INDEX IDX_31C2774DD8A48BBD ON states');
        $this->addSql('ALTER TABLE states CHANGE country_id_id country_id INT NOT NULL');
        $this->addSql('ALTER TABLE states ADD CONSTRAINT FK_31C2774DF92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id)');
        $this->addSql('CREATE INDEX IDX_31C2774DF92F3E70 ON states (country_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE states DROP FOREIGN KEY FK_31C2774DF92F3E70');
        $this->addSql('DROP INDEX IDX_31C2774DF92F3E70 ON states');
        $this->addSql('ALTER TABLE states CHANGE country_id country_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE states ADD CONSTRAINT FK_31C2774DD8A48BBD FOREIGN KEY (country_id_id) REFERENCES countries (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_31C2774DD8A48BBD ON states (country_id_id)');
        $this->addSql('ALTER TABLE blogs DROP FOREIGN KEY FK_F41BCA70A76ED395');
        $this->addSql('DROP INDEX IDX_F41BCA70A76ED395 ON blogs');
        $this->addSql('ALTER TABLE blogs CHANGE user_id user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE blogs ADD CONSTRAINT FK_F41BCA709D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_F41BCA709D86650F ON blogs (user_id_id)');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962ADAE07E97');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AA76ED395');
        $this->addSql('DROP INDEX IDX_5F9E962ADAE07E97 ON comments');
        $this->addSql('DROP INDEX IDX_5F9E962AA76ED395 ON comments');
        $this->addSql('ALTER TABLE comments ADD blog_id_id INT NOT NULL, ADD user_id_id INT NOT NULL, DROP blog_id, DROP user_id');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A8FABDD9F FOREIGN KEY (blog_id_id) REFERENCES blogs (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_5F9E962A8FABDD9F ON comments (blog_id_id)');
        $this->addSql('CREATE INDEX IDX_5F9E962A9D86650F ON comments (user_id_id)');
        $this->addSql('ALTER TABLE cities DROP FOREIGN KEY FK_D95DB16B5D83CC1');
        $this->addSql('DROP INDEX IDX_D95DB16B5D83CC1 ON cities');
        $this->addSql('ALTER TABLE cities CHANGE state_id state_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE cities ADD CONSTRAINT FK_D95DB16BDD71A5B FOREIGN KEY (state_id_id) REFERENCES states (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D95DB16BDD71A5B ON cities (state_id_id)');
    }
}
