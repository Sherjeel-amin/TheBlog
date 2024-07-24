<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240704045326 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE addresses DROP FOREIGN KEY FK_6FCA75163CCE3900');
        $this->addSql('ALTER TABLE addresses DROP FOREIGN KEY FK_6FCA75169D86650F');
        $this->addSql('ALTER TABLE addresses DROP FOREIGN KEY FK_6FCA7516D8A48BBD');
        $this->addSql('ALTER TABLE addresses DROP FOREIGN KEY FK_6FCA7516DD71A5B');
        $this->addSql('DROP INDEX IDX_6FCA7516D8A48BBD ON addresses');
        $this->addSql('DROP INDEX IDX_6FCA7516DD71A5B ON addresses');
        $this->addSql('DROP INDEX IDX_6FCA75163CCE3900 ON addresses');
        $this->addSql('DROP INDEX IDX_6FCA75169D86650F ON addresses');
        $this->addSql('ALTER TABLE addresses ADD user_id INT NOT NULL, ADD city_id INT NOT NULL, ADD state_id INT NOT NULL, ADD country_id INT NOT NULL, DROP user_id_id, DROP city_id_id, DROP state_id_id, DROP country_id_id');
        $this->addSql('ALTER TABLE addresses ADD CONSTRAINT FK_6FCA7516A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE addresses ADD CONSTRAINT FK_6FCA75168BAC62AF FOREIGN KEY (city_id) REFERENCES cities (id)');
        $this->addSql('ALTER TABLE addresses ADD CONSTRAINT FK_6FCA75165D83CC1 FOREIGN KEY (state_id) REFERENCES states (id)');
        $this->addSql('ALTER TABLE addresses ADD CONSTRAINT FK_6FCA7516F92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id)');
        $this->addSql('CREATE INDEX IDX_6FCA7516A76ED395 ON addresses (user_id)');
        $this->addSql('CREATE INDEX IDX_6FCA75168BAC62AF ON addresses (city_id)');
        $this->addSql('CREATE INDEX IDX_6FCA75165D83CC1 ON addresses (state_id)');
        $this->addSql('CREATE INDEX IDX_6FCA7516F92F3E70 ON addresses (country_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE addresses DROP FOREIGN KEY FK_6FCA7516A76ED395');
        $this->addSql('ALTER TABLE addresses DROP FOREIGN KEY FK_6FCA75168BAC62AF');
        $this->addSql('ALTER TABLE addresses DROP FOREIGN KEY FK_6FCA75165D83CC1');
        $this->addSql('ALTER TABLE addresses DROP FOREIGN KEY FK_6FCA7516F92F3E70');
        $this->addSql('DROP INDEX IDX_6FCA7516A76ED395 ON addresses');
        $this->addSql('DROP INDEX IDX_6FCA75168BAC62AF ON addresses');
        $this->addSql('DROP INDEX IDX_6FCA75165D83CC1 ON addresses');
        $this->addSql('DROP INDEX IDX_6FCA7516F92F3E70 ON addresses');
        $this->addSql('ALTER TABLE addresses ADD user_id_id INT NOT NULL, ADD city_id_id INT NOT NULL, ADD state_id_id INT NOT NULL, ADD country_id_id INT NOT NULL, DROP user_id, DROP city_id, DROP state_id, DROP country_id');
        $this->addSql('ALTER TABLE addresses ADD CONSTRAINT FK_6FCA75163CCE3900 FOREIGN KEY (city_id_id) REFERENCES cities (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE addresses ADD CONSTRAINT FK_6FCA75169D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE addresses ADD CONSTRAINT FK_6FCA7516D8A48BBD FOREIGN KEY (country_id_id) REFERENCES countries (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE addresses ADD CONSTRAINT FK_6FCA7516DD71A5B FOREIGN KEY (state_id_id) REFERENCES states (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_6FCA7516D8A48BBD ON addresses (country_id_id)');
        $this->addSql('CREATE INDEX IDX_6FCA7516DD71A5B ON addresses (state_id_id)');
        $this->addSql('CREATE INDEX IDX_6FCA75163CCE3900 ON addresses (city_id_id)');
        $this->addSql('CREATE INDEX IDX_6FCA75169D86650F ON addresses (user_id_id)');
    }
}
