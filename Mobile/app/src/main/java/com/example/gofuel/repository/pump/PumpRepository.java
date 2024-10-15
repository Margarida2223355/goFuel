package com.example.gofuel.repository.pump;

import android.content.Context;

import com.example.gofuel.model.pump.Pump;
import com.example.gofuel.repository.common.AppDatabase;
import com.example.gofuel.repository.common.ResultWrapper;
import com.example.gofuel.repository.pump.local.PumpDB;
import com.example.gofuel.repository.pump.remote.PumpRemoteDataSource;

import java.util.List;

public class PumpRepository implements IPumpDataSource.Main {
    private static PumpRepository instance;
    private final PumpDB pumpDB;

    private PumpRepository(Context context) {
        AppDatabase db = AppDatabase.getDatabase(context);
        pumpDB = db.pumpDB();
    }

    public static PumpRepository getInstance(Context context) {
        if (instance == null) {
            instance = new PumpRepository(context);
        }

        return instance;
    }

    @Override
    public ResultWrapper<Pump> getCachedPump() {
        return null;
    }

    @Override
    public ResultWrapper<List<Pump>> getPumps() {
        ResultWrapper<List<Pump>> result = new PumpRemoteDataSource().getPumps();

        if (result.getResult() != null) {
            pumpDB.deleteAll();
            pumpDB.addAll(result.getResult());
        }
        else {
            // If there's data on local DB, return it
            if(!pumpDB.getAllPumps().isEmpty()) { result = new ResultWrapper <>(pumpDB.getAllPumps(), null); }

            // If there's no data on local DB, return an Error
            else { result = new ResultWrapper<>(null, "No data on local DB"); }
        }

        return result;
    }
}
