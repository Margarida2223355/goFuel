package com.example.gofuel.repository.client_station;


import com.example.gofuel.model.client_station.ClientStation;
import com.example.gofuel.repository.common.ResultWrapper;

import java.util.List;

public interface IClientStationDataSource {
    interface Common {}

    // Remote data source
    interface Remote {
        ResultWrapper<List<ClientStation>> getFavoriteStation();
    }

    // Local data source
    interface Local {
        ResultWrapper<ClientStation> getCachedFavorite();
    }

    interface Main extends Remote, Local {}
}
