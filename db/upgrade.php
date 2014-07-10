<?php 
function xmldb_sna_upgrade($oldversion) {    
	global $CFG;     
	$result = TRUE; 
	   /* if ($oldversion < XXXXXXXXXX) {

        // Define table sna to be created.
        $table = new xmldb_table('sna');

        // Adding fields to table sna.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);

        // Adding keys to table sna.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for sna.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Sna savepoint reached.
        upgrade_mod_savepoint(true, XXXXXXXXXX, 'sna');
    }
	    if ($oldversion < XXXXXXXXXX) {

        // Define table sna to be dropped.
        $table = new xmldb_table('sna');

        // Conditionally launch drop table for sna.
        if ($dbman->table_exists($table)) {
            $dbman->drop_table($table);
        }

        // Sna savepoint reached.
        upgrade_mod_savepoint(true, XXXXXXXXXX, 'sna');
    }
	    if ($oldversion < XXXXXXXXXX) {

        // Define table sna to be renamed to NEWNAMEGOESHERE.
        $table = new xmldb_table('sna');

        // Launch rename table for sna.
        $dbman->rename_table($table, 'NEWNAMEGOESHERE');

        // Sna savepoint reached.
        upgrade_mod_savepoint(true, XXXXXXXXXX, 'sna');
    }
   */
	return $result;
}
