<?php

use yii\db\Migration;

class m170412_172827_tbl_subscribe extends Migration
{
    public function up()
    {
        $this->execute("
        
CREATE TABLE IF NOT EXISTS `subscribe` (
  `idsubscribe` int(11) NOT NULL,
  `email` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_subscribe` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
  
 
ALTER TABLE `subscribe`
  ADD PRIMARY KEY (`idsubscribe`);

ALTER TABLE `subscribe`
  MODIFY `idsubscribe` int(11) NOT NULL AUTO_INCREMENT;
  
        ");
    }

    public function down()
    {
        $this->dropTable("subscribe");
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
