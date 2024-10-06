package com.example.gofuel.repository.station;

import android.content.Context;
import android.util.Log;

import com.example.gofuel.model.Station;
import com.example.gofuel.repository.common.AppDatabase;
import com.example.gofuel.repository.common.ResultWrapper;
import com.example.gofuel.repository.station.local.StationDB;
import com.example.gofuel.repository.station.remote.StationRemoteDataSource;

import java.util.List;
import java.util.concurrent.Executors;

public class StationRepository implements IStationDataSource.Main {
    private static StationRepository instance;
    private final StationDB stationDB;

    private StationRepository(Context context) {
        AppDatabase db = AppDatabase.getDatabase(context);
        stationDB = db.stationDB();
    }

    public static StationRepository getInstance(Context context) {
        if (instance == null) {
            instance = new StationRepository(context);
        }

        return instance;
    }

    @Override
    public ResultWrapper<Station> getCachedStation() {
        return null;
    }

    @Override
    public ResultWrapper<List<Station>> getStations() {
        ResultWrapper<List<Station>> result = new StationRemoteDataSource().getStations();

        //
        if (result.getResult() != null) {
            stationDB.deleteAll();
            stationDB.addAll(result.getResult());
        }
        else {
            // If there's data on local DB, return it
            if(!stationDB.getAllStations().isEmpty()) { result = new ResultWrapper<>(stationDB.getAllStations(), null); }

            // If there's no data on local DB, return an Error
            else { result = new ResultWrapper<>(null, "No data on local DB"); }
        }

        return result;
    }
}
