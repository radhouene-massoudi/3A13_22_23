<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231016131801 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A653165F469 FOREIGN KEY (idRefStade) REFERENCES stade (refStade)');
        $this->addSql('CREATE INDEX IDX_98197A653165F469 ON player (idRefStade)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A653165F469');
        $this->addSql('DROP INDEX IDX_98197A653165F469 ON player');
    }
}
