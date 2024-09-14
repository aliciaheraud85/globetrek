<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240907081751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE travels ADD categories_id INT NOT NULL, ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE travels ADD CONSTRAINT FK_67FF2BD7A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE travels ADD CONSTRAINT FK_67FF2BD7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_67FF2BD7A21214B7 ON travels (categories_id)');
        $this->addSql('CREATE INDEX IDX_67FF2BD7A76ED395 ON travels (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE travels DROP FOREIGN KEY FK_67FF2BD7A21214B7');
        $this->addSql('ALTER TABLE travels DROP FOREIGN KEY FK_67FF2BD7A76ED395');
        $this->addSql('DROP INDEX IDX_67FF2BD7A21214B7 ON travels');
        $this->addSql('DROP INDEX IDX_67FF2BD7A76ED395 ON travels');
        $this->addSql('ALTER TABLE travels DROP categories_id, DROP user_id');
    }
}
