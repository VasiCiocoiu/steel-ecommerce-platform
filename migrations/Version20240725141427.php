<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240725141427 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs


    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F81A76ED395');
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F81A53A8AA');
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F8112136921');
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F815080ECDE');
        $this->addSql('ALTER TABLE bill_line_dimension DROP FOREIGN KEY FK_D3548089B9B8415D');
        $this->addSql('ALTER TABLE bill_line_dimension DROP FOREIGN KEY FK_D3548089277428AD');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094FF5B7AF75');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094FA76ED395');
        $this->addSql('ALTER TABLE delivery DROP FOREIGN KEY FK_3781EC101A8C12F5');
        $this->addSql('ALTER TABLE dimension DROP FOREIGN KEY FK_CA9BC19CDCD6110');
        $this->addSql('ALTER TABLE item_manager DROP FOREIGN KEY FK_F17903EDBB01DC09');
        $this->addSql('ALTER TABLE item_manager DROP FOREIGN KEY FK_F17903EDB9B8415D');
        $this->addSql('ALTER TABLE order_line_dimension DROP FOREIGN KEY FK_12E8EA5EBB01DC09');
        $this->addSql('ALTER TABLE order_line_dimension DROP FOREIGN KEY FK_12E8EA5E277428AD');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD277428AD');
        $this->addSql('ALTER TABLE provider DROP FOREIGN KEY FK_92C4739CDCD6110');
        $this->addSql('ALTER TABLE provider DROP FOREIGN KEY FK_92C4739CF5B7AF75');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6491A8C12F5');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649C58F1C69');
        $this->addSql('ALTER TABLE visitor DROP FOREIGN KEY FK_CAE5E19FC58F1C69');
        $this->addSql('ALTER TABLE warehouse DROP FOREIGN KEY FK_ECB38BFCDCD6110');
        $this->addSql('ALTER TABLE warehouse DROP FOREIGN KEY FK_ECB38BFCF5B7AF75');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE bill');
        $this->addSql('DROP TABLE bill_line');
        $this->addSql('DROP TABLE bill_line_dimension');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE delivery');
        $this->addSql('DROP TABLE dimension');
        $this->addSql('DROP TABLE discussion');
        $this->addSql('DROP TABLE item_manager');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE order_line');
        $this->addSql('DROP TABLE order_line_dimension');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE provider');
        $this->addSql('DROP TABLE stock');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE visitor');
        $this->addSql('DROP TABLE warehouse');
    }
}
