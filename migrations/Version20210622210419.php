<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210622210419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create tables account, account_holder, transaction.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account (id INT AUTO_INCREMENT NOT NULL, account_holder_id INT NOT NULL, iban VARCHAR(22) NOT NULL, balance INT NOT NULL, UNIQUE INDEX UNIQ_7D3656A4FC94BA8B (account_holder_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE account_holder (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, origin_id INT DEFAULT NULL, target_id INT DEFAULT NULL, reference VARCHAR(255) NOT NULL, authorization VARCHAR(255) NOT NULL, submitter_id VARCHAR(255) NOT NULL, amount INT NOT NULL, INDEX IDX_723705D156A273CC (origin_id), INDEX IDX_723705D1158E0B66 (target_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE account ADD CONSTRAINT FK_7D3656A4FC94BA8B FOREIGN KEY (account_holder_id) REFERENCES account_holder (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D156A273CC FOREIGN KEY (origin_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1158E0B66 FOREIGN KEY (target_id) REFERENCES account (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D156A273CC');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1158E0B66');
        $this->addSql('ALTER TABLE account DROP FOREIGN KEY FK_7D3656A4FC94BA8B');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE account_holder');
        $this->addSql('DROP TABLE transaction');
    }
}
