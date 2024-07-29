<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240729153253 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingrediant CHANGE picture picture VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE recipe_ingrediant ADD recipe_id INT NOT NULL, ADD ingrediant_id INT NOT NULL');
        $this->addSql('ALTER TABLE recipe_ingrediant ADD CONSTRAINT FK_25D856CF59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE recipe_ingrediant ADD CONSTRAINT FK_25D856CF8AEA29A FOREIGN KEY (ingrediant_id) REFERENCES ingrediant (id)');
        $this->addSql('CREATE INDEX IDX_25D856CF59D8A214 ON recipe_ingrediant (recipe_id)');
        $this->addSql('CREATE INDEX IDX_25D856CF8AEA29A ON recipe_ingrediant (ingrediant_id)');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingrediant CHANGE picture picture VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\' COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE recipe_ingrediant DROP FOREIGN KEY FK_25D856CF59D8A214');
        $this->addSql('ALTER TABLE recipe_ingrediant DROP FOREIGN KEY FK_25D856CF8AEA29A');
        $this->addSql('DROP INDEX IDX_25D856CF59D8A214 ON recipe_ingrediant');
        $this->addSql('DROP INDEX IDX_25D856CF8AEA29A ON recipe_ingrediant');
        $this->addSql('ALTER TABLE recipe_ingrediant DROP recipe_id, DROP ingrediant_id');
    }
}
