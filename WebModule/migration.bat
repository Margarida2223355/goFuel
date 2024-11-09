@echo off
set MIGRATIONS_PATH=\console\migrations

echo Running initial migration...
php %MIGRATIONS_PATH%\m130524_201442_init.php

echo Creating database...
php %MIGRATIONS_PATH%\m241106_230619_create_database.php

echo Setting up RBAC roles...
php %MIGRATIONS_PATH%\m241008_222306_init_rbac_roles.php

echo Running other migrations...
php %MIGRATIONS_PATH%\m241106_230900_create_categories_table.php
php %MIGRATIONS_PATH%\m241106_231001_create_client_station_table.php
php %MIGRATIONS_PATH%\m241106_231101_create_invoice_lines_table.php
php %MIGRATIONS_PATH%\m241106_231124_create_invoice_states_table.php
php %MIGRATIONS_PATH%\m241106_231140_create_invoices_table.php
php %MIGRATIONS_PATH%\m241106_231325_create_item_stocks_table.php
php %MIGRATIONS_PATH%\m241106_231423_create_items_table.php
php %MIGRATIONS_PATH%\m241106_231529_create_manager_station_table.php
php %MIGRATIONS_PATH%\m241106_232240_create_pumps_table.php
php %MIGRATIONS_PATH%\m241106_232317_create_station_items_table.php
php %MIGRATIONS_PATH%\m241106_232520_create_station_users_table.php
php %MIGRATIONS_PATH%\m241106_232550_create_stations_table.php
php %MIGRATIONS_PATH%\m241106_232647_create_subcategories_table.php
php %MIGRATIONS_PATH%\m241106_232735_create_user_info_table.php

echo All migrations completed!
pause
