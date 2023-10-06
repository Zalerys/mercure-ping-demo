<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220206195955 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Create the User table
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Create the Conversation table
        $this->addSql('CREATE TABLE conversation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Create the Conversation Member table
        $this->addSql('CREATE TABLE conversation_member (id INT AUTO_INCREMENT NOT NULL, conversation_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(id), INDEX IDX_C2F597EF7CFBF611 (conversation_id), INDEX IDX_C2F597EFA76ED395 (user_id), CONSTRAINT FK_C2F597EF7CFBF611 FOREIGN KEY (conversation_id) REFERENCES conversation (id) ON DELETE CASCADE, CONSTRAINT FK_C2F597EFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Create the Message table
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, conversation_id INT NOT NULL, user_id INT NOT NULL, content TEXT NOT NULL, date_sent DATETIME NOT NULL, PRIMARY KEY(id), INDEX IDX_947452BF7CFBF611 (conversation_id), INDEX IDX_947452BFA76ED395 (user_id), CONSTRAINT FK_947452BF7CFBF611 FOREIGN KEY (conversation_id) REFERENCES conversation (id) ON DELETE CASCADE, CONSTRAINT FK_947452BFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        //create chat
        $this->addSql('INSERT INTO conversation (name) VALUES ("All Users")');

    }

    public function down(Schema $schema): void
    {
        // Drop the Message table
        $this->addSql('DROP TABLE message');

        // Drop the Conversation Member table
        $this->addSql('DROP TABLE conversation_member');

        // Drop the Conversation table
        $this->addSql('DROP TABLE conversation');

        // Drop the User table
        $this->addSql('DROP TABLE user');
        }       
}
