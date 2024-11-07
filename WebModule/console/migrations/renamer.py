import os

original_files = [
    "create_database.php",
    "create_categories_table.php",
    "create_subcategories_table.php",
    "create_stations_table.php",
    "create_user_info_table.php",
    "create_client_station_table.php",
    "create_invoice_lines_table.php",
    "create_invoice_states_table.php",
    "create_invoices_table.php",
    "create_item_stocks_table.php",
    "create_items_table.php",
    "create_manager_station_table.php",
    "create_pumps_table.php",
    "create_station_items_table.php",
    "create_station_users_table.php"
]

target_files = [
    "m241107_153001_create_categories_table.php",
    "m241107_153002_create_subcategories_table.php",
    "m241107_153003_create_stations_table.php",
    "m241107_153004_create_user_info_table.php",
    "m241107_153005_create_client_station_table.php",
    "m241107_153006_create_invoice_lines_table.php",
    "m241107_153007_create_invoice_states_table.php",
    "m241107_153008_create_invoices_table.php",
    "m241107_153009_create_item_stocks_table.php",
    "m241107_153010_create_items_table.php",
    "m241107_153011_create_manager_station_table.php",
    "m241107_153012_create_pumps_table.php",
    "m241107_153013_create_station_items_table.php",
    "m241107_153014_create_station_users_table.php"
]

import os
for file in os.listdir("."):
    for original_filename in original_files:
        if file.endswith(".php") and not file.endswith("init.php") and not file.endswith("to_user_table.php") and not file.endswith("init_rbac_roles.php") and file.find(original_filename):
            for desired_filename in target_files:
                if desired_filename.find(original_filename) and not os.path.exists(desired_filename):
                    print(f"FROM {file} to {desired_filename}")
                    os.rename(file, desired_filename)
                    break
                    