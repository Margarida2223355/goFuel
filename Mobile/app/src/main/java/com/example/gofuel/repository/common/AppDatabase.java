package com.example.gofuel.repository.common;


import android.content.Context;
import androidx.room.Database;
import androidx.room.Room;
import androidx.room.RoomDatabase;
import androidx.room.TypeConverters;

import com.example.gofuel.model.category.CategoryConverter;
import com.example.gofuel.model.invoice.DateConverter;
import com.example.gofuel.model.invoice.Invoice;
import com.example.gofuel.model.invoice.InvoiceConverter;
import com.example.gofuel.model.invoice.InvoiceLine;
import com.example.gofuel.model.invoice.InvoicestateConverter;
import com.example.gofuel.model.item.Item;
import com.example.gofuel.model.item.ItemConverter;
import com.example.gofuel.model.pump.Pump;
import com.example.gofuel.model.pump.PumpConverter;
import com.example.gofuel.model.station.Station;
import com.example.gofuel.model.station.StationConverter;
import com.example.gofuel.model.subcategory.SubcategoryConverter;
import com.example.gofuel.model.user.UserConverter;
import com.example.gofuel.repository.invoice.local.InvoiceDB;
import com.example.gofuel.repository.invoiceLine.local.InvoiceLineDB;
import com.example.gofuel.repository.item.local.ItemDB;
import com.example.gofuel.repository.pump.local.PumpDB;
import com.example.gofuel.repository.station.local.StationDB;

@Database(
        entities = {Station.class, Pump.class, Item.class, Invoice.class, InvoiceLine.class},
        version = 1
)
@TypeConverters({StationConverter.class, CategoryConverter.class, InvoiceConverter.class, InvoicestateConverter.class, ItemConverter.class, PumpConverter.class, SubcategoryConverter.class, UserConverter.class, DateConverter.class})
public abstract class AppDatabase extends RoomDatabase {
    private static volatile AppDatabase INSTANCE;
    public abstract StationDB stationDB();
    public abstract PumpDB pumpDB();
    public abstract ItemDB itemDB();
    public abstract InvoiceDB invoiceDB();
    public abstract InvoiceLineDB invoiceLineDB();

    public static AppDatabase getDatabase(final Context context) {
        if (INSTANCE == null) {
            synchronized (AppDatabase.class) {
                if (INSTANCE == null) {
                    INSTANCE = Room.databaseBuilder(context.getApplicationContext(), AppDatabase.class, "app_database").build();
                }
            }
        }

        return INSTANCE;
    }
}
