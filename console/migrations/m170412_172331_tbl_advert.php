<?php

use yii\db\Migration;

class m170412_172331_tbl_advert extends Migration
{
    public function up()
    {

        $this->execute("


CREATE TABLE IF NOT EXISTS `advert` (
  `idadvert` int(11) NOT NULL,
  `price` mediumint(11) DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_user` mediumint(11) DEFAULT NULL,
  `bedroom` smallint(11) DEFAULT NULL,
  `livinroom` smallint(11) DEFAULT NULL,
  `parking` smallint(11) DEFAULT NULL,
  `kitchen` smallint(11) DEFAULT NULL,
  `general_image` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `location` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hot` smallint(1) DEFAULT NULL,
  `sold` smallint(1) DEFAULT NULL,
  `type` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `recommend` smallint(1) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `advert`
  ADD PRIMARY KEY (`idadvert`);

ALTER TABLE `advert`
  MODIFY `idadvert` int(11) NOT NULL AUTO_INCREMENT;


 ");


    }

    public function down()
    {
       $this->dropTable("advert");

    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
