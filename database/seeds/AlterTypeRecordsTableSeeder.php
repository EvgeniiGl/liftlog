<?php

use Illuminate\Database\Seeder;

class AlterTypeRecordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sqlChangeTypeToId = 'UPDATE records SET type = coalesce((SELECT cast(id as nvarchar) FROM types WHERE LOWER(records.type) = LOWER(types.title)),records.type)';

        DB::statement($sqlChangeTypeToId);
        $sqlChangeTypeColumn = 'ALTER TABLE records ALTER COLUMN type bigint';

        DB::statement($sqlChangeTypeColumn);

        $sqlChangeTypeNameColumn = "exec sp_rename 'records.type', type_id, 'COLUMN'";

        DB::statement($sqlChangeTypeNameColumn);

        $sqlAddForeiignKey = "ALTER TABLE records ADD FOREIGN KEY (type_id) REFERENCES types(id)";

        DB::statement($sqlAddForeiignKey);

    }
}
