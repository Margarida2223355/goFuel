package com.example.gofuel.repository.station_item;

import android.content.Context;

import com.example.gofuel.model.station.Station;
import com.example.gofuel.model.station_item.StationItem;
import com.example.gofuel.repository.common.AppDatabase;
import com.example.gofuel.repository.common.ResultWrapper;
import com.example.gofuel.repository.station_item.local.StationItemDB;
import com.example.gofuel.repository.station_item.remote.StationItemRemoteDataSource;

import java.util.List;

public class StationItemRepository implements IStationItemDataSource.Main {
    private static StationItemRepository instance;
    private final StationItemDB stationItemDB;

    public StationItemRepository(Context context) {
        AppDatabase db = AppDatabase.getDatabase(context);
        stationItemDB = db.stationItemDB();
    }

    public static StationItemRepository getInstance(Context context) {
        if (instance == null) {
            instance = new StationItemRepository(context);
        }

        return instance;
    }

    @Override
    public ResultWrapper<StationItem> getCachedItem() {
        return null;
    }

    @Override
    public ResultWrapper<List<StationItem>> getStationItems() {
        return null;
    }

    @Override
    public ResultWrapper<List<StationItem>> getStationItems(Station station) {
        ResultWrapper<List<StationItem>> result = new StationItemRemoteDataSource(station).getStationItems();

        if (result.getResult() != null) {
            stationItemDB.deleteAll();
            stationItemDB.addAll(result.getResult());
        }
        else {
            // If there's data on local DB, return it
            if(!stationItemDB.getStationItems().isEmpty()) { result = new ResultWrapper <>(stationItemDB.getStationItems(), null); }

            // If there's no data on local DB, return an Error
            else { result = new ResultWrapper<>(null, "No data on local DB"); }
        }

        return result;
    }
}
