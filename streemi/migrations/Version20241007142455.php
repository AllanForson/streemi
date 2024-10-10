<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241007142455 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE user_subscription (user_id INT NOT NULL, subscription_id INT NOT NULL, INDEX IDX_230A18D1A76ED395 (user_id), INDEX IDX_230A18D19A1887DC (subscription_id), PRIMARY KEY(user_id, subscription_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_subscription ADD CONSTRAINT FK_230A18D1A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_subscription ADD CONSTRAINT FK_230A18D19A1887DC FOREIGN KEY (subscription_id) REFERENCES subscription (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user CHANGE account_status account_status VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_subscription DROP FOREIGN KEY FK_230A18D1A76ED395');
        $this->addSql('ALTER TABLE user_subscription DROP FOREIGN KEY FK_230A18D19A1887DC');
        $this->addSql('DROP TABLE user_subscription');
        $this->addSql('ALTER TABLE `user` CHANGE account_status account_status LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\'');
    }
}
