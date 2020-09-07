<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200906231106 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE worker (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(50) NOT NULL, name VARCHAR(50) NOT NULL, username VARCHAR(50) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(50) NOT NULL, recruitment_date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_for_operation (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(50) NOT NULL, name VARCHAR(50) NOT NULL, phone VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operation (id INT AUTO_INCREMENT NOT NULL, id_worker_id INT DEFAULT NULL, id_customer_id INT NOT NULL, id_operation_type_id INT NOT NULL, start_date DATE NOT NULL, end_date DATE DEFAULT NULL, comment LONGTEXT NOT NULL, INDEX IDX_1981A66DEB150611 (id_worker_id), INDEX IDX_1981A66D8B870E04 (id_customer_id), INDEX IDX_1981A66D97BA6449 (id_operation_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66DEB150611 FOREIGN KEY (id_worker_id) REFERENCES worker (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66D8B870E04 FOREIGN KEY (id_customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66D97BA6449 FOREIGN KEY (id_operation_type_id) REFERENCES type_for_operation (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66D8B870E04');
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66D97BA6449');
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66DEB150611');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE operation');
        $this->addSql('DROP TABLE type_for_operation');
        $this->addSql('DROP TABLE worker');
    }
}
