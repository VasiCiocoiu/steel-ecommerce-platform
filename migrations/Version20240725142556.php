<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240725142556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, provider_id INT DEFAULT NULL, delivery_id INT DEFAULT NULL, warehouse_id INT DEFAULT NULL, street VARCHAR(255) NOT NULL, postal_code INT NOT NULL, city VARCHAR(255) NOT NULL, INDEX IDX_D4E6F81A76ED395 (user_id), UNIQUE INDEX UNIQ_D4E6F81A53A8AA (provider_id), INDEX IDX_D4E6F8112136921 (delivery_id), UNIQUE INDEX UNIQ_D4E6F815080ECDE (warehouse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bill (id INT AUTO_INCREMENT NOT NULL, bill_number INT NOT NULL, bil_date TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', tva DOUBLE PRECISION NOT NULL, total_htc DOUBLE PRECISION NOT NULL, user_name VARCHAR(50) NOT NULL, siret INT NOT NULL, company_name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bill_line (id INT AUTO_INCREMENT NOT NULL, unit_price DOUBLE PRECISION NOT NULL, product_name VARCHAR(255) NOT NULL, cut_length DOUBLE PRECISION NOT NULL, product_quantity INT NOT NULL, discount DOUBLE PRECISION NOT NULL, cut_price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bill_line_dimension (bill_line_id INT NOT NULL, dimension_id INT NOT NULL, INDEX IDX_D3548089B9B8415D (bill_line_id), INDEX IDX_D3548089277428AD (dimension_id), PRIMARY KEY(bill_line_id, dimension_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, address_id INT DEFAULT NULL, user_id INT DEFAULT NULL, siret INT NOT NULL, name_company VARCHAR(50) NOT NULL, INDEX IDX_4FBF094FF5B7AF75 (address_id), INDEX IDX_4FBF094FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE delivery (id INT AUTO_INCREMENT NOT NULL, bill_id INT NOT NULL, delivery_status VARCHAR(50) NOT NULL, delivery_price DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_3781EC101A8C12F5 (bill_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dimension (id INT AUTO_INCREMENT NOT NULL, stock_id INT DEFAULT NULL, size_a INT DEFAULT NULL, size_b INT DEFAULT NULL, size_c INT DEFAULT NULL, size_d INT DEFAULT NULL, size_e INT DEFAULT NULL, unit_price DOUBLE PRECISION NOT NULL, linear_mass DOUBLE PRECISION NOT NULL, product VARCHAR(255) NOT NULL, INDEX IDX_CA9BC19CDCD6110 (stock_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discussion (id INT AUTO_INCREMENT NOT NULL, message VARCHAR(255) NOT NULL, destination VARCHAR(52) NOT NULL, send_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item_manager (id INT AUTO_INCREMENT NOT NULL, order_line_id INT DEFAULT NULL, bill_line_id INT DEFAULT NULL, type_item_manager VARCHAR(255) NOT NULL, quote_status VARCHAR(255) NOT NULL, INDEX IDX_F17903EDBB01DC09 (order_line_id), INDEX IDX_F17903EDB9B8415D (bill_line_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, receiver INT NOT NULL, message_content LONGTEXT NOT NULL, send_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_line (id INT AUTO_INCREMENT NOT NULL, quantity INT NOT NULL, cut_length DOUBLE PRECISION NOT NULL, cut_price DOUBLE PRECISION NOT NULL, discount DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_line_dimension (order_line_id INT NOT NULL, dimension_id INT NOT NULL, INDEX IDX_12E8EA5EBB01DC09 (order_line_id), INDEX IDX_12E8EA5E277428AD (dimension_id), PRIMARY KEY(order_line_id, dimension_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, dimension_id INT DEFAULT NULL, product_name VARCHAR(50) NOT NULL, product_description VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, INDEX IDX_D34A04AD277428AD (dimension_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE provider (id INT AUTO_INCREMENT NOT NULL, stock_id INT DEFAULT NULL, address_id INT NOT NULL, provider_name VARCHAR(50) NOT NULL, INDEX IDX_92C4739CDCD6110 (stock_id), UNIQUE INDEX UNIQ_92C4739CF5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock (id INT AUTO_INCREMENT NOT NULL, stock_quantity INT NOT NULL, stock_length DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, bill_id INT DEFAULT NULL, item_manager_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, phone_number VARCHAR(20) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, INDEX IDX_8D93D6491A8C12F5 (bill_id), INDEX IDX_8D93D649C58F1C69 (item_manager_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visitor (id INT AUTO_INCREMENT NOT NULL, item_manager_id INT DEFAULT NULL, token_visitor VARCHAR(32) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_CAE5E19FC58F1C69 (item_manager_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE warehouse (id INT AUTO_INCREMENT NOT NULL, stock_id INT DEFAULT NULL, address_id INT NOT NULL, warehouse_name VARCHAR(50) NOT NULL, INDEX IDX_ECB38BFCDCD6110 (stock_id), UNIQUE INDEX UNIQ_ECB38BFCF5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81A53A8AA FOREIGN KEY (provider_id) REFERENCES provider (id)');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F8112136921 FOREIGN KEY (delivery_id) REFERENCES delivery (id)');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F815080ECDE FOREIGN KEY (warehouse_id) REFERENCES warehouse (id)');
        $this->addSql('ALTER TABLE bill_line_dimension ADD CONSTRAINT FK_D3548089B9B8415D FOREIGN KEY (bill_line_id) REFERENCES bill_line (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bill_line_dimension ADD CONSTRAINT FK_D3548089277428AD FOREIGN KEY (dimension_id) REFERENCES dimension (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE delivery ADD CONSTRAINT FK_3781EC101A8C12F5 FOREIGN KEY (bill_id) REFERENCES bill (id)');
        $this->addSql('ALTER TABLE dimension ADD CONSTRAINT FK_CA9BC19CDCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('ALTER TABLE item_manager ADD CONSTRAINT FK_F17903EDBB01DC09 FOREIGN KEY (order_line_id) REFERENCES order_line (id)');
        $this->addSql('ALTER TABLE item_manager ADD CONSTRAINT FK_F17903EDB9B8415D FOREIGN KEY (bill_line_id) REFERENCES bill_line (id)');
        $this->addSql('ALTER TABLE order_line_dimension ADD CONSTRAINT FK_12E8EA5EBB01DC09 FOREIGN KEY (order_line_id) REFERENCES order_line (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_line_dimension ADD CONSTRAINT FK_12E8EA5E277428AD FOREIGN KEY (dimension_id) REFERENCES dimension (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD277428AD FOREIGN KEY (dimension_id) REFERENCES dimension (id)');
        $this->addSql('ALTER TABLE provider ADD CONSTRAINT FK_92C4739CDCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('ALTER TABLE provider ADD CONSTRAINT FK_92C4739CF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6491A8C12F5 FOREIGN KEY (bill_id) REFERENCES bill (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649C58F1C69 FOREIGN KEY (item_manager_id) REFERENCES item_manager (id)');
        $this->addSql('ALTER TABLE visitor ADD CONSTRAINT FK_CAE5E19FC58F1C69 FOREIGN KEY (item_manager_id) REFERENCES item_manager (id)');
        $this->addSql('ALTER TABLE warehouse ADD CONSTRAINT FK_ECB38BFCDCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('ALTER TABLE warehouse ADD CONSTRAINT FK_ECB38BFCF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
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
