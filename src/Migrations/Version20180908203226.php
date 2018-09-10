<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180908203226 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE poi_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE poi_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE poi (id INT NOT NULL, point_type_id INT NOT NULL, project_id_id INT NOT NULL, name VARCHAR(120) NOT NULL, description VARCHAR(255) DEFAULT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7DBB1FD67298755F ON poi (point_type_id)');
        $this->addSql('CREATE INDEX IDX_7DBB1FD66C1197C9 ON poi (project_id_id)');
        $this->addSql('CREATE TABLE poi_type (id INT NOT NULL, name VARCHAR(64) DEFAULT NULL, description VARCHAR(255) NOT NULL, transport BOOLEAN DEFAULT NULL, parent_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE poi ADD CONSTRAINT FK_7DBB1FD67298755F FOREIGN KEY (point_type_id) REFERENCES poi_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE poi ADD CONSTRAINT FK_7DBB1FD66C1197C9 FOREIGN KEY (project_id_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE poi DROP CONSTRAINT FK_7DBB1FD67298755F');
        $this->addSql('DROP SEQUENCE poi_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE poi_type_id_seq CASCADE');
        $this->addSql('DROP TABLE poi');
        $this->addSql('DROP TABLE poi_type');
    }
}
