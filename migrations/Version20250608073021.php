<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250608073021 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE panelist_survey (panelist_id INT NOT NULL, survey_id INT NOT NULL, INDEX IDX_DBB192DC7E8B14D (panelist_id), INDEX IDX_DBB192DCB3FE509D (survey_id), PRIMARY KEY(panelist_id, survey_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE panelist_survey ADD CONSTRAINT FK_DBB192DC7E8B14D FOREIGN KEY (panelist_id) REFERENCES panelist (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE panelist_survey ADD CONSTRAINT FK_DBB192DCB3FE509D FOREIGN KEY (survey_id) REFERENCES survey (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE panelist_survey DROP FOREIGN KEY FK_DBB192DC7E8B14D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE panelist_survey DROP FOREIGN KEY FK_DBB192DCB3FE509D
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE panelist_survey
        SQL);
    }
}
