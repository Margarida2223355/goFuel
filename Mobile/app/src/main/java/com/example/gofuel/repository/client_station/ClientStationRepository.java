package com.example.gofuel.repository.client_station;

import android.content.Context;

import com.example.gofuel.model.client_station.ClientStation;
import com.example.gofuel.model.item.Item;
import com.example.gofuel.repository.client_station.local.ClientStationDB;
import com.example.gofuel.repository.client_station.remote.ClientStationRemoteDataSource;
import com.example.gofuel.repository.common.AppDatabase;
import com.example.gofuel.repository.common.ResultWrapper;
import com.example.gofuel.repository.item.local.ItemDB;
import com.example.gofuel.repository.item.remote.ItemRemoteDataSource;

import java.util.List;

public class ClientStationRepository implements IClientStationDataSource.Main {
    private static ClientStationRepository instance;
    private final ClientStationDB clientStationDB;

    private ClientStationRepository(Context context) {
        AppDatabase db = AppDatabase.getDatabase(context);
        clientStationDB = db.clientStationDB();
    }

    public static ClientStationRepository getInstance(Context context) {
        if (instance == null) {
            instance = new ClientStationRepository(context);
        }

        return instance;
    }

    @Override
    public ResultWrapper<ClientStation> getCachedFavorite() {
        return null;
    }

    @Override
    public ResultWrapper<List<ClientStation>> getFavoriteStation() {
        ResultWrapper<List<ClientStation>> result = new ClientStationRemoteDataSource().getFavoriteStation();

        if (result.getResult() != null) {
            clientStationDB.deleteAll();
            clientStationDB.addAll(result.getResult());
        }
        else {
            // If there's data on local DB, return it
            if(!clientStationDB.getFavoriteStation().isEmpty()) { result = new ResultWrapper <>(clientStationDB.getFavoriteStation(), null); }

            // If there's no data on local DB, return an Error
            else { result = new ResultWrapper<>(null, "No data on local DB"); }
        }

        return result;
    }
}
