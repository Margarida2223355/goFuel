package com.example.gofuel.repository.common;


import android.content.Context;
import androidx.room.Database;
import androidx.room.Room;
import androidx.room.RoomDatabase;
import androidx.room.TypeConverters;

import com.example.gofuel.model.pump.Pump;
import com.example.gofuel.model.station.Station;
import com.example.gofuel.model.station.StationConverter;
import com.example.gofuel.repository.pump.local.PumpDB;
import com.example.gofuel.repository.station.local.StationDB;

@Database(
        entities = {Station.class, Pump.class},
        version = 1
)
@TypeConverters({StationConverter.class})
public abstract class AppDatabase extends RoomDatabase {
    private static volatile AppDatabase INSTANCE;
    public abstract StationDB stationDB();
    public abstract PumpDB pumpDB();

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
