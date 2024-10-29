<?php

use yii\db\Migration;

/**
 * Class m240925_011459_create_app_tables
 */
class m240925_011459_create_app_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%county}}', [
            'id' => $this->string()->notNull()->unique(), // Custom string ID
            'name' => $this->string()->defaultValue(null),
        ]);

        $this->createTable('{{%sub_county}}', [
            'id' => $this->string()->notNull()->unique(), // Custom string ID
            'name' => $this->string()->defaultValue(null),
            'county_id' => $this->string()->defaultValue(null),
            'FOREIGN KEY ([[county_id]]) REFERENCES {{%county}} ([[id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ]);

        $this->createTable('{{%word}}', [
            'id' => $this->string()->notNull()->unique(), // Custom string ID
            'name' => $this->string()->defaultValue(null),
            'sub_county_id' => $this->string()->defaultValue(null),
            'FOREIGN KEY ([[sub_county_id]]) REFERENCES {{%sub_county}} ([[id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ]);

        $this->createTable('{{%location}}', [
            'id' => $this->string()->notNull()->unique(), // Custom string ID
            'name' => $this->string()->defaultValue(null),
            'word_id' => $this->string()->defaultValue(null),
            'FOREIGN KEY ([[word_id]]) REFERENCES {{%word}} ([[id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ]);

        $this->createTable('{{%sub_location}}', [
            'id' => $this->string()->notNull()->unique(), // Custom string ID
            'name' => $this->string()->defaultValue(null),
            'location_id' => $this->string()->defaultValue(null),
            'FOREIGN KEY ([[location_id]]) REFERENCES {{%location}} ([[id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ]);

        $this->createTable('{{%village}}', [
            'id' => $this->string()->notNull()->unique(), // Custom string ID
            'name' => $this->string()->defaultValue(null),
            'sub_location_id' => $this->string()->defaultValue(null),
            'FOREIGN KEY ([[sub_location_id]]) REFERENCES {{%sub_location}} ([[id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ]);

        $this->createTable('{{%user}}', [
            'id' => $this->string()->notNull()->unique(), // Custom string ID
            'username' => $this->string()->notNull()->unique(),
            'verification_token' => $this->string()->defaultValue(null),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->string()->defaultValue(null),
            'updated_by' => $this->string()->defaultValue(null),
        ]);

        $this->createTable('{{%beneficiary}}', [
            'id' => $this->string()->notNull()->unique(), // Custom string ID
            'sub_location_id' => $this->string()->defaultValue(null),
            'village_id' => $this->string()->defaultValue(null),
            'name' => $this->string()->notNull(),
            'national_id' => $this->string()->defaultValue(null),
            'contact' => $this->string()->notNull(),
            'sub_location' => $this->string()->notNull(),
            'village' => $this->string()->notNull(),
            'stove_no' => $this->string()->notNull(),
            'issue_date' => $this->string(),
            'lat' => $this->string()->notNull(),
            'long' => $this->string()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->string()->defaultValue(null),
            'updated_by' => $this->string()->defaultValue(null),
        ]);

        $this->createTable('{{%activity}}', [
            'id' => $this->string()->notNull()->unique(), // Custom string ID
            'name' => $this->string()->notNull(),
            'reference_no' => $this->string()->notNull(),
            'start_date' => $this->string()->notNull(),
            'end_date' => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->string()->defaultValue(null),
            'updated_by' => $this->string()->defaultValue(null),
        ]);

        $this->createTable('{{%activity_report}}', [
            'id' => $this->string()->notNull()->unique(), // Custom string ID
            'activity_id' => $this->string()->defaultValue(null),
            'beneficiary_id' => $this->string()->defaultValue(null),
            'usage' => $this->string()->defaultValue(null),
            'condition' => $this->string()->defaultValue(null),
            'recommendation' => $this->string()->defaultValue(null),
            'remarks' => $this->string()->defaultValue(null),
            'created_at' => $this->integer()->defaultValue(null),
            'updated_at' => $this->integer()->defaultValue(null),
            'created_by' => $this->string()->defaultValue(null),
            'updated_by' => $this->string()->defaultValue(null),
        ]);

        $this->createTable('{{%coordinator}}', [
            'id' => $this->string()->notNull()->unique(), // Custom string ID
            'name' => $this->string()->notNull(),
            'user_id' => $this->string()->notNull(),
            'national_id' => $this->string()->defaultValue(null),
            'email' => $this->string()->notNull(),
            'phone_no' => $this->string()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->string()->defaultValue(null),
            'updated_by' => $this->string()->defaultValue(null),
            'FOREIGN KEY ([[user_id]]) REFERENCES {{%user}} ([[id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),

        ]);

        $this->createTable('{{%coordinator_sub_county}}', [
            'id' => $this->string()->notNull()->unique(), // Custom string ID
            'coordinator_id' => $this->string()->defaultValue(null),
            'sub_county_id' => $this->string()->defaultValue(null),
            'FOREIGN KEY ([[coordinator_id]]) REFERENCES {{%coordinator}} ([[id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
            'FOREIGN KEY ([[sub_county_id]]) REFERENCES {{%sub_county}} ([[id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ]);

        $this->createTable('{{%field_officer}}', [
            'id' => $this->string()->notNull()->unique(), // Custom string ID
            'name' => $this->string()->notNull(),
            'user_id' => $this->string()->notNull(),
            'national_id' => $this->string()->defaultValue(null),
            'coordinator_id' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'phone_no' => $this->string()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->string()->defaultValue(null),
            'updated_by' => $this->string()->defaultValue(null),
            'FOREIGN KEY ([[user_id]]) REFERENCES {{%user}} ([[id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),

        ]);

        $this->createTable('{{%officer_sub_location}}', [
            'id' => $this->string()->notNull()->unique(), // Custom string ID
            'officer_id' => $this->string()->defaultValue(null),
            'sub_location_id' => $this->string()->defaultValue(null),
            'FOREIGN KEY ([[officer_id]]) REFERENCES {{%field_officer}} ([[id]])' .
            $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
            'FOREIGN KEY ([[sub_location_id]]) REFERENCES {{%sub_location}} ([[id]])' .
            $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ]);

        $this->createTable('{{%ambassador}}', [
            'id' => $this->string()->notNull()->unique(), // Custom string ID
            'name' => $this->string()->notNull(),
            'user_id' => $this->string()->notNull(),
            'national_id' => $this->string()->defaultValue(null),
            'field_officer_id' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'phone_no' => $this->string()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->string()->defaultValue(null),
            'updated_by' => $this->string()->defaultValue(null),
            'FOREIGN KEY ([[user_id]]) REFERENCES {{%user}} ([[id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),

        ]);

        $this->createTable('{{%ambassador_village}}', [
            'id' => $this->string()->notNull()->unique(), // Custom string ID
            'ambassador_id' => $this->string()->defaultValue(null),
            'village_id' => $this->string()->defaultValue(null),
            'FOREIGN KEY ([[ambassador_id]]) REFERENCES {{%coordinator}} ([[id]])' .
            $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
            'FOREIGN KEY ([[village_id]]) REFERENCES {{%village}} ([[id]])' .
            $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ]);

        // Create RBAC tables in correct order
        $this->createTable('{{%auth_rule}}', [
            'name' => $this->string()->notNull(),
            'data' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'PRIMARY KEY (name)',
        ]);

        // Create auth_item table
        $this->createTable('{{%auth_item}}', [
            'name' => $this->string()->notNull(),
            'type' => $this->integer()->notNull(),
            'description' => $this->text(),
            'rule_name' => $this->string(),
            'data' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'PRIMARY KEY (name)',
            'KEY rule_name (rule_name)',
            'KEY type (type)',
        ]);

        // Create auth_item_child table
        $this->createTable('{{%auth_item_child}}', [
            'parent' => $this->string()->notNull(),
            'child' => $this->string()->notNull(),
            'PRIMARY KEY (parent, child)',
            'KEY child (child)',
            'FOREIGN KEY ([[parent]]) REFERENCES {{%auth_item}} ([[name]]) ' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
            'FOREIGN KEY ([[child]]) REFERENCES {{%auth_item}} ([[name]]) ' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ]);

        $this->createTable('{{%auth_assignment}}', [
            'item_name' => $this->string()->notNull(),
            'user_id' => $this->string()->notNull(),
            'created_at' => $this->integer(),
            'PRIMARY KEY (item_name, user_id)',
            'FOREIGN KEY ([[item_name]]) REFERENCES {{%auth_item}} ([[name]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop RBAC tables
        $this->dropTable('{{%auth_item_child}}');
        $this->dropTable('{{%permission}}');
        $this->dropTable('{{%auth_rule}}');
        $this->dropTable('{{%auth_item}}');
        $this->dropTable('{{%auth_assignment}}');
        $this->dropTable('{{%ambassador}}');
        $this->dropTable('{{%field_officer}}');
        $this->dropTable('{{%coordinator}}');
        $this->dropTable('{{%activity}}');
        $this->dropTable('{{%beneficiary}}');
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%village}}');
        $this->dropTable('{{%sub_location}}');
        $this->dropTable('{{%location}}');
        $this->dropTable('{{%word}}');
        $this->dropTable('{{%sub_county}}');
        $this->dropTable('{{%county}}');

    }

    protected function buildFkClause($delete = '', $update = '')
    {
        return implode(' ', ['', $delete, $update]);
    }
}
